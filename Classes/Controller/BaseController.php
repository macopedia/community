<?php

namespace Macopedia\Community\Controller;

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

use Macopedia\Community\Domain\Model\Album;
use Macopedia\Community\Domain\Model\Photo;
use Macopedia\Community\Domain\Model\Relation;
use Macopedia\Community\Domain\Model\User;
use Macopedia\Community\Exception\UnexpectedException;
use Macopedia\Community\Service\Access\AccessServiceInterface;
use Macopedia\Community\Service\Notification\NotificationServiceInterface;
use Macopedia\Community\Service\RepositoryServiceInterface;
use Macopedia\Community\Service\SettingsService;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * A base controller that implements basic functions that are needed
 * all over the project. Holds the requested and requesting user.
 */
class BaseController extends ActionController
{
    /**
     * the user who is requested to view
     *
     * @var User
     */
    protected $requestedUser;

    /**
     * The requesting user. Normally the logged in fe_user
     *
     * @var User
     */
    protected $requestingUser;

    /**
     * Repository service. Get all your repositories with it.
     *
     * @var RepositoryServiceInterface
     */
    protected $repositoryService;

    /**
     * The access helper. It mainly is a wrapper class for all permissions.
     *
     * @var AccessServiceInterface
     */
    protected $accessService;

    /**
     * @var SettingsService
     */
    protected $settingsService;

    /**
     * @var NotificationServiceInterface $notificationService
     */
    protected $notificationService;

    /**
     * If we have already benn redirected, don't show the flash messages
     * @var bool
     */
    protected static $redirected = false;

    /**
     * @var bool
     */
    protected $accessDenied;

    /**
     * Initialize before every action.
     */
    protected function initializeAction()
    {
        $this->findRequestedAndRequestingUser();

        $this->settingsService->set($this->settings);
        $controllerName = $this->request->getControllerName();
        $actionName = $this->request->getControllerActionName();
        $resourceName = $this->accessService->getResourceName($controllerName, $actionName);
        $this->accessDenied = false;

        if ($this->settings['debug']) {
            $this->addFlashMessage(
                'Controller: ' . $controllerName . '<br />' .
                'ActionName: ' . $actionName . '<br />' .
                'resourceName: ' . $resourceName . '<br />' .
                ($this->getRequestingUser() ? 'RequestingUser: ' . htmlspecialchars($this->getRequestingUser()->getName(), ENT_QUOTES | ENT_HTML401) : '') . '<br />' .
                ($this->getRequestedUser() ? 'RequestedUser: ' . htmlspecialchars($this->getRequestedUser()->getName(), ENT_QUOTES | ENT_HTML401) : '') . '<br />' .
                'AccesType: ' . $this->accessService->getAccessType($this->getRequestingUser(), $this->getRequestedUser()),
                'Debug',
                FlashMessage::INFO
            );
        }

        if (!$this->hasAccess($resourceName)) {
            //access denied
            if ($this->settings['debug']) {
                $this->addFlashMessage(
                    'You do not have permission (' . $this->hasAccess($resourceName) .
                    ') to access  resource: ' . $resourceName .
                    ', ActionName: ' . $actionName .
                    ($this->getRequestingUser() ? ', RequestingUser: ' . $this->getRequestingUser()->getUid() : '') .
                    ($this->getRequestedUser() ? ', RequestedUser:' . $this->getRequestedUser()->getUid() : '') .
                    ', AccesType: ' . $this->accessService->getAccessType($this->getRequestingUser(), $this->getRequestedUser()),
                    'Debug',
                    FlashMessage::WARNING
                );
            }
            $this->accessDenied = true;
        }
    }

    /**
     * Prepare view - assign requestedUser and requestingUser
     * @param \TYPO3\CMS\Extbase\Mvc\View\ViewInterface $view
     */
    protected function initializeView(ViewInterface $view)
    {
        parent::initializeView($view);
        $this->view->assign('requestedUser', $this->getRequestedUser());
        $this->view->assign('requestingUser', $this->getRequestingUser());
        $this->view->assign('relation', $this->getRelation());
    }

    /**
     * Doesn't call action method if no access, otherwise acts normally
     */
    protected function callActionMethod()
    {
        if ($this->accessDenied) {
            $this->response->appendContent('');
        } else {
            parent::callActionMethod();
        }
    }

    /**
     * Injects the Configuration Manager and is initializing the framework settings
     * Function is used to override the merge of settings via TS & flexforms
     *
     * @param \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface An instance of the Configuration Manager
     */
    public function injectConfigurationManager(ConfigurationManagerInterface $configurationManager)
    {
        $this->configurationManager = $configurationManager;
        $this->settings = $this->configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS);
    }

    /**
     * Inject the access helper.
     *
     * @param AccessServiceInterface $accessHelper
     */
    public function injectAccessHelper(AccessServiceInterface $accessHelper)
    {
        $this->accessService = $accessHelper;
    }

    /**
     * Inject the repository service.
     *
     * @param RepositoryServiceInterface $repositoryService
     */
    public function injectRepositoryService(RepositoryServiceInterface $repositoryService)
    {
        $this->repositoryService = $repositoryService;
    }

    /**
     * Inject the settings service
     *
     * @param SettingsService $settingsService
     */
    public function injectSettingsService(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    /**
     * Inject notification service
     *
     * @param NotificationServiceInterface $notificationService
     */
    public function injectNotificationService(NotificationServiceInterface $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Finds the requested user, if there is any request argument that specifies requested user.
     *
     * Some objects (like photos or albums) have users assigned to them.
     * To avoid security mistakes we check arguments (like tx_community['foo']=88) in a
     * specific order and the first one that is set is the only one taken into account later on.
     * TODO: hook in this function
     * @throws UnexpectedException
     */
    protected function fetchRequestedUserFromRequestArguments()
    {
        $argumentsPriority = ['photo', 'album', 'relation', 'user'];
        $foundUser = false;
        foreach ($argumentsPriority as $argument) {
            if ($foundUser) {
                $this->request->setArgument($argument, null);
            } elseif ($this->request->hasArgument($argument)
                && !is_array($this->request->getArgument($argument))
                && $this->request->getArgument($argument) != null
            ) {
                $foundUser = true;
                switch ($argument) {
                    case 'photo':
                        //If we request album or photo then the owner of album is requested user and we ignore/override 'user' argument
                        $this->requestedUser = $this->repositoryService->get('photo')
                            ->findByUid((int)$this->request->getArgument('photo'))
                            ->getAlbum()
                            ->getUser();
                        break;
                    case 'album':
                        $this->requestedUser = $this->repositoryService->get('album')
                            ->findByUid((int)$this->request->getArgument('album'))
                            ->getUser();
                        break;
                    case 'relation':
                        $relation = $this->repositoryService->get('relation')
                            ->findByUid((int)$this->request->getArgument('relation'));
                        if ($relation->getInitiatingUser()->getUid() == $this->getRequestingUser()->getUid()) {
                            $this->requestedUser = $relation->getRequestedUser();
                        } elseif ($relation->getRequestedUser()->getUid() == $this->getRequestingUser()->getUid()) {
                            $this->requestedUser = $relation->getInitiatingUser();
                        } else {
                            throw new UnexpectedException(
                                'User ' . $this->getRequestingUser()->getUid() . ' is not in relation ' . $this->request->getArgument('relation')
                            );
                        }
                        break;
                    case 'user':
                        $this->requestedUser = $this->repositoryService->get('user')
                            ->findByUid((int)$this->request->getArgument('user'));
                        break;
                    default:
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
     */
    protected function findRequestedAndRequestingUser()
    {
        $this->requestingUser = $this->repositoryService->get('user')->findCurrentUser();
        $this->fetchRequestedUserFromRequestArguments();

        if ($this->requestedUser === null) {
            $this->requestedUser = $this->getRequestingUser();
        }
    }

    /**
     * Get the requested user
     *
     * @return User
     */
    protected function getRequestedUser()
    {
        return $this->requestedUser;
    }

    /**
     * Get the requesting user
     *
     * @return User
     */
    protected function getRequestingUser()
    {
        return $this->requestingUser;
    }

    /**
     * Get relation between requesting and requested user
     *
     * @return Relation
     */
    public function getRelation()
    {
        if ($this->getRequestingUser()) {
            $rel = $this->repositoryService->get('relation');
            $relation = $rel->findRelationBetweenUsers(
                $this->getRequestedUser(),
                $this->getRequestingUser()
            );
        } else {
            $relation = null;
        }
        return $relation;
    }

    /**
     * Translate string
     *
     * @param string $key
     * @param array $arguments
     * @return string
     */
    protected function _($key, $arguments = [])
    {
        $translation = LocalizationUtility::translate($key, $this->extensionName, $arguments);
        return !empty($translation) ? $translation : '';
    }

    /**
     * Check if the user is on his own profile
     *
     * @return bool
     */
    protected function ownProfile()
    {
        return $this->accessService->sameUser($this->getRequestingUser(), $this->getRequestedUser());
    }

    /**
     * Checks if a user or visitor has the right to view a $resource
     *
     * @param string $resource
     * @return bool
     */
    public function hasAccess($resource)
    {
        return $this->accessService->hasAccess($this->getRequestingUser(), $this->getRequestedUser(), $resource);
    }

    /**
     * Redirect to the login page
     */
    protected function redirectToLogin()
    {
        if ($this->settings['loginPage']) {
            $this->redirect(null, null, null, null, $this->settings['loginPage']);
        } else {
            $this->redirectToURI('');
        }
    }

    /**
     * Redirects to a user page. Makes sure that there is always a "user" argument in the url
     *
     * @param User $user
     */
    protected function redirectToUser(User $user)
    {
        $this->redirect(null, null, null, ['user' => $user], ($this->settings['profilePage'] ? $this->settings['profilePage'] : $GLOBALS['TSFE']->id));
    }

    /**
     * Redirects to a wall page. Makes sure that there is always a "user" argument in the url
     *
     * @param User $user
     */
    protected function redirectToWall(User $user)
    {
        $this->redirect(null, null, null, ['user' => $user], ($this->settings['wallPage'] ? $this->settings['wallPage'] : $GLOBALS['TSFE']->id));
    }

    /**
     * Handles an uploaded file
     *
     * @author Steffen Ritter
     * @param string $property
     * @param string $uploadDir upload directory
     * @param string $types file extension
     * @param int $maxSize maximal size in byte
     * @return string file name|integer error number if something goes wrong
     */
    protected function handleUpload($property, $uploadDir, $types = 'jpg,gif,png', $maxSize = 1048576)
    {
        $data = $_FILES['tx_' . strtolower($this->request->getControllerExtensionName())];
        if (is_array($data) && count($data) > 0) {
            $propertyPath = GeneralUtility::trimExplode('.', $property);
            $namePath = $data['name'];
            $tmpPath = $data['tmp_name'];
            $sizePath = $data['size'];
            foreach ($propertyPath as $segment) {
                $namePath = $namePath[$segment];
                $tmpPath = $tmpPath[$segment];
                $sizePath = $sizePath[$segment];
            }
            if ($namePath !== null && $namePath !== '') {
                $fileArray = [
                    'name' => $namePath,
                    'tmp' => $tmpPath,
                    'size' => $sizePath,
                ];
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
        if (!GeneralUtility::inList($types, strtolower($fileInfo['extension']))) {
            return 3;
        }

        if (file_exists(Environment::getPublicPath() . '/' . $uploadDir . $fileArray['name'])) {
            $fileArray['name'] = $fileInfo['filename'] . '-' . time() . '.' . $fileInfo['extension'];
        }
        if (GeneralUtility::upload_copy_move($fileArray['tmp'], Environment::getPublicPath() . '/' . $uploadDir . $fileArray['name'])) {
            return $fileArray['name'];
        }
        return 4;
    }

    /**
     * Puts image into special album of given type owned by requesting user
     * Adds/updates album and adds photo to repo, you dont need to care about it
     *
     * @param Photo $newPhoto
     * @param int $albumType like Album::ALBUM_TYPE_AVATAR
     */
    protected function photoToSpecialAlbum(Photo $newPhoto, $albumType)
    {
        $user = $this->requestingUser;
        $album = $this->repositoryService->get('album')->findOneByUserAndType($user, $albumType);
        if (!$album) {
            $album = new Album();
            $album->setAlbumType($albumType);
            $album->setName($this->_('profile.album.albumTypeName.' . $albumType));
            $album->setUser($user);
            $album->setMainPhoto($newPhoto);
            $this->repositoryService->get('album')->add($album);
        }
        $album->addPhoto($newPhoto);
        $this->repositoryService->get('photo')->add($newPhoto);
    }

    protected function redirect($actionName, $controllerName = null, $extensionName = null, array $arguments = null, $pageUid = null, $delay = 0, $statusCode = 303)
    {
        BaseController::$redirected = true;
        parent::redirect($actionName, $controllerName, $extensionName, $arguments, $pageUid, $delay, $statusCode);
    }

    /**
     * If there were validation errors, we don't want to write details like
     * "An error occurred while trying to call UserController->updateAction()"
     *
     * @return string|bool The flash message or FALSE if no flash message should be set
     */
    protected function getErrorFlashMessage()
    {
        if ($this->settings['debug']) {
            return parent::getErrorFlashMessage();
        }
        return false;
    }
}
