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
 * Abstract notification handler
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Tymoteusz Motylewski <t.motylewski@gmail.com>
 */
abstract class Tx_Community_Service_Notification_AbstractHandler implements Tx_Community_Service_Notification_HandlerInterface, t3lib_Singleton {

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
	 * @param Tx_Community_Service_Notification_Notification $notification
	 * @param array $configuration from plugin.tx_community.settings.notification.rules.XXX.YYY
	 * @return void
	 */
	public function send(Tx_Community_Service_Notification_Notification $notification, array $configuration) {
	}

	/**
	 * @param Tx_Community_Service_Notification_Notification $notification Object passed to fluid view
	 * @param array $methodConfiguration
	 * @return string
	 */
	protected function render(Tx_Community_Service_Notification_Notification $notification, array $methodConfiguration) {
		$view = $this->objectManager->get('Tx_Fluid_View_StandaloneView'); /* @var $view Tx_Fluid_View_StandaloneView */

		$settings = $this->settingsService->get();
		$view->setTemplatePathAndFilename(t3lib_div::getFileAbsFileName($settings['notification']['templateRootPath'].$methodConfiguration['template'].'.html'));
		$view->setLayoutRootPath(t3lib_div::getFileAbsFileName($settings['notification']['layoutRootPath']));
		$view->setPartialRootPath(t3lib_div::getFileAbsFileName($settings['notification']['partialRootPath']));

		$view->assign('plainText', false);
		$view->assign('notification', $notification);
		$view->assign('settings', $settings);

		$view->assign('subject', true);
		$subject = $view->render();

		$view->assign('subject', false);
		$bodyHTML = $view->render();

		$view->assign('plainText', true);
		$bodyPlain = $view->render();

		return array('subject' => $subject, 'bodyHTML' => $bodyHTML, 'bodyPlain' => $bodyPlain);
	}

}
?>