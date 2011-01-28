<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Pascal Jungblut <mail@pascalj.de>
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
 * A base controller that implements basic functions that are needed
 * all over the project. Holds the requested and requesting user.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Pascal Jungblut <mail@pascalj.com>
 */
class Tx_Community_Controller_BaseController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * the user who is requested to view
	 *
	 * @var Tx_Community_Domain_Model_User
	 */
	protected $requestedUser = NULL;

	/**
	 * The requesting user. Normally the logged in fe_user
	 *
	 * @var Tx_Community_Domain_Model_User
	 */
	protected $requestingUser = NULL;

	/**
	 * Repository service. Get all your repositories with it.
	 *
	 * @var Tx_Community_Service_RepositoryServiceInterface
	 */
	protected $repositoryService;

	/**
	 * The access helper. It mainly is a wrapper class for all permissions.
	 *
	 * @var Tx_Community_Service_Access_AccessServiceInterface
	 */
	protected $accessHelper;

	/**
	 * @var Tx_Community_Service_SettingsService
	 */
	protected $settingsService;

 	/**
	 * Initialize before every action.
	 */
	protected function initializeAction() {
                //redirect if user is not logged in
                if (!$this->getRequestingUser()) {
			$this->redirectToLogin();
		}
                $this->getRequestedUser();
		$this->settingsService->set($this->settings);
                $controllerName =  $this->request->getControllerName();
                $actionName = $this->request->getControllerActionName();
                $resourceName = $this->accessHelper->getResourceName($controllerName, $actionName);
              
                 if ($this->hasAccess($resourceName) !='1') {
                          //access denied
                    $this->flashMessageContainer->add($this->_('access.denied'));
                 //   $this->flashMessageContainer->add("You don't have permission to access ".$this->hasAccess($resourceName)." resource: ".$resourceName." ActionName: ".$actionName." LU: ".$this->getRequestingUser()->getUid()." RQD:".$this->getRequestedUser()->getUid());
                    $this->redirectToUser($this->getRequestingUser());
		}
      //        $this->flashMessageContainer->add("You have access ".$this->hasAccess($resourceName)." to resource: ".$resourceName." ActionName: ".$actionName." LU: ".$this->getRequestingUser()->getUid()." RQD:".$this->getRequestedUser()->getUid());

	}

	/**
	 * Inject the access helper.
	 *
	 * @param Tx_Community_Helper_AccessHelperInterface $accessHelper
	 */
	public function injectAccessHelper(Tx_Community_Service_Access_AccessServiceInterface $accessHelper) {
		$this->accessHelper = $accessHelper;
	}

	/**
	 * Inject the repository service.
	 *
	 * @param Tx_Community_Service_RepositoryServiceInterface $repositoryService
	 */
	public function injectRepositoryService(Tx_Community_Service_RepositoryServiceInterface $repositoryService) {
		$this->repositoryService = $repositoryService;
	}

	/**
	 * Inject the settings service
	 *
	 * @param Tx_Community_Service_SettingsService $settingsService
	 */
	public function injectSettingsService(Tx_Community_Service_SettingsService $settingsService) {
		$this->settingsService = $settingsService;
	}

	/**
	 * Get the requested user
	 *
	 * @return Tx_Community_Domain_Model_User
	 */
	protected function getRequestedUser() {
		if (!$this->requestedUser) {
			if ($this->request->hasArgument('user') && !is_array($this->request->getArgument('user'))) {
				$this->requestedUser = $this->repositoryService->get('user')->findByUid((int) $this->request->getArgument('user'));
			} else {
				$this->requestedUser = $this->getRequestingUser();
			}
		}
		return $this->requestedUser;
	}

	/**
	 * Get the requesting user
	 *
	 * @return Tx_Community_Domain_Model_User
	 */
	protected function getRequestingUser() {
		if (!$this->requestingUser) {
			$this->requestingUser = $this->repositoryService->get('user')->findCurrentUser();
		}
		return $this->requestingUser;
	}

	/**
	 * Translate $key
	 *
	 * @param string $key
	 * @param array $arguments
	 */
	protected function _($key, $arguments = array()) {
		$translator = new Tx_Extbase_Utility_Localization();
		return $translator->translate($key,'community', $arguments);
	}

	/**
	 * Check if the user is on his own profile
	 */
	protected function ownProfile() {
		if ($this->getRequestingUser()) {
			return $this->getRequestingUser()->getUid() == $this->getRequestedUser()->getUid();
		} else {
			return false;
		}
	}

	/**
	 * Checks if a user or visitor has the right to view a $resource
	 *
	 * @param string $resource
	 */
	public function hasAccess($resource) {
		return $this->accessHelper->hasAccess($this->requestingUser, $this->requestedUser, $resource);
	}

	/**
	 * Redirect to the login page
	 */
	protected function redirectToLogin() {
		if ($this->settings['loginPage']) {
			$this->redirect(NULL, NULL, NULL, NULL, $this->settings['loginPage']);
		} else {
			$this->redirectToURI('');
		}
	}

	/**
	 * Redirects to a user page. Makes sure that there is always a "user" argument in the url
	 *
	 * @param Tx_Community_Domain_Model_User $user
	 */
	protected function redirectToUser(Tx_Community_Domain_Model_User $user) {
		$this->redirect(NULL, NULL, NULL, array('user' => $user), ($this->settings['profilePage'] ? $this->settings['profilePage'] : $GLOBALS['TSFE']->id));
	}



	/**
	 * Handles an uploaded file
	 *
	 * @author Steffen Ritter
	 * @param string $property
	 * @param string $uploadDir
	 * @param string $types
	 * @param string $maxSize
	 */
	protected function handleUpload($property, $uploadDir, $types = 'jpg,gif,png', $maxSize = '1000000') {
		$data = $_FILES['tx_' . strtolower($this->request->getControllerExtensionName())];
		if(is_array($data) && count($data)>0) {
			$propertyPath = t3lib_div::trimExplode('.',$property);
			$namePath = $data['name'];
			$tmpPath = $data['tmp_name'];
			$sizePath = $data['size'];
			foreach($propertyPath as $segment) {
				$namePath = $namePath[$segment];
				$tmpPath = $tmpPath[$segment];
				$sizePath = $sizePath[$segment];
			}
			if($namePath !== NULL && $namePath !== '') {
				$fileArray = array(
					'name' => $namePath,
					'tmp'  => $tmpPath,
					'size' => $sizePath,
				);
			} else {
				return 1;
			}
		} else {
			return 0;
		}

		if($fileArray['size'] > $maxSize) {
			return 2;
		}
		$fileInfo = pathinfo($fileArray['name']);
		if(!t3lib_div::inList($types, strtolower($fileInfo['extension']))) {
			return 3;
		}

		if(file_exists(PATH_site . $uploadDir . $fileArray['name'])) {
			$fileArray['name'] = $fileInfo['filename'] . '-' . time() . '.' . $fileInfo['extension'];
		}
		if(t3lib_div::upload_copy_move($fileArray['tmp'], PATH_site . $uploadDir . $fileArray['name'])) {
			return $fileArray['name'];
		} else {
			return 4;
		}
	}
}
?>
