<?php
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

/**
 * Returns the relaton between requestingUser and requestedUser
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Tx_Community_ViewHelpers_RelationViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * @var Tx_Community_Domain_Repository_RelationRepository
	 */
	protected $relationRepository;


	/**
	 * Inject the repository
	 *
	 * @param Tx_Community_Domain_Repository_RelationRepository $relationRepository
	 */
	public function injectRelationRepository(Tx_Community_Domain_Repository_RelationRepository $relationRepository) {
		$this->relationRepository = $relationRepository;
	}


	/**
	 * returns the relation between 2 users. If the users are the same, return true, if there is no relation at all, return false
	 *
	 * @param Tx_Community_Domain_Model_User $requestingUser
	 * @param Tx_Community_Domain_Model_User $requestedUser
	 * @return Tx_Community_Domain_Model_Relation|TRUE|FALSE
	 */
	public function render(Tx_Community_Domain_Model_User $requestingUser, Tx_Community_Domain_Model_User $requestedUser) {
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