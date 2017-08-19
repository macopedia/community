<?php

namespace Macopedia\Community\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010 Pascal Jungblut <mail@pascal-jungblut.com>
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

use Macopedia\Community\Domain\Model\Group,
    Macopedia\Community\Domain\Model\User,
    Macopedia\Community\Helper\RepositoryHelper,
    Macopedia\Community\Helper\GroupHelper;

/**
 * Controller for the Group object
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Pascal Jungblut <mail@pascalj.com>
 */
class GroupController extends BaseController implements \Macopedia\Community\Controller\Cacheable\ControllerInterface
{

    /**
     * Show the form to create a new grop
     *
     * @param Group $group
     * @dontverify $group
     */
    public function newAction(Group $group = NULL)
    {
        $this->view->assign('group', $group);
        $this->view->assign('groupOwner', $this->getRequestingUser());
    }

    /**
     * Create a new group
     *
     * @param Group $group
     */
    public function createAction(Group $group)
    {
        $group->setCreator($this->getRequestingUser());

        $image = $this->handleUpload(
            'group.image',
            $this->settings['group']['image']['prefix'],
            $this->settings['group']['image']['types']
        );

        if (!is_int($image)) {
            $group->setImage($image);
        } elseif ($image != 0) {
            $this->flashMessages->add($this->_('group.create.imageError'));
            $this->redirect('new', 'Group', NULL, array('group' => $group));
            return;
        }

        $this->repositoryService->get('group')->add($group);
        $this->redirect('list', 'Group');
    }

    /**
     *  Display the form to edit a group
     *
     * @param Group $group
     * @dontvalidate $group
     */
    public function editAction(Group $group)
    {
        $this->view->assign('group', $group);
    }

    /**
     * Update a group
     *
     * @param Group $group
     */
    public function updateAction(Group $group)
    {
        $image = $this->handleUpload(
            'group.image',
            $this->settings['group']['image']['prefix'],
            $this->settings['group']['image']['types']
        );

        if (!is_int($image)) {
            $group->setImage($image);
        } elseif ($image != 0) {
            $this->flashMessages->add($this->_('group.create.imageError'));
            $this->redirect('new', 'Group', NULL, array('group' => $group));
            return;
        }
        $this->repositoryService->get('group')->update($group);
        $this->redirect('show', 'Group', NULL, array('group' => $group));
    }

    /**
     * Delete an action if the creator confirms the deletion
     *
     * @param Group $group
     */
    public function deleteAction(Group $group)
    {
        if ($this->request->hasArgument('confirmedDelete') && ($this->getRequestingUser()->getUid() == $group->getCreator()->getUid())) {
            RepositoryHelper::getRepository('group')->remove($group);
        } else {
            $this->view->assign('group', $group);
        }
    }

    /**
     * Show a certain group
     *
     * @param Group $group
     */
    public function showAction(Group $group)
    {
        if ($this->getRequestingUser()) {
            if (!GroupHelper::isAdmin($group, $this->getRequestingUser()) &&
                !GroupHelper::isMember($group, $this->getRequestingUser()) &&
                !GroupHelper::isPendingMember($group, $this->getRequestingUser())
            ) {
                $this->view->assign('canJoin', true);
            } else {
                $this->view->assign('canJoin', false);
            }
        } else {
            $this->view->assign('canJoin', false);
        }
        $this->view->assign('group', $group);
        if ($this->getRequestingUser()) {
            $this->view->assign('isAdmin', GroupHelper::isAdmin($group, $this->getRequestingUser()));
        }
    }

    /**
     * Request a membership
     *
     * @param Group $group
     */
    public function requestMembershipAction(Group $group)
    {
        if ($this->getRequestingUser() instanceof User) {
            if ($group->getGrouptype() == Group::GROUP_TYPE_PRIVATE) {
                GroupHelper::addPendingMember($group, $this->getRequestingUser());
            } elseif ($group->getGrouptype() == Group::GROUP_TYPE_PUBLIC) {
                if (!GroupHelper::isAdmin($group, $this->getRequestingUser())) {
                    GroupHelper::confirmMember($group, $this->getRequestingUser());
                }
            }
        }
    }

    /**
     * Confirm a user's requested membership
     *
     * @param Group $group
     * @param User $user
     */
    public function confirmMembershipAction(
        Group $group,
        User $user
    )
    {
        if ($this->getRequestingUser() instanceof User) {
            if (GroupHelper::isAdmin($group, $this->getRequestingUser())) {
                GroupHelper::confirmMember($group, $user);
                $this->flashMessages->add($this->_('group.confirm.success'));
            }
        }
        $this->redirect('show', 'Group', NULL, array('group' => $group));
    }

    /**
     * Lists all groups
     */
    public function listAction()
    {
        $this->view->assign('groups', $this->repositoryService->get('group')->findAll());
    }

    /**
     * Make a user an admin of the group
     *
     * @param Group $group
     * @param User $user
     */
    public function adminAction(Group $group, User $user)
    {
        if ($this->request->hasArgument('confirmAdmin') &&
            $this->getRequestingUser() && (GroupHelper::isAdmin($group, $this->getRequestingUser()))
        ) {
            if (GroupHelper::isMember($group, $user)) {
                $group->removeMember($user);
                $group->addAdmin($user);
                $this->repositoryService->get('group')->update($group);
            }
        } else {
            $this->view->assign('group', $group);
            $this->view->assign('user', $user);
        }
    }

    /**
     * Remove the admin status from a user
     *
     * @param Group $group
     * @param User $user
     */
    public function unAdminAction(Group $group, User $user)
    {
        if ($this->request->hasArgument('confirmUnAdmin') &&
            $this->getRequestingUser() && (GroupHelper::isAdmin($group, $this->getRequestingUser()))
        ) {
            if (GroupHelper::isAdmin($group, $user)) {
                $group->removeAdmin($user);
                $group->addMember($user);
                $this->repositoryService->get('group')->update($group);
            }
        } else {
            $this->view->assign('group', $group);
            $this->view->assign('user', $user);
        }
    }

    /**
     * Get an identifier
     *
     * @param $request
     * @return array
     */
    public function getIdentifier($request)
    {
        $requestSettings = array(
            'controller' => $request->getControllerName(),
            'action' => $request->getControllerActionName(),
            'arguments' => $request->getArguments(),
            'user' => $GLOBALS['TSFE']->fe_user->user[$GLOBALS['TSFE']->fe_user->userid_column]
        );
        return array($this->settings, $requestSettings);
    }

    /**
     * Get the tags for this request (caching)
     */
    public function getTags()
    {
        $repo = RepositoryHelper::getRepository('Group');
        return $repo->getTags();
    }
}
