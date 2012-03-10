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
 * Controller for the Album object
 */
class Tx_Community_Controller_AlbumController extends Tx_Community_Controller_BaseController {

	/**
	 * Displays all Albums of requested user
	 *
	 * @return void
	 */
	public function listAction() {
		$albums = $this->repositoryService->get('album')->findByUser($this->requestedUser);
		$this->view->assign('albums', $albums);
		$this->view->assign('relation', $this->getRelation());
	}


	/**
	 * Displays a single Album with it's photos
	 *
	 * @param Tx_Community_Domain_Model_Album $album the Album to display
	 * @return void
	 */
	public function showAction(Tx_Community_Domain_Model_Album $album) {
		$this->view->assign('album', $album);
		$this->view->assign('relation', $this->getRelation());
	}


	/**
	 * Redirects to show freshest album of requestedUser
	 *
	 * @return void
	 */
	public function showMostRecentAction() {
		$album = $this->repositoryService->get('album')->findOneByUser($this->requestedUser);
		$this->redirect('show', NULL, NULL, array('album'=>$album));
	}


	/**
	 * Displays a form for creating a new Album
	 *
	 * @param Tx_Community_Domain_Model_Album $newAlbum a fresh Album object which has not yet been added to the repository
	 * @return void
	 * @dontvalidate $newAlbum
	 */
	public function newAction(Tx_Community_Domain_Model_Album $newAlbum = NULL) {
		$this->view->assign('newAlbum', $newAlbum);
	}


	/**
	 * Creates a new Album and forwards to the list action.
	 *
	 * @param Tx_Community_Domain_Model_Album $newAlbum a fresh Album object which has not yet been added to the repository
	 * @return void
	 */
	public function createAction(Tx_Community_Domain_Model_Album $newAlbum) {
		$newAlbum->setUser($this->requestingUser);
		$this->repositoryService->get('album')->add($newAlbum);
		$this->flashMessageContainer->add($this->_('profile.album.createdAlbum'));
		$this->redirect('showMostRecent');
	}


	/**
	 * Displays a form for editing an existing Album
	 *
	 * @param Tx_Community_Domain_Model_Album $album the Album to display
	 * @return string A form to edit a Album
	 */
	public function editAction(Tx_Community_Domain_Model_Album $album) {
		$this->view->assign('album', $album);
	}


	/**
	 * Updates an existing Album and forwards to the list action afterwards.
	 *
	 * @param Tx_Community_Domain_Model_Album $album the Album to display
	 * @return void
	 */
	public function updateAction(Tx_Community_Domain_Model_Album $album) {
		$this->repositoryService->get('album')->update($album);
		$this->flashMessageContainer->add($this->_('profile.album.updatedAlbum'));
		$this->redirect('list');
	}


	/**
	 * Deletes an existing Album
	 *
	 * @param Tx_Community_Domain_Model_Album $album the Album to be deleted
	 * @return void
	 */
	public function deleteAction(Tx_Community_Domain_Model_Album $album) {
		$this->repositoryService->get('album')->remove($album);
		$this->flashMessageContainer->add($this->_('profile.album.removedAlbum'));
		$this->redirect('list');
	}
}
?>