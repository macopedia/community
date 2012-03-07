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

class Tx_Community_Domain_Repository_WallPostRepository extends Tx_Extbase_Persistence_Repository {

	/**
	 * Finds most recent posts by the specified blog
	 *
	 * @param Tx_Community_Domain_Model_User $user The owner of wall
	 * @return Tx_Extbase_Persistence_QueryResultInterface Wall posts
	 */
	public function findRecentByRecipient(Tx_Community_Domain_Model_User $user) {
		$query = $this->createQuery();
		return $query->matching($query->equals('recipient', $user))
			->setOrderings(array('crdate' => Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING))
			->execute();
	}

	/**
	 * Deletes  all (sent,receved...) wall posts for given user - useful when we delete him
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
		foreach ($messages as $message) {
			if (!$message->getRecipient() || $message->getRecipient()->getUid() == $user->getUid()) {
				//delete all messages from my own wall, and all I send to already deleted user
				$this->remove($message);
			}
		}
	}

}
?>