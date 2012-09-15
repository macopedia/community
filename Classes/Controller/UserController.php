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
	 * Shows a list of users
	 */
	public function listAction() {
		$users 		    = array();
		$groupId        = intval($this->settings['userlist']['groupId']);
		$orderBy        = $this->settings['userlist']['orderBy'];
		$orderDirection = $this->settings['userlist']['orderDirection'];
		$limit          = intval($this->settings['userlist']['limit']);
		$pagebrowser    = intval($this->settings['userlist']['pagebrowser']);
		$itemsPerPage   = intval($this->settings['userlist']['itemsPerPage']);

		switch ($this->settings['userlist']['whatToDisplay']) {
			case 'all':
				$users = $this->repositoryService->get('user')->findAllOrderBy($orderBy, $orderDirection);
				break;
			case 'group':
				$users = $this->repositoryService->get('user')->findByUsergroup($groupId, $orderBy, $orderDirection);
				break;
			case 'latest':
				// pagebrowser overwrites limit option, so disable it here
				$pagebrowser = 0;
				$users = $this->repositoryService->get('user')->findLatest($limit);
				break;
		}
		$this->view->assign('users', $users);
		$this->view->assign('pagebrowser', $pagebrowser);
		$this->view->assign('itemsPerPage', $itemsPerPage);
	}

	/**
	 * Get a profile image. We simply assign the user to the view and
	 * let a viewhelper do the work.
	 */
	public function imageAction() {
	}

	/**
	 * Show the details like name, contact, homepage and so on.
	 */
	public function detailsAction() {
		$this->view->assign('displayWallList', $this->hasAccess('profile.wall.list'));
		$this->view->assign('displayWallForm', $this->hasAccess('profile.wall.form'));
	}

	/**
	 * Interactions on the user profile. Like adding relations and initiating a message.
	 */
	public function interactionAction() {
	}

	/**
	 * Edit the details of a user.
	 */
	public function editAction() {
	}

	/**
	 * Show form to edit/upload profile image
	 */
	public function editImageAction() {
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
			$this->settings['profile']['image']['types'],
			intval($this->settings['profile']['image']['maxSize'])
		);
		if (!is_int($imagePath)) {
			$user->setImage($imagePath);
			$this->repositoryService->get('user')->update($user);

			$newPhoto = new Tx_Community_Domain_Model_Photo();
			$newPhoto->setImage($imagePath);

			$this->photoToSpecialAlbum($newPhoto, Tx_Community_Domain_Model_Album::ALBUM_TYPE_AVATAR);

			$this->flashMessageContainer->add($this->_('profile.updateImage.success'));
			$this->redirect('edit', 'User', NULL, array('user' => $user));
		} else {
			$this->flashMessageContainer->add($this->_('profile.updateImage.error'),'',t3lib_FlashMessage::ERROR);
			$this->redirect('editImage', 'User', NULL, array('user' => $user));
		}
	}

	/**
	 * Delete profile image
	 */
	public function deleteImageAction() {
		$this->requestingUser->setImage('');
		$this->repositoryService->get('user')->update($this->requestingUser);
		$this->flashMessageContainer->add($this->_('profile.deleteImage.success'));
		$this->redirect('edit', 'User');
	}

	/**
	 * Update the edited user.
	 *
	 * @param Tx_Community_Domain_Model_User $updatedUser
	 */
	public function updateAction(Tx_Community_Domain_Model_User $updatedUser) {
		$fullName = $updatedUser->getFirstName().' '.$updatedUser->getLastName();
		$updatedUser->setName($fullName);
		$this->repositoryService->get('user')->update($updatedUser);
		$this->redirect('edit');
	}

	/**
	 * Delete user account and all his data
	 */
	public function deleteAccountAction() {
		$user = $this->getRequestingUser();
		$this->repositoryService->get('relation')->deleteAllForUser($user);
		$this->repositoryService->get('message')->deleteAllForUser($user);
		$this->repositoryService->get('wallPost')->deleteAllForUser($user);
		$this->repositoryService->get('album')->deleteAllForUser($user); //we don't need to delete photos, because of @cascade remove
		$this->repositoryService->get('user')->remove($user);

		$redirectPage = $this->settings['afterAccountDeletePage'];
		$this->redirect(NULL, NULL, NULL, NULL, $redirectPage);
	}

	/**
	 * Search users
	 */
	public function searchAction() {
		$users = array();
		if ($this->request->hasArgument('searchWord') && $this->request->getArgument('searchWord') != '') {
			$word = $this->request->getArgument('searchWord');
			$users = $this->repositoryService->get('user')->searchByString($word);
		}
		$this->view->assign('users', $users);
	}

	/**
	 * Give search box
	 *
	 */
	public function searchBoxAction() {
		//everything is done in the template
	}

	/**
	 * Reports a profile with gore and nudity
	 * @param Tx_Community_Domain_Model_User $user
	 * @param string $reason
	 */
	public function reportAction(Tx_Community_Domain_Model_User $user, $reason = '') {
		if ($this->settings['profile']['reasonForReportRequired'] && strlen($reason)==0) {
			$this->flashMessageContainer->add($this->_('profile.report.needReason'),'',t3lib_FlashMessage::ERROR);
		} else {
			$this->flashMessageContainer->add($this->_('profile.report.reported'));

			$notification = new Tx_Community_Service_Notification_Notification(
				'userReport',
				$this->requestingUser,
				$this->requestedUser
			);
			$notification->setMessage($reason);
			$this->notificationService->notify($notification);
		}
		$this->redirect('details', NULL, NULL, array('user' => $user));
	}

	/**
	 * Get the identifier for this request (used for caching)
	 *
	 * @param object $request
	 * @return array
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