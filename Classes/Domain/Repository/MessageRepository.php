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

class Tx_Community_Domain_Repository_MessageRepository extends Tx_Extbase_Persistence_Repository {

	/**
	 * Find outgoing messages for the current user
	 *
	 * @param Tx_Community_Domain_Model_User $user
	 * @return Tx_Extbase_Persistence_QueryResultInterface
	 */
	public function findOutgoingForUser(Tx_Community_Domain_Model_User $user) {
		$query = $this->createQuery();
		return $query->matching(
			$query->logicalAnd(
				$query->equals('sender', $user),
				$query->equals('senderDeleted', false)
			)
		)->setOrderings(array('sentDate' => Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING)
		)->execute();
	}

	/**
	 * Find incoming messages
	 *
	 * @param Tx_Community_Domain_Model_User $user
	 * @return Tx_Extbase_Persistence_QueryResultInterface
	 */
	public function findIncomingForUser(Tx_Community_Domain_Model_User $user) {
		$query = $this->createQuery();
		return $query->matching(
			$query->logicalAnd(
				$query->equals('recipient', $user),
				$query->equals('recipientDeleted', false)
			)
		)->setOrderings(array('sentDate' => Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING)
		)->execute();
	}

	/**
	 * Find unread messages for a user
	 *
	 * @param Tx_Community_Domain_Model_User $user
	 * @return Tx_Extbase_Persistence_QueryResultInterface
	 */
	public function findUnreadForUser(Tx_Community_Domain_Model_User $user) {
		$query = $this->createQuery();
		return $query->matching(
			$query->logicalAnd(
				$query->equals('recipient', $user),
				$query->logicalNot(
					$query->logicalOr(
						$query->equals('recipientDeleted', true),
						$query->equals('read', true)
					)
				)
			)
		)->execute();
	}

	/**
	 * Find all messages between users (for user1 - we see messages that user1 hasn't deleted)
	 * @param Tx_Community_Domain_Model_User $user1
	 * @param Tx_Community_Domain_Model_User $user2
	 */
	public function findBetweenUsers(Tx_Community_Domain_Model_User $user1, Tx_Community_Domain_Model_User $user2) {
		$query = $this->createQuery();
		$query->matching(
			$query->logicalOr(
				$query->logicalAnd(
					$query->equals('sender', $user1),
					$query->equals('senderDeleted', false),
					$query->equals('recipient', $user2)
				),
				$query->logicalAnd(
					$query->equals('sender', $user2),
					$query->equals('recipient', $user1),
					$query->equals('recipientDeleted', false)
				)
			)
		);
		$query->setOrderings(array('sentDate' => Tx_Extbase_Persistence_QueryInterface::ORDER_ASCENDING));
		return $query->execute();
	}

	/**
	 * Find newest message between users (don't have to be new)
	 * @param Tx_Community_Domain_Model_User $user1
	 * @param Tx_Community_Domain_Model_User $user2
	 */
	public function findRecentBetweenUsers(Tx_Community_Domain_Model_User $user1, Tx_Community_Domain_Model_User $user2) {
		$query = $this->createQuery();
		$query->matching(
			$query->logicalOr(
				$query->logicalAnd(
					$query->equals('sender', $user1),
					$query->equals('senderDeleted', false),
					$query->equals('recipient', $user2)
				),
				$query->logicalAnd(
					$query->equals('sender', $user2),
					$query->equals('recipient', $user1),
					$query->equals('recipientDeleted', false)
				)
			)
		);
		$query->setOrderings(array('sentDate' => Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING));
		return $query->execute()->getFirst();
	}

	/**
	 * Find all messages between users (for recipient - we see messages that he hasn't deleted)
	 * @param Tx_Community_Domain_Model_User $recipient
	 * @param Tx_Community_Domain_Model_User $sender
	 */
	public function findOneNewBetweenUsers(Tx_Community_Domain_Model_User $recipient, Tx_Community_Domain_Model_User $sender) {
		$query = $this->createQuery();
		$query->matching(
			$query->logicalAnd(
				$query->equals('recipient', $recipient),
				$query->equals('sender', $sender),
				$query->equals('recipientDeleted', false),
				$query->equals('read_date', 0)
			)
		);
		return $query->execute()->getFirst();
	}

	/**
	 * Find all messages for the current user
	 *
	 * @param Tx_Community_Domain_Model_User $user
	 */
	public function findForUser(Tx_Community_Domain_Model_User $user) {
		$query = $this->createQuery();
		return $query->matching(
			$query->logicalOr(
				$query->logicalAnd(
					$query->equals('sender', $user),
					$query->equals('senderDeleted', false)
				),
				$query->logicalAnd(
					$query->equals('recipient', $user),
					$query->equals('recipientDeleted', false)
				)
			)
		)->execute();
	}

	/**
	 * Deletes all (sent, receved...) messages for given user - useful when we delete him
	 *
	 * @param Tx_Community_Domain_Model_User $user
	 * @return void
	 */
	public function deleteAllForUser(Tx_Community_Domain_Model_User $user) {
		$query = $this->createQuery();
		$messages = $query->matching(
			$query->logicalOr(
				$query->equals('sender', $user),
				$query->equals('recipient', $user)
			)
		)->execute();
		foreach ($messages as $message) { /* @var $message Tx_Community_Domain_Model_Message */
			if ($user->getUid() == $message->getSender()->getUid()) {
				$message->setSenderDeleted(TRUE);
			} else {
				$message->setRecipientDeleted(TRUE);
			}
			$this->update($message);
		}
	}

}
?>