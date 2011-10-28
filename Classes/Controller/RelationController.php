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
	 * Display some of user's friends
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
	}

	/**
	 * List all relations.
	 */
	public function listAction() {
		$relations = $this->repositoryService->get('relation')->findRelationsForUser($this->getRequestedUser());
		$this->view->assign('relations', $relations);
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
			//Normal request
			$this->flashMessageContainer->add($this->_('relation.request.pending'));
			$relation = new Tx_Community_Domain_Model_Relation();

			// we must notify before new relation is created
			$this->notify('requestRelation');
			// set the details for the relation
			$relation->setInitiatingUser($this->getRequestingUser());
			$relation->setRequestedUser($user);
			$relation->setStatus(Tx_Community_Domain_Model_Relation::RELATION_STATUS_NEW);
			$this->repositoryService->get('relation')->add($relation);

		} elseif ($relation instanceof Tx_Community_Domain_Model_Relation) {

			$this->requestedExistingRelation($relation, $user);

		} else {
			// more than one relation? something is wrong.
			throw new Tx_Community_Exception_UnexpectedException(
				'There are more than one relations between user ' . $user->getUid() . ' and user ' . $this->getRequestingUser()->getUid()
			);
		}

		$this->redirectToUser($user);
	}

	/**
	 * Used in requestAction() when requested relation exists
	 * @param Tx_Community_Domain_Model_Relation $relation
	 * @param Tx_Community_Domain_Model_User $user
	 */
	protected function requestedExistingRelation(Tx_Community_Domain_Model_Relation $relation, Tx_Community_Domain_Model_User $user) {
		
		switch ($relation->getStatus()) {

			case Tx_Community_Domain_Model_Relation::RELATION_STATUS_NEW:
				if($relation->getRequestedUser() == $user) {
					$this->flashMessageContainer->add($this->_('relation.request.alreadyPending'), '', t3lib_FlashMessage::NOTICE);
				} else {
					// if both sides request friendship, it's ok
					$this->flashMessageContainer->add($this->_('relation.confirm.success'));
					$this->confirmRelation($relation);
				}
				break;

			case Tx_Community_Domain_Model_Relation::RELATION_STATUS_CONFIRMED:
				$this->flashMessageContainer->add($this->_('relation.request.alreadyFriends'), '', t3lib_FlashMessage::INFO);
				break;

			case Tx_Community_Domain_Model_Relation::RELATION_STATUS_REJECTED:
				if($relation->getRequestedUser() == $user && !$this->settings['relation']['request']['allowMultiple']) {
					//It's too late for this friendship
					 $this->flashMessageContainer->add($this->_('relation.request.alreadyRejected'), '', t3lib_FlashMessage::ERROR);
				} else {
					// The user that already rejected request, changed his mind
					// or an already rejected relation can be requested again
					$this->flashMessageContainer->add($this->_('relation.request.pending'));
					$requestedUser = $relation->getRequestedUser();
					$relation->setRequestedUser($relation->getInitiatingUser());
					$relation->setInitiatingUser($requestedUser);
					$relation->setStatus(Tx_Community_Domain_Model_Relation::RELATION_STATUS_NEW);
					$this->repositoryService->get('relation')->update($relation);

					$this->notify('requestRelation');
				}
				break;

			case Tx_Community_Domain_Model_Relation::RELATION_STATUS_CANCELLED:
				$this->flashMessageContainer->add($this->_('relation.request.alreadyCanceled'), '', t3lib_FlashMessage::NOTICE);
				break;

			default:
				throw new Tx_Community_Exception_UnexpectedException(
						'Unknown relation status between user ' . $user->getUid() . ' and user ' . $this->getRequestingUser()->getUid()
					);
				break;
		}
	}

	/**
	 * Confirm a relation
	 *
	 * @param Tx_Community_Domain_Model_User $relation
	 */
	public function confirmAction(Tx_Community_Domain_Model_Relation $relation) {
		if ($relation->getRequestedUser()->getUid() == $this->getRequestingUser()->getUid()) {
			$this->confirmRelation($relation);
			$this->flashMessageContainer->add($this->_('relation.confirm.success'));
		}
		$this->redirectToUser($this->getRequestingUser());
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

			$this->notify('cancelRelation');

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
	 * @param Tx_Community_Domain_Model_User $user
	 */
	public function cancelAction(Tx_Community_Domain_Model_Relation $relation = null, Tx_Community_Domain_Model_User $user = null) {
	  if($relation === null ){
		if($user !== null){
		$relation = $this->repositoryService->get('relation')->findRelationBetweenUsers($user, $this->getRequestingUser());
		}else {
		  throw new Tx_Community_Exception_UnexpectedException("One of the parameters must be set");
		}
	  }
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
		$this->notify('confirmedRelation');
	}

	/**
	 * Reject a relation and notify the initiating user
	 *
	 * @param Tx_Community_Domain_Model_Relation $relation
	 */
	protected function rejectRelation(Tx_Community_Domain_Model_Relation $relation) {
		$relation->setStatus(Tx_Community_Domain_Model_Relation::RELATION_STATUS_REJECTED);
		$this->repositoryService->get('relation')->update($relation);

		$this->notify('rejectedRelation');
	}

	/**
	 * Cancel a relation. Happens when an initiating user cancels the request _or_ if
	 * an accepted relation gets cancelled by one of the users.
	 *
	 * @param Tx_Community_Domain_Model_Relation $relation
	 */
	protected function cancelRelation(Tx_Community_Domain_Model_Relation $relation) {
		$relation->setStatus(Tx_Community_Domain_Model_Relation::RELATION_STATUS_CANCELLED);

		$this->notify('cancelledRelation');
	}

	/**
	 * Send notification from requestingUser to requestedUser
	 * @param string $resourceName
	 * @return void
	 */
	protected function notify($resourceName) {
		$relation = $this->repositoryService->get('relation')->findRelationBetweenUsers($this->getRequestedUser(), $this->getRequestingUser());
		$notifyArguments = array(
			'sender' => $this->requestingUser,
			'recipient' => $this->requestedUser,
			'relation' => $relation,
		);
		if(t3lib_div::validEmail($this->requestedUser->getEmail())){
			$this->notificationService->notify($notifyArguments, $resourceName);		   
		}
		else {
		    t3lib_div::sysLog('User with id:'.$this->requestedUser->getUid()." has wrong email address.", "Community");
		}
	}
}
?>
