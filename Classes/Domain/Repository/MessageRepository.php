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
	 * Deletes all (sent,receved...) messages for given user - useful when we delete him
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