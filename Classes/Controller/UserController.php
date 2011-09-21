<?php

/***************************************************************
*  Copyright notice
*
*  (c) 2010 Pascal Jungblut <mail@pascal-jungblut.com>
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
 * Controller for the User object
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Pascal Jungblut <mail@pascalj.com>
 */
class Tx_Community_Controller_UserController extends Tx_Community_Controller_BaseController implements Tx_Community_Controller_Cacheable_ControllerInterface {

	/**
	 * Get a profile image. We simply assign the user to the view and
	 * let a viewhelper do the work.
	 */
	public function imageAction() {
		$this->view->assign('user', $this->getRequestedUser());
	}


	/**
	 * Show the details like name, contact, homepage and so on.
	 */
	public function detailsAction() {
		$this->view->assign('displayWallList', $this->hasAccess('profile.wall.list'));
		$this->view->assign('displayWallForm', $this->hasAccess('profile.wall.form'));

		$this->view->assign('user', $this->getRequestedUser());
	}

	/**
	 * Interactions on the userprofile. Like adding relations and initiating a message.
	 */
	public function interactionAction() {
		$this->view->assign('requestedUser', $this->getRequestedUser());
		$this->view->assign('requestingUser', $this->getRequestingUser());
		$this->view->assign('relation', $this->getRelation());
	}

	/**
	 * Edit the details of a user.
	 *
	 * @param Tx_Community_Domain_Model_User $user
	 * @dontvalidate $user
	 */
	public function editAction(Tx_Community_Domain_Model_User $user = NULL) {
		// we can implement the possibility to edit users in the FE for admins
		if ($this->ownProfile()) {
			$requestedUser = $user ? $user : $this->getRequestedUser();
			$this->view->assign('user', $requestedUser);
			$this->view->assign('requestingUser', $this->getRequestingUser());
		}
	}

	/**
	 * Upload an image
	 *
	 * @param Tx_Community_Domain_Model_User $user
	 */
	public function editImageAction() {
		$this->view->assign('user', $this->getRequestingUser());
	}

	/**
	 * Update the image
	 *
	 * @param Tx_Community_Domain_Model_User $user
	 */
	public function updateImageAction(Tx_Community_Domain_Model_User $user) {

		$imagePath = $this->handleUpload(
			'user.image',
			$this->settings['profile']['image']['prefix'],
			$this->settings['profile']['image']['types']
			);
		if (!is_int($imagePath)) {
			$user->setImage($imagePath);
			$this->repositoryService->get('user')->update($user);

			$newPhoto = new Tx_Community_Domain_Model_Photo;
			$newPhoto->setImage($imagePath);

			$this->photoToSpecialAlbum($newPhoto, Tx_Community_Domain_Model_Album::ALBUM_TYPE_AVATAR);

			$this->flashMessageContainer->add($this->_('profile.updateImage.success'));
			$this->redirect('edit', 'User', NULL, array('user' => $user));
		} else {
			$this->flashMessageContainer->add($this->_('profile.updateImage.error'));
			$this->redirect('editImage', 'User', NULL, array('user' => $user));
		}
	}
	
	/**
	 * Delete the image
	 *
	 * @param Tx_Community_Domain_Model_User $user
	 */
	public function deleteImageAction() {
		$this->requestingUser->setImage('');
		$this->repositoryService->get('user')->update($this->requestingUser);
		$this->redirect('edit', 'User');
	}

	/**
	 * Update the edited user.
	 *
	 * @param Tx_Community_Domain_Model_User $user
	 */
	public function updateAction(Tx_Community_Domain_Model_User $updatedUser) {
		$this->repositoryService->get('user')->update($updatedUser);
		$this->redirectToUser($updatedUser);
	}

	/**
	 * Search a user by name
	 */
	public function searchAction() {
		$users = array();
		if ($this->request->hasArgument('searchWord')) {
			$word = $this->request->getArgument('searchWord');
			$users = $this->repositoryService->get('user')->searchByName($word);
		}
		$this->view->assign('users', $users);
	}

	/**
	 * Give search box
	 *
	 */
	public function searchBoxAction() {
	}

	/**
	 * Get the identifier for this request (used for caching)
	 *
	 * @param object $request
	 */
	public function getIdentifier($request) {
		$requestSettings = array(
			'controller' => $request->getControllerName(),
			'action' => $request->getControllerActionName(),
			'arguments' => $request->getArguments()
		);
		return array($this->settings, $requestSettings);
	}

	/**
	 * Get the tags for this request (caching)
	 */
	public function getTags() {
		return Tx_Community_Helper_RepositoryHelper::getRepository('User')->getTags();
	}
}
?>