<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NotificationService
 *
 * @author TM
 */
class Tx_Community_Service_Notification_NotificationService implements Tx_Community_Service_Notification_NotificationServiceInterface, t3lib_Singleton {

	/**
	 * @var Tx_Extbase_Configuration_ConfigurationManagerInterface 
	 */
	protected $configurationManager;

	/**
	 * @var array
	 */
	protected $settings;
	
	/*
	 * @var array
	 */
	protected $handlers;



	/**
     * @var Tx_Extbase_Object_ObjectManagerInterface
     */
    protected $objectManager;

	/**
	 * @param Tx_Extbase_Configuration_ConfigurationManagerInterface $configurationManager
	 * @param Tx_Extbase_Object_ObjectManagerInterface $objectManager
	 * @return void
	 */
	public function __construct(Tx_Extbase_Configuration_ConfigurationManagerInterface $configurationManager, Tx_Extbase_Object_ObjectManagerInterface $objectManager) {
		$this->objectManager = $objectManager;
		$this->configurationManager = $configurationManager;
		$this->settings = $this->configurationManager->getConfiguration(Tx_Extbase_Configuration_ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS);
		$handlerNames = $this->getHandlerNames();
		$this->initializeHandlers($handlerNames);
		//settings ok, configuration manager ok,object manager

	}

	/**
	 * @param Tx_Community_Service_Notification_HandlerInterface $handler
	 * @return void
	 */
	public function addHandler(Tx_Community_Service_Notification_HandlerInterface $handler){
		$this->handlers[$handler->getIdentifier()] = $handler;
	}

	/**
	 * @param Tx_Community_Service_Notification_HandlerInterface $handler
	 * @return void
	 */
	public function removeHandler(Tx_Community_Service_Notification_HandlerInterface $handler){
		unset($this->handlers[$handler->getIdentifier()]);
	}
	

	/**
	 * @return array
	 */
	protected function getHandlerNames(){
		$handlerNames = array();
		foreach ($this->settings['notification']['handlers'] as $handler) {
			$handlerNames[] =  $handler['class'];
		}
		return $handlerNames;
	}

	/**
	 * Fills array of message handlers with proper objects
	 * @param  array $settings
	 * @return void
	 */
	protected function initializeHandlers($handlerNames){
		foreach($handlerNames as $className) {
			$handler = $this->objectManager->get($className);
			$this->addHandler($handler);
		}
	}

	/**
	 * Iterate through settings and send message using appropriate handler (mail/wall/PM/....)
	 * @param string $resourceName
	 */
	public function notify($sender, $recipients, $resourceName) {
		$methods = $this->getNotificationTypes($resourceName);
		foreach ($methods as $method){
			$handler = $this->handlers[$method['handler']];
			if($handler !== NULL) {
				$handler->send($sender, $recipients, $method);
			} else {
				///TODO: throw exception
			}
		}

	}

	/*
	 * @param string resourceName
	 * @return array
	 */
	protected function getNotificationTypes($resourceName){
		return $this->settings['notification']['rules'][$resourceName];
	}

}
?>
