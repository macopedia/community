<?php

/**
 * Service used to send messages to users with multiple ways.
 *
 * @author Konrad Baumgart
 */
class Tx_Community_Service_Notification_NotificationService implements Tx_Community_Service_Notification_NotificationServiceInterface, t3lib_Singleton {

	/**
	 * @var array
	 */
	protected $settings;

	/**
	 * @var Tx_Community_Service_SettingsService
	 */
	protected $settingsService;


	/**
     * @var Tx_Extbase_Object_ObjectManagerInterface
     */
    protected $objectManager;

	/**
	 * Iterate through settings and send message using appropriate handler (mail/wall/PM/....)
	 * @param array $arguments used by handlers
	 * @param string $resourceName
	 * @return void
	 */
	public function notify(array $arguments, $resourceName) {
		$methods = $this->getNotificationMethods($resourceName);
		foreach ($methods as $k=>$method){
			$handler = $this->objectManager->get($method['handler']);
			$handler->send($arguments, $method);
		}

	}

	/**
	 * @param string resourceName
	 * @return array
	 */
	protected function getNotificationMethods($resourceName){
		if (!count($this->settings)) {
			$this->settings = $this->settingsService->get();
		}
		return $this->settings['notification']['rules'][$resourceName];
	}

	/**
	 * Inject the object manager so we can create objects on our own.
	 *
	 * @param Tx_Extbase_Object_ObjectManagerInterface $objectManager
	 */
	public function injectObjectManager(Tx_Extbase_Object_ObjectManagerInterface $objectManager) {
		$this->objectManager = $objectManager;
	}

	/**
	 * Inject the settings service
	 *
	 * @param Tx_Community_Service_SettingsService $settingsService
	 */
	public function injectSettingsService(Tx_Community_Service_SettingsService $settingsService) {
		$this->settingsService = $settingsService;
	}
}
?>
