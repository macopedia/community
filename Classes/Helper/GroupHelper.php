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
 * A helper to manage group related functions
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Pascal Jungblut <mail@pascalj.com>
 */
class Tx_Community_Helper_GroupHelper {

	/**
	 * Add a pending member to the group
	 *
	 * @param Tx_Community_Domain_Model_Group $group
	 * @param Tx_Community_Domain_Model_User $user
	 */
	static public function addPendingMember(
		Tx_Community_Domain_Model_Group $group,
		Tx_Community_Domain_Model_User $user
	) {
		$group->addPendingMember($user);
		Tx_Community_Helper_RepositoryHelper::getRepository('Group')->update($group);
		// TODO: message the admins/creator
	}

	/**
	 * Confirm that a user can join a group
	 *
	 * @param Tx_Community_Domain_Model_Group $group
	 * @param Tx_Community_Domain_Model_User $user
	 */
	static public function confirmMember(
		Tx_Community_Domain_Model_Group $group,
		Tx_Community_Domain_Model_User $user
	) {
		$group->removePendingMember($user);
		$group->addMember($user);
		Tx_Community_Helper_RepositoryHelper::getRepository('Group')->update($group);
		// TODO: message the user
	}

	/**
	 * Checks if a user is an admin of a group
	 *
	 * @param Tx_Community_Domain_Model_Group $group
	 * @param Tx_Community_Domain_Model_User $user
	 */
	static public function isAdmin(
		Tx_Community_Domain_Model_Group $group,
		Tx_Community_Domain_Model_User $user
	) {
		$userId = $user->getUid();

		if ($group->getCreator()->getUid() == $userId) {
			return true;
		}


		return $group->getAdmins()->contains($user);
	}

	/**
	 * Checks if a user is a member of the group
	 *
	 * @param Tx_Community_Domain_Model_Group $group
	 * @param Tx_Community_Domain_Model_User $user
	 */
	static public function isMember(
		Tx_Community_Domain_Model_Group $group,
		Tx_Community_Domain_Model_User $user
	) {
		return $group->getMembers()->contains($user);

	}

	/**
	 * Checks if a user is currently a pending member of a group
	 *
	 * @param Tx_Community_Domain_Model_Group $group
	 * @param Tx_Community_Domain_Model_User $user
	 */
	static public function isPendingMember(
		Tx_Community_Domain_Model_Group $group,
		Tx_Community_Domain_Model_User $user
	) {
		return $group->getPendingMembers()->contains($user);

	}
}
?>