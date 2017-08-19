<?php

namespace Macopedia\Community\Domain\Model;
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
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Pascal Jungblut <mail@pascalj.com>
 */
class Relation extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

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
     * @var \Macopedia\Community\Domain\Model\User
     */
    protected $initiatingUser;

    /**
     * @var \Macopedia\Community\Domain\Model\User
     */
    protected $requestedUser;

    /**
     * @var AclRole
     */
    //protected $initiatingRole;

    /**
     * @var AclRole
     */
//	protected $requestedRole;

    /**
     * @var integer
     */
    protected $status = 1;

    /**
     * @var \DateTime
     */
    protected $initiationTime;

    /**
     *
     * @return \Macopedia\Community\Domain\Model\User
     */
    public function getInitiatingUser()
    {
        return $this->initiatingUser;
    }

    /**
     * @param \Macopedia\Community\Domain\Model\User $initiatingUser
     */
    public function setInitiatingUser(\Macopedia\Community\Domain\Model\User $initiatingUser)
    {
        $this->initiatingUser = $initiatingUser;
    }


    /**
     * @return \DateTime
     */
    public function getInitiationTime()
    {
        return $this->initiationTime;
    }

    /**
     * @param \DateTime $initiationTime
     */
    public function setInitiationTime($initiationTime)
    {
        $this->initiationTime = $initiationTime;
    }


    /**
     * @return \Macopedia\Community\Domain\Model\User
     */
    public function getRequestedUser()
    {
        return $this->requestedUser;
    }

    /**
     * @param \Macopedia\Community\Domain\Model\User $requestedUser
     */
    public function setRequestedUser(\Macopedia\Community\Domain\Model\User $requestedUser)
    {
        $this->requestedUser = $requestedUser;
    }

    /**
     *
     * @return AclRole
     */
    // private function getInitiatingRole() {
    // 	return $this->initiatingRole;
    // }

    /**
     * @param AclRole $initiatingRole
     */
    // private function setInitiatingRole($initiatingRole) {
    // 	$this->initiatingRole = $initiatingRole;
    // }

    /**
     * @return AclRole
     */
    // private function getRequestedRole() {
    // 	return $this->requestedRole;
    // }

    /**
     * @param AclRole $requestedRole
     */
    // private function setRequestedRole($requestedRole) {
    // 	$this->requestedRole = $requestedRole;
    // }


    /**
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param integer $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }


    /*public function _isDirty($propertyName = NULL) {
        \TYPO3\CMS\Core\Utility\GeneralUtility::debug($this->_cleanProperties);
        if (empty($this->_cleanProperties)) return TRUE;

        // if (!is_array($this->_cleanProperties)) throw new \TYPO3\CMS\Extbase\Persistence\Generic\Exception\CleanStateNotMemorizedException('The clean state of the object "' . get_class($this) . '" has not been memorized before asking _isDirty().', 1233309106);
        if ($this->uid !== NULL && $this->uid != $this->_cleanProperties['uid']) throw new \TYPO3\CMS\Extbase\Persistence\Generic\Exception\TooDirtyException('The uid "' . $this->uid . '" has been modified, that is simply too much.', 1222871239);
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
