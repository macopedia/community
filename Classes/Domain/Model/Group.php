<?php

namespace Macopedia\Community\Domain\Model;

use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010 Pascal Jungblut <mail@pascal-jungblut.com>
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
 * A group
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Group extends FrontendUserGroup
{
    /**
     * The group is public: anyone can join
     *
     * @var integer
     */
    public const GROUP_TYPE_PUBLIC = 1;

    /**
     * The group is private: the user needs to be confirmed by the creator/admins to join
     *
     * @var integer
     */
    public const GROUP_TYPE_PRIVATE = 2;

    /**
     * name
     * @var string
     * @Extbase\Validate("NotEmpty")
     */
    protected $name;

    /**
     * The grouptype
     * @var integer
     */
    protected $grouptype;

    /**
     * description
     * @var string
     */
    protected $description;

    /**
     * the image of the group
     * @var string
     */
    protected $image;

    /**
     * creator
     * @var \Macopedia\Community\Domain\Model\User
     */
    protected $creator;

    /**
     * admins
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<User>
     */
    protected $admins;

    /**
     * members
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<User>
     */
    protected $members;

    /**
     * pendingMembers
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<User>
     */
    protected $pendingMembers;


    /**
     * Setter for name
     *
     * @param string $name name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Getter for name
     *
     * @return string name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Setter for grouptype
     *
     * @param integer $grouptype The grouptype
     * @return void
     */
    public function setGrouptype($grouptype)
    {
        $this->grouptype = $grouptype;
    }

    /**
     * Getter for grouptype
     *
     * @return integer The grouptype
     */
    public function getGrouptype()
    {
        return $this->grouptype;
    }

    /**
     * Setter for description
     *
     * @param string $description description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Getter for description
     *
     * @return string description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Setter for image
     *
     * @param string $image the image of the group
     * @return void
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * Getter for image
     *
     * @return string the image of the group
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Setter for creator
     *
     * @param \Macopedia\Community\Domain\Model\User $creator creator
     * @return void
     */
    public function setCreator(User $creator)
    {
        $this->creator = $creator;
    }

    /**
     * Getter for creator
     *
     * @return \Macopedia\Community\Domain\Model\User creator
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * Setter for admins
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Macopedia\Community\Domain\Model\User> $admins admins
     * @return void
     */
    public function setAdmins(ObjectStorage $admins)
    {
        $this->admins = $admins;
    }

    /**
     * Getter for admins
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Macopedia\Community\Domain\Model\User> admins
     */
    public function getAdmins()
    {
        return $this->admins;
    }

    /**
     * Adds a User
     *
     * @param \Macopedia\Community\Domain\Model\User The User to be added
     * @return void
     */
    public function addAdmin(User $admin)
    {
        $this->admins->attach($admin);
    }

    /**
     * Removes a User
     *
     * @param \Macopedia\Community\Domain\Model\User The User to be removed
     * @return void
     */
    public function removeAdmin(User $admin)
    {
        $this->admins->detach($admin);
    }

    /**
     * Setter for members
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Macopedia\Community\Domain\Model\User> $members members
     * @return void
     */
    public function setMembers(ObjectStorage $members)
    {
        $this->members = $members;
    }

    /**
     * Getter for members
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Macopedia\Community\Domain\Model\User> members
     */
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * Adds a User
     *
     * @param \Macopedia\Community\Domain\Model\User The User to be added
     * @return void
     */
    public function addMember(User $member)
    {
        $this->members->attach($member);
    }

    /**
     * Removes a User
     *
     * @param \Macopedia\Community\Domain\Model\User The User to be removed
     * @return void
     */
    public function removeMember(User $member)
    {
        $this->members->detach($member);
    }

    /**
     * Setter for pendingMembers
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Macopedia\Community\Domain\Model\User> $pendingMembers pendingMembers
     * @return void
     */
    public function setPendingMembers(ObjectStorage $pendingMembers)
    {
        $this->pendingMembers = $pendingMembers;
    }

    /**
     * Getter for pendingMembers
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Macopedia\Community\Domain\Model\User> pendingMembers
     */
    public function getPendingMembers()
    {
        return $this->pendingMembers;
    }

    /**
     * Adds a User
     *
     * @param \Macopedia\Community\Domain\Model\User The User to be added
     * @return void
     */
    public function addPendingMember(User $pendingMember)
    {
        $this->pendingMembers->attach($pendingMember);
    }

    /**
     * Removes a User
     *
     * @param \Macopedia\Community\Domain\Model\User The User to be removed
     * @return void
     */
    public function removePendingMember(User $pendingMember)
    {
        $this->pendingMembers->detach($pendingMember);
    }
}
