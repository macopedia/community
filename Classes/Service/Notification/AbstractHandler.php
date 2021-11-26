<?php

namespace Macopedia\Community\Service\Notification;

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

use Macopedia\Community\Service\RepositoryServiceInterface,
    Macopedia\Community\Service\SettingsService;

/**
 * Abstract notification handler
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
abstract class AbstractHandler implements HandlerInterface, \TYPO3\CMS\Core\SingletonInterface
{

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * Inject the object manager so we can create objects on our own.
     *
     * @param \TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager
     */
    public function injectObjectManager(\TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * Repository service. Get all your repositories with it.
     *
     * @var RepositoryServiceInterface
     */
    protected $repositoryService;

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
     * @var SettingsService
     */
    protected $settingsService;

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
     * Override it to implement your notification handler
     * You want to use render() inside
     *
     * @abstract
     * @param Notification $notification
     * @param array $configuration from plugin.tx_community.settings.notification.rules.XXX.YYY
     * @return void
     */
    public function send(Notification $notification, array $configuration)
    {
    }

    /**
     * @param Notification $notification Object passed to fluid view
     * @param array $methodConfiguration
     * @return array
     */
    protected function render(Notification $notification, array $methodConfiguration)
    {
        $view = $this->objectManager->get('TYPO3\CMS\Fluid\View\StandaloneView');
        /* @var $view \TYPO3\CMS\Fluid\View\StandaloneView */

        $settings = $this->settingsService->get();
        $view->setTemplatePathAndFilename(\TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($settings['notification']['templateRootPath'] . $methodConfiguration['template'] . '.html'));
        $view->setLayoutRootPath(\TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($settings['notification']['layoutRootPath']));
        $view->setPartialRootPath(\TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($settings['notification']['partialRootPath']));

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
