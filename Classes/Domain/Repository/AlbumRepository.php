<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 Konrad Baumgart
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 3 of the License, or
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
 * Repository for Tx_Community_Domain_Model_Album
 */
class Tx_Community_Domain_Repository_AlbumRepository extends Tx_Extbase_Persistence_Repository {
	public function __construct() {
		parent::__construct();

		$this->setDefaultOrderings(array('crdate'=>Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING));
			//requied in AlbumController->showMostRecentAction
	}

	/**
	 * Finds albums by user and special
	 *
	 * @param Tx_Community_Domain_Model_User $user The owner of album
	 * @param integer $albumType The type of special album
	 * @return array The posts
	 */
	public function findOneByUserAndType(Tx_Community_Domain_Model_User $user, $albumType) {
		$query = $this->createQuery();
		return $query->matching(
					$query->logicalAnd(
							$query->equals('user', $user),
							$query->equals('albumType', $albumType)
							)
					)
			->execute()
			->getFirst();
	}
}
?>