<?php
namespace Macopedia\Community\Domain\Repository;
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
 * Repository for Macopedia\Community\Domain\Model\Album
 */
class AlbumRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	public function initialize() {
		$this->setDefaultOrderings(array('crdate'=>\TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING));
		//requied in AlbumController->showMostRecentAction
	}

	/**
	 * Finds albums by user and special
	 *
	 * @param \Macopedia\Community\Domain\Model\User $user The owner of album
	 * @param integer $albumType The type of special album
	 * @return array The posts
	 */
	public function findOneByUserAndType(\Macopedia\Community\Domain\Model\User $user, $albumType) {
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

	/**
	 * Deletes all albums for user - useful when we delete him
	 *
	 * @param \Macopedia\Community\Domain\Model\User $user
	 * @return void
	 */
	public function deleteAllForUser(\Macopedia\Community\Domain\Model\User $user) {
		$query = $this->createQuery();
		$albums = $query->matching(
			$query->equals('user', $user)
		)->execute();
		foreach ($albums as $album) {
			$this->remove($album);
		}
	}
}
?>