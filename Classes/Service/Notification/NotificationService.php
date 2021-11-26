<?php

namespace Macopedia\Community\Service\Notification;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Tymoteusz Motylewski <t.motylewski@gmail.com>
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
 * Service used to dispatch different kind of notifications
 *
 *
 * @author Konrad Baumgart
 */
class NotificationService implements NotificationServiceInterface, \TYPO3\CMS\Core\SingletonInterface
{

    /**
     * @var array
     */
    protected $settings;

    /**
     * @var \Macopedia\Community\Service\SettingsService
     */
    protected $settingsService;


    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * Iterate through settings and send message using appropriate handler (mail/wall/PM/....)
     * @param Notification $notification used by handlers
     * @return void
     */
    public function notify(Notification $notification)
    {

        $methods = $this->getNotificationMethods($notification->getRule());
        if ($methods) {
            $defaults = $this->getNotificationDefaults();
            foreach ($methods as $k => $method) {
                $method = array_merge($defaults, $method); //override defaults with method settings
                if ($this->isValidNotification($notification, $method)) {
                    $handler = $this->objectManager->get($method['handler']);
                    try {
                        $handler->send($notification, $method);
                    } catch (\Exception $e) {
                        \TYPO3\CMS\Core\Utility\GeneralUtility::sysLog("Couldn't send email: " . $e->getMessage(), 'community', \TYPO3\CMS\Core\Utility\GeneralUtility::SYSLOG_SEVERITY_ERROR);
                    }
                }
            }
        }
    }

    /**
     * Prevents from sending notification to user himself
     * @param Notification $notification
     * @param array $configuration
     * @return bool
     */
    protected function isValidNotification(Notification $notification, array $configuration)
    {
        if ($notification->getSender() && $notification->getRecipient()) {
            if ($notification->getRecipient()->getUid() != $notification->getSender()->getUid()
                || $configuration['allowSelfNotification'] == 1
            ) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get array of available notification handlers for given rule name
     * @param string $ruleName resourceName
     * @return array
     */
    protected function getNotificationMethods($ruleName)
    {
        if (empty($this->settings)) {
            $this->settings = $this->settingsService->get();
        }
        return $this->settings['notification']['rules'][$ruleName];
    }

    /**
     * Get array of default configuration for handlers
     * @return array
     */
    protected function getNotificationDefaults()
    {
        if (empty($this->settings)) {
            $this->settings = $this->settingsService->get();
        }
        return $this->settings['notification']['defaults'];
    }

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
     * Inject the settings service
     *
     * @param \Macopedia\Community\Service\SettingsService $settingsService
     */
    public function injectSettingsService(\Macopedia\Community\Service\SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

}
