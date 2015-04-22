<?php
namespace Macopedia\Community\ViewHelpers;
/***************************************************************
*  Copyright notice
*
*  (c) 2011 Simon Schaufelberger
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

use Macopedia\Community\Domain\Model\User;

/**
 * Returns the relaton between requestingUser and requestedUser
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class RelationViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * @var \Macopedia\Community\Domain\Repository\RelationRepository
	 */
	protected $relationRepository;


	/**
	 * Inject the repository
	 *
	 * @param \Macopedia\Community\Domain\Repository\RelationRepository $relationRepository
	 */
	public function injectRelationRepository(\Macopedia\Community\Domain\Repository\RelationRepository $relationRepository) {
		$this->relationRepository = $relationRepository;
	}


	/**
	 * returns the relation between 2 users. If the users are the same, return true, if there is no relation at all, return false
	 *
	 * @param User $requestingUser
	 * @param User $requestedUser
	 * @return Relation|TRUE|FALSE
	 */
	public function render(User $requestingUser, User $requestedUser) {
		if ($requestingUser === $requestedUser) {
			return TRUE;
		}

		$result = $this->relationRepository->findRelationBetweenUsers($requestingUser, $requestedUser);

		if ($result) {
			return $result;
		} else {
			return FALSE;
		}
	}
}
?>