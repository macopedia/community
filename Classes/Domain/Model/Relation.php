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
 * A relation between two users.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Pascal Jungblut <mail@pascalj.com>
 */
class Tx_Community_Domain_Model_Relation extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * the relation has just been initiated
	 *
	 * @var integer
	 */
	const RELATION_STATUS_NEW = 1;

	/**
	 * the relation was confirmed by the requested user
	 *
	 * @var integer
	 */
	const RELATION_STATUS_CONFIRMED = 2;

	/**
	 * the requested user rejected the relation request
	 *
	 * @var integer
	 */
	const RELATION_STATUS_REJECTED = 4;

	/**
	 * one of the users cancelled the existing relation
	 *
	 * @var integer
	 */
	const RELATION_STATUS_CANCELLED = 8;

	/**
	 * @var Tx_Community_Domain_Model_User
	 */
	protected $initiatingUser;

	/**
	 * @var Tx_Community_Domain_Model_User
	 */
	protected $requestedUser;

	/**
	 * @var Tx_Community_Domain_Model_AclRole
	 */
	//protected $initiatingRole;

	/**
	 * @var Tx_Community_Domain_Model_AclRole
	 */
//	protected $requestedRole;

	/**
	 * @var integer
	 */
	protected $status;

	/**
	 * @var DateTime
	 */
	protected $initiationTime;

	/**
	 *
	 * @return Tx_Community_Domain_Model_User
	 */
	public function getInitiatingUser()
	{
	    return $this->initiatingUser;
	}

	/**
	 *
	 * @param Tx_Community_Domain_Model_User $initiatingUser
	 */
	public function setInitiatingUser(Tx_Community_Domain_Model_User $initiatingUser)
	{
	    $this->initiatingUser = $initiatingUser;
	}

	/**
	 *
	 * @return Tx_Community_Domain_Model_User
	 */
	public function getRequestedUser()
	{
	    return $this->requestedUser;
	}

	/**
	 *
	 * @param Tx_Community_Domain_Model_User $requestedUser
	 */
	public function setRequestedUser($requestedUser)
	{
	    $this->requestedUser = $requestedUser;
	}

	/**
	 *
	 * @return Tx_Community_Domain_Model_AclRole
	 */
//	private function getInitiatingRole()
//	{
//	    return $this->initiatingRole;
//	}

	/**
	 *
	 * @param Tx_Community_Domain_Model_AclRole $initiatingRole
	 */
//	private function setInitiatingRole($initiatingRole)
//	{
//	    $this->initiatingRole = $initiatingRole;
//	}

	/**
	 *
	 * @return Tx_Community_Domain_Model_AclRole
	 */
//	private function getRequestedRole()
//	{
//	    return $this->requestedRole;
//	}

	/**
	 *
	 * @param Tx_Community_Domain_Model_AclRole $requestedRole
	 */
//        private  function setRequestedRole($requestedRole)
//	{
//	    $this->requestedRole = $requestedRole;
//	}

	/**
	 * @param integer $status
	 */
	public function setStatus($status) {
		$this->status = $status;
	}

	/**
	 * @return integer
	 */
	public function getStatus() {
		return $this->status;
	}

	/*public function _isDirty($propertyName = NULL) {
		t3lib_div::debug($this->_cleanProperties);
		if (empty($this->_cleanProperties)) return TRUE;

		// if (!is_array($this->_cleanProperties)) throw new Tx_Extbase_Persistence_Exception_CleanStateNotMemorized('The clean state of the object "' . get_class($this) . '" has not been memorized before asking _isDirty().', 1233309106);
		if ($this->uid !== NULL && $this->uid != $this->_cleanProperties['uid']) throw new Tx_Extbase_Persistence_Exception_TooDirty('The uid "' . $this->uid . '" has been modified, that is simply too much.', 1222871239);
		$result = FALSE;
		if ($propertyName !== NULL) {
			if (is_object($this->$propertyName)) {
				// In case it is an object, we do a simple comparison (!=) as we want cloned objects to return the same values.
				$result = $this->_cleanProperties[$propertyName] != $this->$propertyName;
				echo $result ? 1 : 0;
			} else {
				$result = $this->_cleanProperties[$propertyName] !== $this->$propertyName;
			}
		} else {
			foreach ($this->_cleanProperties as $propertyName => $propertyValue) {
				if (is_object($this->$propertyName)) {
					// In case it is an object, we do a simple comparison (!=) as we want cloned objects to return the same values.
					if ($this->$propertyName != $propertyValue) {
						$result = TRUE;
						break;
					}
				} else {
					if ($this->$propertyName !== $propertyValue) {
						$result = TRUE;
						break;
					}
				}
			}
		}
		return $result;
	}

	public function _memorizePropertyCleanState($propertyName) {
		parent::_memorizePropertyCleanState($propertyName);
	}*/
}

?>