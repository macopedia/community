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
	 * @var Tx_Community_Service_Notification_NotificationServiceInterface $notificationService
	 */
	protected $notificationService;

	/**
	 * If we have already benn redirected, don't show the flashmessages
	 * @var bool
	 */
	static protected $redirected = FALSE;

	/**
	 * @var bool
	 */
	protected $noAccess;

	/**
	 * Initialize before every action.
	 */
	protected function initializeAction() {

		$this->findRequestedAndRequestingUser();
		$this->settingsService->set($this->settings);
		$controllerName = $this->request->getControllerName();
		$actionName = $this->request->getControllerActionName();
		$resourceName = $this->accessHelper->getResourceName($controllerName, $actionName);
		$this->noAccess = 0;

		if ($this->hasAccess($resourceName) != '1') {
			//access denied
			if ($this->settings['debug']) {
				$this->flashMessageContainer->add(
					"You do not have permission (".$this->hasAccess($resourceName).
					") to access  resource: ".$resourceName.
					", ActionName: ".$actionName.
					($this->getRequestingUser()?", RequestingUser: ".$this->getRequestingUser()->getUid():"").
					($this->getRequestedUser()?", RequestedUser:".$this->getRequestedUser()->getUid():"").
					", AccesType: ".$this->accessHelper->getAccessType($this->getRequestingUser(),$this->getRequestedUser()),
					"Debug",
					t3lib_FlashMessage::WARNING
				);
			}
			$this->noAccess = 1;
		}
	}

	/**
	 * Prepare view - assign requestedUser and requestingUser
	 * @param Tx_Extbase_MVC_View_ViewInterface $view
	 * @return void
	 */
	protected function initializeView(Tx_Extbase_MVC_View_ViewInterface $view) {
		parent::initializeView($view);
		$this->view->assign('requestedUser',$this->getRequestedUser());
		$this->view->assign('requestingUser',$this->getRequestingUser());
	}

	/**
	 * Doesn't call action method if no access, otherwise acts normally
	 */
	protected function callActionMethod() {
		if ($this->noAccess) {
			$this->response->appendContent("");
			return ;
		} else {
			return parent::callActionMethod();
		}
	}

	/**
	 * Injects the Configuration Manager and is initializing the framework settings
	 * Function is used to override the merge of settings via TS & flexforms
	 *
	 * @param Tx_Extbase_Configuration_ConfigurationManagerInterface An instance of the Configuration Manager
	 * @return void
	 */
	public function injectConfigurationManager(Tx_Extbase_Configuration_ConfigurationManagerInterface $configurationManager) {
		$this->configurationManager = $configurationManager;
		$this->settings = $this->configurationManager->getConfiguration(Tx_Extbase_Configuration_ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS);

		$settingsToCheck = t3lib_div::trimExplode(',', $this->settings['overrideFlexformSettingsIfEmpty'], TRUE);
		foreach ($settingsToCheck as $key) {
			// if flexform setting is empty and value is available in TS
			if ((!isset($this->settings[$key]) || empty($this->settings[$key]))
					&& isset($GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_community.']['settings.'][$key])) {
				$this->settings[$key] = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_community.']['settings.'][$key];
			}

		}
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
	 * Inject notification service
	 *
	 * @param Tx_Community_Service_Notification_NotificationServiceInterface $notificationService
	 */
	public function injectNotificationService(Tx_Community_Service_Notification_NotificationServiceInterface $notificationService) {
		$this->notificationService = $notificationService;
	}

	/**
	 * Finds the requested user, if there is any request argument that specifies requested user.
	 *
	 * Some objects (like photos or albums) have users assigned to them.
	 * To avoid security mistakes we check arguments (like tx_community['foo']=88) in a
	 * specific order and the first one that is set is the only one taken into account later on.
	 * TODO: hook in this function
	 *
	 * @return void
	 */
	protected function fetchRequestedUserFromRequestArguments() {
		$argumentsPriority = array('photo','album','relation','user');

		$foundUser = false;
		foreach ($argumentsPriority as $argument) {
			if ($foundUser) {
				$this->request->setArgument($argument, NULL);
			} else if ($this->request->hasArgument($argument) && !is_array($this->request->getArgument($argument))) {
				$foundUser = true;
				switch ($argument) {
					case 'photo':
						//If we request album or photo then the owner of album is requested user and we ignore/override 'user' argument
						$this->requestedUser = $this->repositoryService->get('photo')
													->findByUid((int) $this->request->getArgument('photo'))
													->getAlbum()
													->getUser();
						break;
					case 'album':
						$this->requestedUser = $this->repositoryService->get('album')
													->findByUid((int) $this->request->getArgument('album'))
													->getUser();
						break;
					case 'relation':
						$relation = $this->repositoryService->get('relation')
										 ->findByUid((int) $this->request->getArgument('relation'));
						if ($relation->getInitiatingUser()->getUid() == $this->getRequestingUser()->getUid()) {
							$this->requestedUser = $relation->getRequestedUser();
						} elseif ($relation->getRequestedUser()->getUid() == $this->getRequestingUser()->getUid()) {
							$this->requestedUser = $relation->getInitiatingUser();
						} else {
							throw new Tx_Community_Exception_UnexpectedException(
									'User ' . $this->getRequestingUser()->getUid() . ' is not in relation ' . $this->request->getArgument('relation')
							);
						}
						break;
					case 'user':
						$this->requestedUser = $this->repositoryService->get('user')
													->findByUid((int) $this->request->getArgument('user'));
						break;
					default :
						//TODO: add hook
				}
			}
		}
	}

	/**
	 * Finds requesting and requested user
	 *
	 * After we run this function, we know that both
	 * $this->requestingUser and $this->requestedUser are set,
	 * unless there is no requesting and requested user.
	 *
	 * @return void
	 */
	protected function findRequestedAndRequestingUser() {
		$this->requestingUser = $this->repositoryService->get('user')->findCurrentUser();

		$this->fetchRequestedUserFromRequestArguments();
		if ($this->requestedUser == NULL) {
			$this->requestedUser = $this->getRequestingUser();
		}
	}

	/**
	 * Get the requested user
	 *
	 * @return Tx_Community_Domain_Model_User
	 */
	protected function getRequestedUser() {
		return $this->requestedUser;
	}

	/**
	 * Get the requesting user
	 *
	 * @return Tx_Community_Domain_Model_User
	 */
	protected function getRequestingUser() {
		return $this->requestingUser;
	}

	/**
	 * Get relation between requesting and requested user
	 *
	 * @return Tx_Community_Domain_Model_Relation
	 */
	public function getRelation() {
		if ($this->getRequestingUser()) {
			$relation = $this->repositoryService->get('relation')->findRelationBetweenUsers(
				$this->getRequestedUser(),
				$this->getRequestingUser(),
				Tx_Community_Domain_Model_Relation::RELATION_STATUS_CONFIRMED
			);
		} else {
			$relation = NULL;
		}
		return $relation;
	}

	/**
	 * Translate $key
	 *
	 * @param string $key
	 * @param array $arguments
	 */
	protected function _($key, $arguments = array()) {
		$translator = new Tx_Extbase_Utility_Localization();
		return $translator->translate($key, 'community', $arguments);
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
		return $this->accessHelper->hasAccess($this->getRequestingUser(), $this->getRequestedUser(), $resource);
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
		if (is_array($data) && count($data) > 0) {
			$propertyPath = t3lib_div::trimExplode('.', $property);
			$namePath = $data['name'];
			$tmpPath = $data['tmp_name'];
			$sizePath = $data['size'];
			foreach ($propertyPath as $segment) {
				$namePath = $namePath[$segment];
				$tmpPath = $tmpPath[$segment];
				$sizePath = $sizePath[$segment];
			}
			if ($namePath !== NULL && $namePath !== '') {
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

		if ($fileArray['size'] > $maxSize) {
			return 2;
		}
		$fileInfo = pathinfo($fileArray['name']);
		if (!t3lib_div::inList($types, strtolower($fileInfo['extension']))) {
			return 3;
		}

		if (file_exists(PATH_site . $uploadDir . $fileArray['name'])) {
			$fileArray['name'] = $fileInfo['filename'] . '-' . time() . '.' . $fileInfo['extension'];
		}
		if (t3lib_div::upload_copy_move($fileArray['tmp'], PATH_site . $uploadDir . $fileArray['name'])) {
			return $fileArray['name'];
		} else {
			return 4;
		}
	}

	/**
	 * Puts image into special album of given type owned by requesting user
	 * Adds/updates album and adds photo to repo, you dont need to care about it
	 *
	 * @param Tx_Community_Domain_Model_Photo $photo
	 * @param integer $albumType like Tx_Community_Domain_Model_Album::ALBUM_TYPE_AVATAR
	 */
	protected function photoToSpecialAlbum(Tx_Community_Domain_Model_Photo $newPhoto, $albumType) {
		$user = $this->requestingUser;
		$album = $this->repositoryService->get('album')->findOneByUserAndType($user,$albumType);
		if (!$album) {
			$album = new Tx_Community_Domain_Model_Album;
			$album->setAlbumType($albumType);
			$album->setName($this->_('profile.album.albumTypeName.'.$albumType));
			$album->setUser($user);
			$album->setMainPhoto($newPhoto);
			$this->repositoryService->get('album')->add($album);
		}
		$album->addPhoto($newPhoto);
		$this->repositoryService->get('photo')->add($newPhoto);
	}

	/**
	 * We want to know if we were already redirected
	 * @see Tx_Extbase_MVC_Controller_AbstractController::redirect()
	 *
	 * @param string $actionName Name of the action to forward to
	 * @param string $controllerName Unqualified object name of the controller to forward to. If not specified, the current controller is used.
	 * @param string $extensionName Name of the extension containing the controller to forward to. If not specified, the current extension is assumed.
	 * @param Tx_Extbase_MVC_Controller_Arguments $arguments Arguments to pass to the target action
	 * @param integer $pageUid Target page uid. If NULL, the current page uid is used
	 * @param integer $delay (optional) The delay in seconds. Default is no delay.
	 * @param integer $statusCode (optional) The HTTP status code for the redirect. Default is "303 See Other"
	 * @return void
	 * @throws Tx_Extbase_MVC_Exception_UnsupportedRequestType If the request is not a web request
	 * @throws Tx_Extbase_MVC_Exception_StopAction
	 */
	protected function redirect($actionName, $controllerName = NULL, $extensionName = NULL, array $arguments = NULL, $pageUid = NULL, $delay = 0, $statusCode = 303) {
		Tx_Community_Controller_BaseController::$redirected = TRUE;
		parent::redirect($actionName, $controllerName, $extensionName, $arguments, $pageUid, $delay, $statusCode);
	}

	/**
	 * If there were validation errors, we don't want to write details like
	 * "An error occurred while trying to call Tx_Community_Controller_UserController->updateAction()"
	 *
	 * @return string|boolean The flash message or FALSE if no flash message should be set
	 */
	protected function getErrorFlashMessage() {
		if ($this->settings['debug']) {
			return parent::getErrorFlashMessage();
		}
		return FALSE;
	}
}

?>
