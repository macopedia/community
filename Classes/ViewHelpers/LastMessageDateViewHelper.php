<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 Konrad Baumgart
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
 * Shows the date of newest message between users
 *
 * @author Konrad Baumgart
 */
class Tx_Community_ViewHelpers_LastMessageDateViewHelper extends Tx_Fluid_ViewHelpers_IfViewHelper {

	/**
	 * Repository service. Get all your repositories with it.
	 *
	 * @var Tx_Community_Service_RepositoryServiceInterface
	 */
	protected $repositoryService;

	/**
	 * Inject the repository service.
	 *
	 * @param Tx_Community_Service_RepositoryServiceInterface $repositoryService
	 */
	public function injectRepositoryService(Tx_Community_Service_RepositoryServiceInterface $repositoryService) {
		$this->repositoryService = $repositoryService;
	}

	/**
	 * Gives the date of most recent message between user1 and user2
	 * @param Tx_Community_Domain_Model_User $user1
	 * @param Tx_Community_Domain_Model_User $user2
	 */
	public function render($user1, $user2) {
		return $this->repositoryService->get('message')->findRecentBetweenUsers($user1, $user2)->getSentDate();
	}
}
?>