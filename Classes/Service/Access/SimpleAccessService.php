<?php

namespace Macopedia\Community\Service\Access;

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

use Macopedia\Community\Domain\Model\Relation;
use Macopedia\Community\Domain\Model\User;
use Macopedia\Community\Service\RepositoryServiceInterface;
use Macopedia\Community\Service\SettingsService;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

/**
 * A simple access helper.
 *
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Pascal Jungblut <mail@pascalj.com>
 */
class SimpleAccessService implements AccessServiceInterface, SingletonInterface
{
    /**
     * Logged out users, and requested user not set
     *
     * @var string
     */
    public const ACCESS_PUBLIC = 'public';
    /**
     * Logged out users, requested user set
     *
     * @var string
     */
    public const ACCESS_NOBODY = 'nobody';

    /**
     * Logged in users - no friends
     *
     * @var string
     */
    public const ACCESS_OTHER = 'other';

    /**
     * Friends
     *
     * @var string
     */
    public const ACCESS_FRIEND = 'friend';

    /**
     * @var \Macopedia\Community\Service\RepositoryServiceInterface
     */
    protected $repositoryService;

    /**
     * @var \Macopedia\Community\Service\SettingsService
     */
    protected $settingsService;

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * Return resource name for given action and controller name
     * @param string $controllerName
     * @param string $actionName
     * @return string
     */
    public function getResourceName($controllerName, $actionName)
    {
        $settings = $this->settingsService->get();
        return $settings['accessActionResourceMap'][$controllerName][$actionName];
    }

    /**
     * Check if a $requestingUser has access to $resource of $requestedUser
     *
     * @param User $requestingUser
     * @param User $requestedUser
     * @param string $resource
     * @return bool
     */
    public function hasAccess(
        User $requestingUser = null,
        User $requestedUser = null,
        $resource = ''
    ) {
        if ($requestedUser && $requestingUser && ($requestingUser->getUid() == $requestedUser->getUid())) {
            return true;
        }
        $type = $this->getAccessType($requestingUser, $requestedUser);
        return $this->typeHasAccessToResource($type, $resource);
    }

    /**
     * Check if the user is on his own profile
     * @param User $requestingUser
     * @param User $requestedUser
     * @return bool
     */
    public function sameUser($requestingUser, $requestedUser)
    {
        if ($requestingUser) {
            return $requestingUser->getUid() == $requestedUser->getUid();
        }
        return false;
    }

    /**
     * Inject the repository service
     *
     * @param \Macopedia\Community\Service\RepositoryServiceInterface $repositoryService
     */
    public function injectRepositoryService(RepositoryServiceInterface $repositoryService)
    {
        $this->repositoryService = $repositoryService;
    }

    /**
     * Inject the object manager so we can create objects on our own.
     *
     * @param \TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager
     */
    public function injectObjectManager(ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * Inject the settings service.
     *
     * @param \Macopedia\Community\Service\SettingsService $settingsService
     */
    public function injectSettingsService(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    /**
     * Get the access type.
     *
     * Distinguishes between friend, "other" (logged in but not a friend) and nobody,
     * anonymous users.
     *
     * @param User $requestingUser
     * @param User $requestedUser
     * @return string
     */
    public function getAccessType(
        User $requestingUser = null,
        User $requestedUser = null
    ) {
        // first case: $requestingUser is NULL: anonymous rule
        if ($requestingUser === null) {
            if ($requestedUser === null) {
                return self::ACCESS_PUBLIC;
            }
            return self::ACCESS_NOBODY;
        }
        // second case: friends
        if ($requestingUser != null && $requestedUser != null) {
            $relationRepository = $this->repositoryService->get('Relation');
            $relation = $relationRepository->findRelationBetweenUsers($requestingUser, $requestedUser);
            if ($relation && $relation->getStatus() == Relation::RELATION_STATUS_CONFIRMED) {
                return self::ACCESS_FRIEND;
            }
        }
        // everything else must be "other"
        return self::ACCESS_OTHER;
    }

    /**
     * Check if a type has access to a resource.
     *
     * @param string $type e.g. "friend"
     * @param string $resource
     * @return bool
     */
    protected function typeHasAccessToResource($type, $resource)
    {
        $resourcePath = array_merge([$type], explode('.', $resource));
        $settings = $this->settingsService->get();
        $value = $this->traverseResourcePath($settings['accessRules'], $resourcePath);
        return $value == 1;
    }

    /**
     * Recursively traverses through the resource path.
     *
     * @param array $settings
     * @param array $resourcePath
     * @param $lastAccess
     * @return string
     */
    protected function traverseResourcePath($settings, $resourcePath, $lastAccess = 0)
    {
        $element = array_shift($resourcePath);

        $lastAccess = isset($settings['access']) ? $settings['access'] : $lastAccess;
        if (is_array($settings[$element])) {
            return $this->traverseResourcePath($settings[$element], $resourcePath, $lastAccess);
        }
        return $lastAccess;
    }
}
