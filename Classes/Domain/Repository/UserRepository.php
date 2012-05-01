<?php
/***************************************************************
*  Copyright notice
*
*  (c)  Pascal Jungblut
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
 * Repository for Tx_Community_Domain_Model_User
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Pascal Jungblut <mail@pascalj.com>
 */
class Tx_Community_Domain_Repository_UserRepository extends Tx_Extbase_Persistence_Repository {

	/**
	 * Find the current user
	 *
	 * @return Tx_Community_Domain_Model_User|NULL if user is not logged in
	 */
	public function findCurrentUser() {
		$uid = (integer) $GLOBALS['TSFE']->fe_user->user['uid'];
		if ($uid === 0) {
			return NULL;
		}
		return $this->findByUid($uid);
	}

	/*
	 * Find users by string
	 *
	 * @param string $word
	 * @return array
	 */
	public function searchByString($word) {
		$query = $this->createQuery();
		return $query->matching(
			$query->logicalOr(
				$query->like('name', '%' . str_replace(array('_','%'), '', $word) . '%'),
				$query->like('username', '%' . str_replace(array('_','%'), '', $word) . '%'),
				$query->equals('email', $word) //only full email address
			)
		)->execute();
	}

	/**
	 * Find users that chat with given user, to make list of people he chats with
	 * @param Tx_Community_Domain_Model_User $user
	 * @return Tx_Extbase_Persistence_QueryResult
	 */
	public function getChatMates(Tx_Community_Domain_Model_User $user) {
		$query = $this->createQuery();
		$query->matching(
		new Tx_Community_Persistence_QOM_SQL("
		  EXISTS (SELECT * FROM tx_community_domain_model_message m WHERE
			(m.sender = fe_users.uid  AND m.recipient = {$user->getUid()} AND m.recipient_deleted=0)
			OR
			(m.recipient = fe_users.uid  AND m.sender = {$user->getUid()} AND m.sender_deleted=0)
		  )
		")
		);
		$query->setOrderings(
			array("(SELECT MAX(sent_date) FROM tx_community_domain_model_message m WHERE
				(m.sender = fe_users.uid  AND m.recipient = {$user->getUid()} AND m.recipient_deleted=0)
				OR
				(m.recipient = fe_users.uid  AND m.sender = {$user->getUid()} AND m.sender_deleted=0)
				)"=> Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING)
		);
		return $query->execute();
	}

	/**
	 * Returns all objects of this repository
	 * @param $orderBy
	 * @param $orderDirection
	 * @return array An array of objects, empty if no objects found
	 */
	public function findAllOrderBy($orderBy, $orderDirection) {
		$query = $this->createQuery();

		//Helmut Hummel told me to do so ;)
		if (in_array($orderBy, array('datetime','username')) && in_array($orderDirection, array(
			Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING,
			Tx_Extbase_Persistence_QueryInterface::ORDER_ASCENDING
		))) {
			$query->setOrderings(array($orderBy => $orderDirection));
		}
		return $query->execute();
	}

	/*
	 * Find users by Usergroup
	 *
	 * default findByUsergroup doesn´t work if the user has more then one group
	 *
	 * @param int $group Id of the Usergroup
	 * @param string $orderBy order by field
	 * @param string $orderDirection order direction
	 * @return array
	 */
	public function findByUsergroup($group, $orderBy, $orderDirection) {
		$query = $this->createQuery();

		//Helmut Hummel told me to do so ;)
		if (in_array($orderBy, array('datetime','username')) && in_array($orderDirection, array(
			Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING,
			Tx_Extbase_Persistence_QueryInterface::ORDER_ASCENDING
		))) {
			$query->setOrderings(array($orderBy => $orderDirection));
		}

		return $query->matching(
			$query->contains('usergroup', $group)
		)->execute();
	}

	/**
	 * Finds the latest users
	 *
	 * @param int $limit Limit
	 * @return array
	 */
	public function findLatest($limit) {
		$query = $this->createQuery();
		$query->setOrderings(array('uid' => Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING));
		return $query->setLimit($limit)->execute();
	}
}
?>