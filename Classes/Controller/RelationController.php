<?php

namespace Macopedia\Community\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010 Pascal Jungblut <mail@pascalj.de>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use Macopedia\Community\Domain\Model\User;
use Macopedia\Community\Domain\Model\Relation;
use Macopedia\Community\Exception;

/**
 * The relation controller.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Pascal Jungblut <mail@pascalj.com>
 */
class RelationController extends BaseController
{

    /**
     * Display some of user's friends
     */
    public function listSomeAction()
    {
        $relations = $this->repositoryService->get('relation')->findRelationsForUser($this->getRequestedUser(), $this->settings['relations']['listSome']['limit']);
        $relationNumber = $relations->count(); // TODO: this only counts until the limit is reached!
        $users = array();
        foreach ($relations as $relation) {
            /* @var $relation Relation */
            if ($relation->getRequestedUser()->getUid() == $this->getRequestedUser()->getUid()) {
                $users[$relation->getUid()] = $relation->getInitiatingUser();
            } else {
                $users[$relation->getUid()] = $relation->getRequestedUser();
            }
        }
        $this->view->assign('usersRelations', $users);
        $this->view->assign('countRelations', $relationNumber);
    }

    /**
     * List all relations.
     */
    public function listAction()
    {
        $relations = $this->repositoryService->get('relation')->findRelationsForUser($this->getRequestedUser());
        $this->view->assign('relations', $relations);
    }

    /**
     * Requests a relation between two users. It will set the status to NEW.
     *
     * @param User $user
     * @throws Exception\UnexpectedException
     * @return void
     * @see Relation
     */
    public function requestAction(User $user)
    {
        if (!$user->getUid() || !$this->getRequestingUser()->getUid()
            || $user->getUid() == $this->getRequestingUser()->getUid()
        ) {
            $this->addFlashMessage($this->_('relation.request.fail'), \TYPO3\CMS\Core\Messaging\FlashMessage::NOTICE);
            $this->redirectToUser($this->getRequestingUser());
        }
        $relation = $this->repositoryService->get('relation')->findRelationBetweenUsers($user, $this->getRequestingUser());
        if ($relation === NULL) {
            //Normal request
            $this->addFlashMessage($this->_('relation.request.pending'));

            // set the details for the relation
            $relation = new Relation();
            $relation->setInitiatingUser($this->getRequestingUser());
            $relation->setRequestedUser($user);
            $relation->setStatus(Relation::RELATION_STATUS_NEW);
            $this->repositoryService->get('relation')->add($relation);

            // we have to persist now to get the uid of the new created relation in email notification
            $persistenceManager = $this->objectManager->get('TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager');
            /* @var $persistenceManager \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager */
            $persistenceManager->persistAll();

            // we must notify about new relation
            $this->notify('relationRequest');
        } elseif ($relation instanceof Relation) {
            $this->requestedExistingRelation($relation, $user);
        } else {
            // more than one relation? something is wrong.
            throw new Exception\UnexpectedException(
                'There are more than one relations between user ' . $user->getUid() . ' and user ' . $this->getRequestingUser()->getUid()
            );
        }

        $this->redirectToUser($user);
    }

    /**
     * Used in requestAction() when requested relation exists
     *
     * @param Relation $relation
     * @param User $user user with who we want to be friends
     * @throws Exception\UnexpectedException
     * @return void
     */
    protected function requestedExistingRelation(Relation $relation, User $user)
    {

        switch ($relation->getStatus()) {

            case Relation::RELATION_STATUS_NEW:
                if ($relation->getRequestedUser() == $user) {
                    $this->addFlashMessage($this->_('relation.request.alreadyPending'), '', \TYPO3\CMS\Core\Messaging\FlashMessage::NOTICE);
                } else {
                    // if both sides request friendship, it's ok
                    $this->addFlashMessage($this->_('relation.confirm.success'));
                    $this->confirmRelation($relation);
                }
                break;

            case Relation::RELATION_STATUS_CONFIRMED:
                $this->addFlashMessage($this->_('relation.request.alreadyFriends'), '', \TYPO3\CMS\Core\Messaging\FlashMessage::INFO);
                break;

            case Relation::RELATION_STATUS_REJECTED:
            case Relation::RELATION_STATUS_CANCELLED:
                $relation->setRequestedUser($user);
                $relation->setInitiatingUser($this->getRequestingUser());
                $relation->setStatus(Relation::RELATION_STATUS_NEW);
                $this->repositoryService->get('relation')->update($relation);
                $this->addFlashMessage($this->_('relation.request.pending'));
                $this->notify('relationRequest');
                break;

            default:
                throw new Exception\UnexpectedException(
                    'Unknown relation status between user ' . $user->getUid() . ' and user ' . $this->getRequestingUser()->getUid()
                );
                break;
        }
    }

    /**
     * Confirm a relation
     *
     * @param Relation $relation
     */
    public function confirmAction(Relation $relation)
    {
        if ($relation->getRequestedUser()->getUid() == $this->getRequestingUser()->getUid()) {
            $this->confirmRelation($relation);
            $this->addFlashMessage($this->_('relation.confirm.success'));
        }
        $this->redirectToUser($this->getRequestingUser());
    }


    /**
     * Reject a relation which hasn't been accepted yet
     *
     * @param Relation $relation
     * @return void
     */
    public function rejectAction(Relation $relation)
    {
        $this->rejectRelation($relation);
        if ($this->getRequestingUser()->getUid() == $relation->getInitiatingUser()->getUid()) {
            //abandoning my friend request
            $this->addFlashMessage($this->_('relation.abandon.success'));
            $this->notify('relationAbandonRequest');
        } else {
            //rejecting somebody else's friend request
            $this->addFlashMessage($this->_('relation.reject.success'));
            $this->notify('relationRejectRequest');
        }
        $this->redirectToUser($this->getRequestedUser());
    }

    /**
     * List all unconfirmed relations
     *
     * @return void
     */
    public function unconfirmedAction()
    {
        if ($this->ownProfile()) {
            $this->view->assign('unconfirmedRelations', $this->repositoryService->get('relation')->findUnconfirmedForUser(
                $this->getRequestingUser())
            );
        } else {
            $this->view->assign('unconfirmedRelations', array());
        }
    }

    /**
     * Cancel a relation that is already accepted.
     *
     * @param Relation $relation
     * @param User $user
     * @throws Exception\UnexpectedException
     * @return void
     */
    public function cancelAction(Relation $relation = NULL, User $user = NULL)
    {
        if ($relation === NULL) {
            if ($user !== NULL) {
                $relation = $this->repositoryService->get('relation')->findRelationBetweenUsers($user, $this->getRequestingUser());
            } else {
                throw new Exception\UnexpectedException("One of the parameters must be set");
            }
        }
        if ($this->request->hasArgument('confirmCancel')) {
            $this->cancelRelation($relation);
            $requestedUser = $this->getRequestedUser();
            $this->addFlashMessage($this->_('relation.cancel.success', array($requestedUser->getName())));
            $this->redirectToUser($requestedUser);
        }
    }

    /**
     * Confirm a relation and notify the initiating user
     *
     * @param Relation $relation
     * @return void
     */
    protected function confirmRelation(Relation $relation)
    {
        $relation->setStatus(Relation::RELATION_STATUS_CONFIRMED);
        $initiationTime = new \DateTime('@' . $GLOBALS['EXEC_TIME']);
        $relation->setInitiationTime($initiationTime);
        $this->repositoryService->get('relation')->update($relation);
        $this->notify('relationConfirm');
    }

    /**
     * Reject a relation and notify the initiating user
     *
     * @param Relation $relation
     * @return void
     */
    protected function rejectRelation(Relation $relation)
    {
        $relation->setStatus(Relation::RELATION_STATUS_REJECTED);
        $this->repositoryService->get('relation')->update($relation);
    }

    /**
     * Cancel a friend request and notify the initiating user
     *
     * @param Relation $relation
     * @return void
     */
    protected function cancelFriendRequest(Relation $relation)
    {
        $relation->setStatus(Relation::RELATION_STATUS_REJECTED);
        $this->repositoryService->get('relation')->update($relation);
        $this->notify('relationRequestCancel');
    }

    /**
     * Cancel a relation. Happens when an initiating user cancels the request _or_ if
     * an accepted relation gets cancelled by one of the users.
     *
     * @param Relation $relation
     * @return void
     */
    protected function cancelRelation(Relation $relation)
    {
        $relation->setStatus(Relation::RELATION_STATUS_CANCELLED);
        $this->repositoryService->get('relation')->update($relation);
        $this->notify('relationCancel');
    }

    /**
     * Send notification from requestingUser to requestedUser
     *
     * @param string $resourceName
     * @return void
     */
    protected function notify($resourceName)
    {
        $relation = $this->repositoryService->get('relation')->findRelationBetweenUsers($this->getRequestedUser(), $this->getRequestingUser());

        $notification = new \Macopedia\Community\Service\Notification\Notification(
            $resourceName,
            $this->requestingUser,
            $this->requestedUser
        );
        $notification->setRelation($relation);

        $this->notificationService->notify($notification);
    }
}

?>