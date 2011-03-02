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
 * A simple access helper.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Pascal Jungblut <mail@pascalj.com>
 */
class Tx_Community_Service_Access_SimpleAccessService implements Tx_Community_Service_Access_AccessServiceInterface, t3lib_Singleton {

	/**
	 * Logged out users
	 *
	 * @var int
	 */
	const ACCESS_NOBODY = 'nobody';

	/**
	 * Logged in users - no friends
	 *
	 * @var int
	 */
	const ACCESS_OTHER = 'other';

	/**
	 * Friends
	 *
	 * @var int
	 */
	const ACCESS_FRIEND = 'friend';

	/**
	 * @var Tx_Community_Service_RepositoryServiceInterface
	 */
	protected $repositoryService;

	/**
	 * @var Tx_Community_Service_SettingsService
	 */
	protected $settingsService;

	/**
	 * An array containing a mapping between action and resource names
	 * If
	 */
	protected $actionResourceMap = array(
		'Message' => array(
			//'inbox' => 'message.inbox',
			//'outbox' => 'message.outbox',
			//'unread' => 'message.unread',
			'write' => 'message.write',
			//  'send' => 'message.send',
			// 'read' => 'message.read',
			//   'delete' => 'message.delete',
		),
		'User' => array(
			'image' => 'profile.image',
			'edit' => 'profile.edit',
			'search' => 'user.search',
			'update' => 'profile.edit',
			'details' => 'profile.details',
			'interaction' => 'profile.menu',
			'editImage' => 'profile.edit.image',
		),
		'Relation' => array(
			'listSome' => 'profile.relation.listSome',
			'list' => 'profile.relation.list',
			'request' => 'profile.relation.request',
			'confirm' => 'profile.relation.confirm',
			'reject' => 'profile.relation.reject',
			'unconfirmed' => 'profile.relation.unconfirmed',
			'cancel' => 'profile.relation.cancel',
		),
		'WallPost' => array(
			'list' => 'profile.wall.list',
			'new' => 'profile.wall.write',
			'create' => 'profile.wall.write',
		),

	);

	/**
	 * Return resource name for given action and controller name
	 * @param string $controllerName
	 * @param string $actionName
	 * @return
	 */
	public function getResourceName($controllerName, $actionName) {
		return $this->actionResourceMap[$controllerName][$actionName];
	}

	/**
	 * Check if a $requestingUser has access to $resource of $requestedUser
	 *
	 * @param Tx_Community_Domain_Model_User $requestingUser
	 * @param Tx_Community_Domain_Model_User $requestedUser
	 * @param string $resource
	 */
	public function hasAccess(
		Tx_Community_Domain_Model_User $requestingUser = NULL,
		Tx_Community_Domain_Model_User $requestedUser = NULL,
		$resource = ''
	) {
		if ($requestedUser && $requestingUser && ($requestingUser->getUid() == $requestedUser->getUid())) {
			return true;
		}
		$type = $this->getAccessType($requestingUser, $requestedUser);
		return $this->typeHasAccessToResource($type, $resource);
	}

	/**
	 * Inject the repository service
	 *
	 * @param Tx_Community_Service_RepositoryServiceInterface $repositoryService
	 */
	public function injectRepositoryService(
	Tx_Community_Service_RepositoryServiceInterface $repositoryService
	) {
		$this->repositoryService = $repositoryService;
	}

	/**
	 * Inject the settings service.
	 *
	 * @param Tx_Community_Service_SettingsService $settingsService
	 */
	public function injectSettingsService(Tx_Community_Service_SettingsService $settingsService) {
		$this->settingsService = $settingsService;
	}


	/**
	 * Get the access type.
	 *
	 * Distinguishes between friend, "other" (logged in but not a friend) and nobody,
	 * anonymous users.
	 *
	 * @param Tx_Community_Domain_Model_User $requestingUser
	 * @param Tx_Community_Domain_Model_User $requestedUser
	 * @return int
	 */
	protected function getAccessType(
	Tx_Community_Domain_Model_User $requestingUser = NULL,
	Tx_Community_Domain_Model_User $requestedUser = NULL
	) {
		// first case: $requestingUser is NULL: anonymous rule
		if ($requestingUser === NULL) {
			return self::ACCESS_NOBODY;
		}
		// second case: friends
		if ($requestingUser != NULL && $requestedUser != NULL) {
			$relationRepository = $this->repositoryService->get('Relation');
			$relation = $relationRepository->findRelationBetweenUsers($requestingUser, $requestedUser);
			if ($relation && $relation->getStatus() == Tx_Community_Domain_Model_Relation::RELATION_STATUS_CONFIRMED) {
				return self::ACCESS_FRIEND;
			}
		}
		// everything else must be "other"
		return self::ACCESS_OTHER;
	}

	/**
	 * Check if a type has access to a resource.
	 *
	 * @param string $type
	 * @param string $resource
	 * @return
	 */
	protected function typeHasAccessToResource($type, $resource) {
		//TODO: what type should it return? bool? int? string?
		$resourcePath = array_merge(array($type), explode('.', $resource));
		$settings = $this->settingsService->get();

		return $this->traverseResourcePath($settings['accessRules'], $resourcePath);
	}

	/**
	 * Recursively traverses through the resource path.
	 *
	 * @param array $settings
	 * @param array $resourcePath
	 */
	protected function traverseResourcePath($settings, $resourcePath, $lastAccess = 0) {
		$element = array_shift($resourcePath);

		if (is_array($settings[$element])) {
			return $this->traverseResourcePath($settings[$element], $resourcePath, (isset($settings['access']) ? $settings['access'] : $lastAccess));
		} else {
			return isset($settings['access']) ? $settings['access'] : $lastAccess;
		}
	}
}
?>