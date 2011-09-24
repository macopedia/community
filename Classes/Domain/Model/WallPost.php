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

class Tx_Community_Domain_Model_WallPost extends Tx_Community_Domain_Model_Observer_AbstractObservableEntity {

	/**
	 * Sender
	 *
	 * @var Tx_Community_Domain_Model_User $sender
	 *
	 */
	protected $sender;

	/**
	 * recipient
	 *
	 * @var Tx_Community_Domain_Model_User $recipient
	 *
	 */
	protected $recipient;

	/**
	 * Subject
	 *
	 * @var string $subject
	 */
	protected $subject;

	/**
	 * message
	 *
	 * @var string $message
	 * @validate NotEmpty
	 */
	protected $message;

	/**
	 * Setter for sender
	 *
	 * @param Tx_Community_Domain_Model_User $sender
	 * @return void
	 */
	public function setSender($sender) {
		$this->sender = $sender;
	}

	/**
	 * Getter for sender
	 *
	 * @return Tx_Community_Domain_Model_User sender
	 */
	public function getSender() {
		return $this->sender;
	}

	/**
	 * Setter for recipient
	 *
	 * @param Tx_Community_Domain_Model_User $recipient
	 * @return void
	 */
	public function setRecipient($recipient) {
		$this->recipient = $recipient;
	}

	/**
	 * Getter for recipient
	 *
	 * @return Tx_Community_Domain_Model_User recipient
	 */
	public function getRecipient() {
		return $this->recipient;
	}

	/**
	 * Setter for subject
	 *
	 * @param string $subject Subject
	 * @return void
	 */
	public function setSubject($subject) {
		$this->subject = $subject;
	}

	/**
	 * Getter for subject
	 *
	 * @return string Subject
	 */
	public function getSubject() {
		return $this->subject;
	}

	/**
	 * Setter for message
	 *
	 * @param string $message message
	 * @return void
	 */
	public function setMessage($message) {
		$this->message = $message;
	}

	/**
	 * Getter for message
	 *
	 * @return string message
	 */
	public function getMessage() {
		return $this->message;
	}

	/**
	 * The constructor of this WallPost
	 *
	 * @return void
	 */
	public function __construct() {

	}


}

?>