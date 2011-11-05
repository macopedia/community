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
 * Controller for the WallPost object
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

 class Tx_Community_Controller_WallPostController extends Tx_Community_Controller_BaseController {

	/**
	 * Displays all WallPosts
	 *
	 * @return string The rendered list view
	 */
	public function listAction() {
		$wallPosts = $this->repositoryService->get('wallPost')->findRecentByRecipient($this->getRequestedUser());
		$this->view->assign('wallPosts', $wallPosts);
	}

	/**
	 * Creates a new WallPost and forwards to the list action.
	 *
	 * @param Tx_Community_Domain_Model_WallPost $newWallPost a fresh WallPost object which has not yet been added to the repository
	 * @return string An HTML form for creating a new WallPost
	 * @dontvalidate $newWallPost
	 */
	public function newAction(Tx_Community_Domain_Model_WallPost $newWallPost = null) {
		$this->view->assign('newWallPost', $newWallPost);
		$this->view->assign('recipient', $this->getRequestedUser());
	}

	/**
	 * Creates a new WallPost and forwards to the list action.
	 *
	 * @param Tx_Community_Domain_Model_WallPost $newWallPost a fresh WallPost object which has not yet been added to the repository
	 * @return void
	 *
	 */
	public function createAction(Tx_Community_Domain_Model_WallPost $newWallPost ) {
		$newPost = t3lib_div::makeInstance('Tx_Community_Domain_Model_WallPost');
		$newPost->setMessage($newWallPost->getMessage());
		$newPost->setRecipient($this->getRequestedUser());
		$newPost->setSender($this->getRequestingUser());
		$newPost->setSubject($this->getRequestingUser()->getName());
		$this->repositoryService->get('wallPost')->add($newPost);
		$this->flashMessageContainer->add($this->_('wallPost.form.created'));
		$this->redirectToUser($this->getRequestedUser());
		//$this->redirect('new');
	}

	/**
	 * Deletes an existing WallPost
	 *
	 * @param Tx_Community_Domain_Model_WallPost $wallPost the WallPost to be deleted
	 * @return void
	 */
	public function deleteAction(Tx_Community_Domain_Model_WallPost $wallPost) {
		$this->repositoryService->get('wallPost')->remove($wallPost);
		$this->flashMessageContainer->add($this->_('wallPost.list.deleted'));
		$this->redirect('list');
	}

}
?>