<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 Tymoteusz Motylewski <t.motylewski@gmail.com>
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
 * Handler for single way of notifying user
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Tymoteusz Motylewski <t.motylewski@gmail.com>
 */
class Tx_Community_Service_Notification_BaseHandler implements Tx_Community_Service_Notification_HandlerInterface, t3lib_Singleton {

	/**
	 * @var Tx_Extbase_Object_ObjectManagerInterface
	 */
	protected $objectManager;

	/**
	 * Inject the object manager so we can create objects on our own.
	 *
	 * @param Tx_Extbase_Object_ObjectManagerInterface $objectManager
	 */
	public function injectObjectManager(Tx_Extbase_Object_ObjectManagerInterface $objectManager) {
		$this->objectManager = $objectManager;
	}

	/**
	 * Repository service. Get all your repositories with it.
	 *
	 * @var Tx_Community_Service_RepositoryServiceInterface
	 */
	protected $repositoryService;

	/**
	 * Inject the repository service.
	 *
	 * @param Tx_Community_Service_RepositoryServiceInterface $repositoryService
	 */
	public function injectRepositoryService(Tx_Community_Service_RepositoryServiceInterface $repositoryService) {
		$this->repositoryService = $repositoryService;
	}

	/**
	 * @var Tx_Community_Service_SettingsService
	 */
	protected $settingsService;

	/**
	 * Inject the settings service
	 *
	 * @param Tx_Community_Service_SettingsService $settingsService
	 */
	public function injectSettingsService(Tx_Community_Service_SettingsService $settingsService) {
		$this->settingsService = $settingsService;
	}

	/**
	 * Override it to implement your notification handler
	 * You want to use render() inside
	 *
	 * @abstract
	 * @param array $arguments Objects passed to fluid view (not only)
	 *		Notable arguments:
	 *			$arguments['sender'] Tx_Community_Domain_Model_User
	 *			$arguments['recipient'] Tx_Community_Domain_Model_User
	 *			$arguments['recipients'] array of Tx_Community_Domain_Model_User
	 *			$arguments['subject'] string - some handlers set message subject
	 * @param array $methodConfiguration from plugin.tx_community.settings.notification.rules.XXX.YYY
	 * @return void
	 */
	public function send(array $arguments, array $methodConfiguration) {
	}

	/**
	 * @param array $arguments Objects passed to fluid view
	 * @param array $mathodConfiguration
	 * @return string
	 */
	protected function render(array $arguments, array $methodConfiguration) {
		$view = $this->objectManager->get('Tx_Fluid_View_StandaloneView');
		/* @var $view Tx_Fluid_View_StandaloneView */
		$arguments['settings'] = $this->settingsService->get();
		$view->setTemplatePathAndFilename(t3lib_div::getFileAbsFileName($arguments['settings']['notification']['templateRootPath'].'/Notification/'.$methodConfiguration['template'].'.html'));
		$view->assignMultiple($arguments);
		return $view->render();
	}

}
?>
