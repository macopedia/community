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
 * Repository for Tx_Community_Domain_Model_Relation
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Pascal Jungblut <mail@pascalj.com>
 */
class Tx_Community_Domain_Repository_RelationRepository extends Tx_Community_Persistence_Cacheable_AbstractCacheableRepository {

	/**
	 * Find relations for a certain user.
	 *
	 * @param Tx_Community_Domain_Model_User $user
	 * @param integer $limit
	 */
	public function findRelationsForUser(Tx_Community_Domain_Model_User $user, $limit = 8) {
		$query = $this->createQuery();
		return $query->matching(
			$query->logicalAnd(
				$query->logicalOr(
					$query->equals('initiatingUser', $user),
					$query->equals('requestedUser', $user)
				),
				$query->equals('status', Tx_Community_Domain_Model_Relation::RELATION_STATUS_CONFIRMED)
			)
		)->execute();
	}
	
	/**
	 * Counts relations for a certain user.
	 *
	 * @param Tx_Community_Domain_Model_User $user
	 */
	public function countRelationsForUser(Tx_Community_Domain_Model_User $user) {
		$query = $this->createQuery();
		return $query->matching(
			$query->logicalAnd(
				$query->logicalOr(
					$query->equals('initiatingUser', $user),
					$query->equals('requestedUser', $user)
				),
				$query->equals('status', Tx_Community_Domain_Model_Relation::RELATION_STATUS_CONFIRMED)
			)
		)->count();
	}

	/**
	 * find the relation between users.
	 *
	 * @param Tx_Community_Domain_Model_User $requestedUser
	 * @param Tx_Community_Domain_Model_User $requestingUser
	 * @return array
	 * @throws Tx_Community_Exception_UnexpectedException
	 */
	public function findRelationBetweenUsers(
		Tx_Community_Domain_Model_User $requestedUser,
		Tx_Community_Domain_Model_User $requestingUser,
		$status = NULL
	) {
		$query = $this->createQuery();
		if ($status !== NULL) {
			$statusQuery = $query->equals('status', $status);
		} else {
			$statusQuery = $query->logicalNot($query->equals('status', 0));
		}
		$relations =  $query->matching(
			$query->logicalAnd(
				$query->logicalOr(
					$query->logicalAnd(
						$query->equals('initiatingUser', $requestedUser),
						$query->equals('requestedUser', $requestingUser)
					),
					$query->logicalAnd(
						$query->equals('initiatingUser', $requestingUser),
						$query->equals('requestedUser', $requestedUser)
					)
				),
				$statusQuery
			)
		)->execute();
		if (count($relations) > 1) {
			throw new Tx_Community_Exception_UnexpectedException(
				'There are more than one relations from user ' . $requestedUser->getUid() .' to ' . $requestingUser->getUid()
			);
		} elseif(count($relations) == 1) {
			return $relations[0];
		} else {
			return NULL;
		}
	}

	/**
	 * find relationships waiting for a given user approval
	 *
	 * @param Tx_Community_Domain_Model_User $user
	 */
	public function findUnconfirmedForUser(Tx_Community_Domain_Model_User $user) {
		$query = $this->createQuery();
		return $query->matching(
			$query->logicalAnd(
				$query->equals('requestedUser', $user),
				$query->equals('status', Tx_Community_Domain_Model_Relation::RELATION_STATUS_NEW)
			)
		)->execute();
	}
}
?>