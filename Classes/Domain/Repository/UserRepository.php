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
class Tx_Community_Domain_Repository_UserRepository extends Tx_Community_Persistence_Cacheable_AbstractCacheableRepository {

	/**
	 * Find the current user
	 *
	 * @return Tx_Community_Domain_Model_User
	 * @todo Error Checking!
	 */
	public function findCurrentUser() {
		$uid = (integer) $GLOBALS["TSFE"]->fe_user->user['uid'];
		return $this->findByUid($uid);
	}

	public function searchByName($word) {
		$query = $this->createQuery();
		return $query->matching(
			$query->like('name', '%' . $word . '%')
		)->execute();
	}
}
?>