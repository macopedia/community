<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 
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
 * Controller for the Photo object
 */
class Tx_Community_Controller_PhotoController extends Tx_Community_Controller_BaseController {


	/**
	 * Displays a single Photo
	 *
	 * @param Tx_Community_Domain_Model_Photo $photo the Photo to display
	 * @return string The rendered view
	 */
	public function showAction(Tx_Community_Domain_Model_Photo $photo) {
		$this->view->assign('photo', $photo);
		$this->view->assign('relation', $this->getRelation());
		$this->view->assign('requestingUser', $this->getRequestingUser());
	}


	/**
	 * Displays a form for creating a new  Photo
	 *
	 * @param Tx_Community_Domain_Model_Album $album album we create photo in
	 * @return void
	 */
	public function newAction(Tx_Community_Domain_Model_Album $album) {
		//$photo = $this->repositoryService->get('photo')->findByUid(3);
		//$album->addPhoto($photo);
		$this->view->assign('album', $album);
	}


	/**
	 * Creates a new Photo and forwards to the list action.
	 *
	 * @param Tx_Community_Domain_Model_Album $album album we create photo in
	 * @return void
	 */
	public function createAction(Tx_Community_Domain_Model_Album $album) {

		// handleUpload() returns numer in case of error
		$fileName = $this->handleUpload(
				'newPhoto.image',
				$this->settings['album']['image']['prefix'],
				$this->settings['album']['image']['types'],
				$this->settings['album']['image']['maxSize']
				);
		if (!is_int($fileName)) {
			$newPhoto = new Tx_Community_Domain_Model_Photo;
			$newPhoto->setImage($fileName);
			$album->addPhoto($newPhoto);
			$this->repositoryService->get('photo')->add($newPhoto);
			$this->redirect('show','album', NULL, array('album' => $album->getUid()));
		} else {
			$this->flashMessageContainer->add($this->_('profile.album.uploadError'));
			$this->redirect('new');
		}
	}


	/**
	 * Deletes an existing Photo
	 *
	 * @param Tx_Community_Domain_Model_Photo $photo the Photo to be deleted
	 * @return void
	 */
	public function deleteAction(Tx_Community_Domain_Model_Photo $photo) {
		$album = $photo->getAlbum();
		$album->removePhoto($photo);
		$this->repositoryService->get('photo')->remove($photo);
		$this->flashMessageContainer->add('Your Photo was removed.');
		$this->redirect('show','Album',NULL,array('album'=>$album));
	}

}
?>