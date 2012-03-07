<?php
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
 * Class containing information needed to notify an user
 *
 * @author Tymoteusz Motylewski <t.motylewski@gmail.com>
 */
class Tx_Community_Service_Notification_Notification {

	/**
	 * Location for overloaded data.
	 * @var array
	 */
	protected $data = array();

	/**
	 * @var Tx_Community_Domain_Model_User
	 */
	protected $sender;

	/**
	 * @var Tx_Community_Domain_Model_User
	 */
	protected $recipient;

	/**
	 * @var string
	 */
	protected $rule = '';



	/**
	 * @param Tx_Community_Domain_Model_User $recipient
	 */
	public function setRecipient($recipient) {
		if ($recipient instanceof Tx_Community_Domain_Model_User) {
			$this->recipient = $recipient;
		}
	}

	/**
	 * @return Tx_Community_Domain_Model_User
	 */
	public function getRecipient() {
		return $this->recipient;
	}

	/**
	 * @param Tx_Community_Domain_Model_User $sender
	 */
	public function setSender($sender) {
		if ($sender instanceof Tx_Community_Domain_Model_User) {
			$this->sender = $sender;
		}
	}

	/**
	 * @return Tx_Community_Domain_Model_User
	 */
	public function getSender() {
		return $this->sender;
	}

	/**
	 * @param string $rule
	 */
	public function setRule($rule) {
		$this->rule = $rule;
	}

	/**
	 * @return string
	 */
	public function getRule() {
		return $this->rule;
	}

	/**
	 * @param string $rule
	 * @param Tx_Community_Domain_Model_User $sender
	 * @param Tx_Community_Domain_Model_User $recipient
	 */
	public function __construct($rule = '', Tx_Community_Domain_Model_User $sender = NULL, Tx_Community_Domain_Model_User $recipient = NULL) {
		$this->setRule($rule);
		$this->setSender($sender);
		$this->setRecipient($recipient);
	}


	public function __call($methodName, array $args) {
		if (preg_match('/^(set|get)([A-Z])(.*)$/', $methodName, $matches)) {
			$property = $matches[2].$matches[3];
			switch($matches[1]) {
				case 'set':
					return $this->data[$property] = $args[0];
				case 'get':
					return $this->data[$property];
			}
		}
	}
}
?>