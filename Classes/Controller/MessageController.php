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
 * The controller for messages
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Pascal Jungblut <mail@pascalj.com>
 */
class Tx_Community_Controller_MessageController extends Tx_Community_Controller_BaseController {

	/**
	 * Initializes the current action - called before any other action
	 * @see Classes/Controller/Tx_Community_Controller_BaseController#initializeAction()
	 * @return void
	 */
	protected function initializeAction() {
		parent::initializeAction();
	}

        /**
	 * Show the inbox of a user
	 */
	public function inboxAction() {
		$messages = array();
		if ($this->getRequestingUser()) {
			$messages = $this->repositoryService->get('message')->findIncomingForUser($this->getRequestingUser());
		}
		$this->view->assign('messages', $messages);
	}

	/**
	 * Show the outgoing messages of a user
	 */
	public function outboxAction() {
		$messages = array();
		if ($this->getRequestingUser()) {
			$messages = $this->repositoryService->get('message')->findOutgoingForUser($this->getRequestingUser());
		}
		$this->view->assign('messages', $messages);
	}

	/**
	 * Show the unread messages for a user
	 */
	public function unreadAction() {
		$messages = array();
		if ($this->getRequestingUser()) {
			$messages = $this->repositoryService->get('message')->findUnreadForUser($this->getRequestingUser());
		}
		$this->view->assign('messages', $messages);
	}

	/**
	 * Write a message
	 *
	 * @param Tx_Community_Domain_Model_User $recipient
	 * @param Tx_Community_Domain_Model_Message $message
	 * @dontvalidate $message
	 */
	public function writeAction(
		Tx_Community_Domain_Model_User $recipient,
		Tx_Community_Domain_Model_Message $message =  NULL) {
		$this->view->assign('recipient', $recipient);
		$this->view->assign('message', $message);
	}

	/**
	 * Send a message
	 *
	 * @param Tx_Community_Domain_Model_Message $message
	 */
	public function sendAction(Tx_Community_Domain_Model_Message $message) {
		$message->setSent(true);
		$message->setSentDate(time());
		$message->setSender($this->getRequestingUser());
		$this->repositoryService->get('message')->add($message);
                $this->flashMessageContainer->add($this->_('message.send.success'));
		$this->redirect('outbox', 'Message');
	}

	/**
	 * Read a certain message
	 *
	 * @param Tx_Community_Domain_Model_Message $message
	 */
	public function readAction(Tx_Community_Domain_Model_Message $message) {
		if ($this->getRequestingUser() &&
			($this->getRequestingUser()->getUid() == $message->getRecipient()->getUid() ||
			$this->getRequestingUser()->getUid() == $message->getSender()->getUid())) {
			$this->repositoryService->get('message')->update($message);
			$this->view->assign('message', $message);
                       //do not flag message as read when reading your own message
                        if( $this->getRequestingUser()->getUid() == $message->getRecipient()->getUid()){
                            $message->setRead(true);
                            $message->setReadDate(time());
                       }
		}
	}

	/**
	 * Delete the message
	 *
	 * @param Tx_Community_Domain_Model_Message $message
	 */
	public function deleteAction(Tx_Community_Domain_Model_Message $message) {
		if ($this->getRequestingUser()) {
			if ($message->getSender()->getUid() == $this->getRequestingUser()) {
				$message->setSenderDeleted(true);
			}
			if ($message->getRecipient()->getUid() == $this->getRequestingUser()) {
				$message->setRecipientDeleted(true);
			}
			 $this->flashMessageContainer->add($this->_('message.delete.success'));
		}
	}

        /**
	 * Get the requested user
	 * @see Classes/Controller/Tx_Community_Controller_BaseController#getRequestedUser()
	 * @return Tx_Community_Domain_Model_User
	 */
        protected function getRequestedUser() {
            parent::getRequestedUser();

            if ($this->request->hasArgument('recipient') && !is_array($this->request->getArgument('recipient'))) {
				$this->requestedUser = $this->repositoryService->get('user')->findByUid((int) $this->request->getArgument('recipient'));
			} 

		return $this->requestedUser;
        }
}
?>