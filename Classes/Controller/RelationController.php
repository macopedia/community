<?php
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


/**
 * The relation controller.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Pascal Jungblut <mail@pascalj.com>
 */
class Tx_Community_Controller_RelationController extends Tx_Community_Controller_BaseController {

	/**
	 * @var Tx_Commnity_Domain_Repository_UserRepository
	 */
	protected $userRepository;

	/**
	 * Initializes the current action - called before any other action
	 * @see Classes/Controller/Tx_Community_Controller_BaseController#initializeAction()
	 * @return void
	 */
	protected function initializeAction() {
		parent::initializeAction();
	}

	/**
	 * Display some user's friends
	 * 
	 */
	public function listSomeAction() {
		$relations = $this->repositoryService->get('relation')->findRelationsForUser($this->getRequestedUser(), $this->settings['relations']['listSome']['limit']);
		$relationNumber = $this->repositoryService->get('relation')->countRelationsForUser($this->getRequestedUser());
		$users = array();
		foreach($relations as $relation) {
			if ($relation->getRequestedUser()->getUid() == $this->getRequestedUser()->getUid()) {
				$users[$relation->getUid()] = $relation->getInitiatingUser();
			} else {
				$users[$relation->getUid()] = $relation->getRequestedUser();
			}
		}

                $usersRelations = $users;
		$this->view->assign('usersRelations', $usersRelations);
		$this->view->assign('countRelations',$relationNumber);
		$this->view->assign('requestedUser',$this->getRequestedUser());
	}

	/**
	 * List all relations.
	 */
	public function listAction() {
		$relations = $this->repositoryService->get('relation')->findRelationsForUser($this->getRequestedUser());
		$users = array();
		foreach($relations as $relation) {
			if ($relation->getRequestedUser()->getUid() == $this->getRequestedUser()->getUid()) {
				$users[] = $relation->getInitiatingUser();
			} else {
				$users[] = $relation->getRequestedUser();
			}
		}
		$this->view->assign('requestedUser',$this->getRequestedUser());
		$this->view->assign('usersRelations', $users);
	}

	/**
	 * Requests a relation between two users. It will set the status to NEW.
	 *
	 * @param Tx_Community_Domain_Model_User $user
	 * @see Tx_Community_Domain_Model_Relation
	 */
	public function requestAction(Tx_Community_Domain_Model_User $user) {

		$relation = $this->repositoryService->get('relation')->findRelationBetweenUsers($user, $this->getRequestingUser());
		if ($relation === NULL) {
			$relation = new Tx_Community_Domain_Model_Relation();

			// set the details for the relation
			$relation->setInitiatingUser($this->getRequestingUser());
			$relation->setRequestedUser($user);
			$relation->setStatus(Tx_Community_Domain_Model_Relation::RELATION_STATUS_NEW);
			$this->repositoryService->get('relation')->add($relation);
		} elseif ($relation instanceof Tx_Community_Domain_Model_Relation) {
			if($relation->getStatus() == Tx_Community_Domain_Model_Relation::RELATION_STATUS_REJECTED) {
				if($relation->getRequestedUser() == $user) {
					 $this->flashMessageContainer->add($this->_('relation.request.allreadyRejected'));

					 // check if an already rejected relation can be requested again
					if ($this->settings['relation']['request']['allowMultiple'] == '1') {
						$relation->setStatus(Tx_Community_Domain_Model_Relation::RELATION_STATUS_NEW);
						$this->repositoryService->get('relation')->update($relation);
					} else {
						 return;
					}
				} else {
					$requestedUser = $relation->getRequestedUser();
					$relation->setRequestedUser($relation->getInitiatingUser());
					$relation->setInitiatingUser($requestedUser);
					$relation->setStatus(Tx_Community_Domain_Model_Relation::RELATION_STATUS_NEW);
					$this->repositoryService->get('relation')->update($relation);
				}
			}
		} else {
			// more than one relation? something is wrong.
			throw new Tx_Community_Exception_UnexpectedException(
				'There are more than one relations between user ' . $user->getUid() . ' and user ' . $this->getRequestingUser()->getUid()
			);
		}

		// TODO send mails on request
	}

	/**
	 * Confirm a relation
	 *
	 * @param Tx_Community_Domain_Model_User $relation
	 */
	public function confirmAction(Tx_Community_Domain_Model_Relation $relation) {
		if($this->getRequestingUser() instanceof Tx_Community_Domain_Model_User) {
			if ($relation->getRequestedUser()->getUid() == $this->getRequestingUser()->getUid()) {
				$this->confirmRelation($relation);
                                $this->flashMessageContainer->add($this->_('relation.confirm.success'));
                        }
		$this->redirectToUser($this->getRequestingUser());
                } else {
			throw new Tx_Community_Exception_UserNotFoundException('No one is logged in.');
		}
	}


	/**
	 * Reject a relation which hasn't been accepted yet
	 *
	 * @param Tx_Community_Domain_Model_Relation $relation
	 */
        public function rejectAction(Tx_Community_Domain_Model_Relation $relation) {
                if ($this->request->hasArgument('confirmReject')) {
                       $this->rejectRelation($relation);
                       $this->flashMessageContainer->add($this->_('relation.reject.success'));
                       $this->redirectToUser($this->getRequestingUser());
                } else {
                    $this->view->assign('relation', $relation);
                }
        }

	/**
	 * List all unconfirmed relations.
	 */
	public function unconfirmedAction() {
		if ($this->ownProfile()) {
			$this->view->assign('unconfirmedRelations', $this->repositoryService->get('relation')->findUnconfirmedForUser(
				$this->getRequestingUser())
			);
		} else {
			$this->view->assign('unconfirmedRelations', array());
		}
	}

	/**
	 * Cancel a relation that is allready accepted.
	 *
	 * @param Tx_Community_Domain_Model_Relation $relation
	 */
	public function cancelAction(Tx_Community_Domain_Model_Relation $relation) {
                if ($this->request->hasArgument('confirmCancel')) {
                      $this->cancelRelation($relation);
                      $this->flashMessageContainer->add($this->_('relation.cancel.success'));
                      $this->redirectToUser($this->getRequestingUser());

                }else {
                        $this->view->assign('relation', $relation);
                }
	}

	/**
	 * Confirm a relation and notify the initiating user
	 *
	 * @param Tx_Community_Domain_Model_Relation $relation
	 */
	protected function confirmRelation(Tx_Community_Domain_Model_Relation $relation) {
		$relation->setStatus(Tx_Community_Domain_Model_Relation::RELATION_STATUS_CONFIRMED);
		$this->repositoryService->get('relation')->update($relation);
		// TODO send mails on confirmation
	}

	/**
	 * Reject a relation and notify the initiating user
	 *
	 * @param Tx_Community_Domain_Model_Relation $relation
	 */
	protected function rejectRelation(Tx_Community_Domain_Model_Relation $relation) {
		$relation->setStatus(Tx_Community_Domain_Model_Relation::RELATION_STATUS_REJECTED);
		$this->repositoryService->get('relation')->update($relation);
		// TODO send mails on rejection
	}

	/**
	 * Cancel a relation. Happens when an initiating user cancels the request _or_ if
	 * an accepted relation gets cancelled by one of the users.
	 *
	 * @param Tx_Community_Domain_Model_Relation $relation
	 */
	protected function cancelRelation(Tx_Community_Domain_Model_Relation $relation) {
		$relation->setStatus(Tx_Community_Domain_Model_Relation::RELATION_STATUS_CANCELLED);
		$this->repositoryService->get('relation')->remove($relation);
		// TODO send mails on rejection
	}

	protected function setDefaultRole() {

	}

         /**
	 * Get the requested user
	 * @see Classes/Controller/Tx_Community_Controller_BaseController#getRequestedUser()
	 * @return Tx_Community_Domain_Model_User
	 */
        protected function getRequestedUser() {
            parent::getRequestedUser();

            if ($this->request->hasArgument('relation') && !is_array($this->request->getArgument('relation'))) {
                  $relation = $this->repositoryService->get('relation')->findByUid((int) $this->request->getArgument('relation'));
                  $requestedUser = null;
                  if ($relation->getInitiatingUser()->getUid() == $this->getRequestingUser()->getUid()) {
                     $requestedUser = $relation->getRequestedUser();
                  } else {
                     $requestedUser = $relation->getInitiatingUser();
                  }
                  $this->requestedUser = $requestedUser;
            }
		return $this->requestedUser;
        }

}
?>
