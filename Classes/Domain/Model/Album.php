<?php

namespace Macopedia\Community\Domain\Model;

use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011 Konrad Baumgart
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
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
 * Album that may contain images
 */
class Album extends AbstractEntity
{

    /**
     * public album
     *
     * @var integer
     */
    const PRIVACY_AVAILABLE_FOR_ALL = 0;

    /**
     * album for logged in users
     *
     * @var integer
     */
    const PRIVACY_AVAILABLE_FOR_LOGGED_IN = 1;

    /**
     * album for friends
     *
     * @var integer
     */
    const PRIVACY_AVAILABLE_FOR_FRIENDS = 2;

    /**
     * album is a normal album
     *
     * @var integer
     */
    const ALBUM_TYPE_NORMAL = 0;

    /**
     * album contains current and old avatars
     *
     * @var integer
     */
    const ALBUM_TYPE_AVATAR = 1;

    /**
     * Owner of the album
     *
     * @var \Macopedia\Community\Domain\Model\User
     */
    protected $user;

    /**
     * Name of the album
     *
     * @var string
     * @Extbase\Validate("NotEmpty")
     */
    protected $name;

    /**
     * Only friends, only logged in or everyone
     *
     * @var string
     * @Extbase\Validate("NotEmpty")
     */
    protected $private;

    /**
     * Normal album, album with user images(avatars),
     * wallposts images, etc.
     *
     * @var integer
     */
    protected $albumType;

    /**
     * photos
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Macopedia\Community\Domain\Model\Photo>
     * @Extbase\ORM\Lazy
     * @Extbase\ORM\Cascade("remove")
     */
    protected $photos;

    /**
     * mainPhoto - the proto that represents the album on list
     *
     * @var \Macopedia\Community\Domain\Model\Photo
     * @Extbase\ORM\Lazy
     */
    protected $mainPhoto;

    public function __construct()
    {
        $this->initStorageObjects();
    }

    /**
     * Initializes all \TYPO3\CMS\Extbase\Persistence\ObjectStorage instances.
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->photos = new ObjectStorage();
    }

    /**
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param int $private
     * @return void
     */
    public function setPrivate($private)
    {
        $this->private = $private;
    }

    /**
     * @return int
     */
    public function getPrivate()
    {
        return $this->private;
    }

    /**
     * @param int $type
     * @return void
     */
    public function setAlbumType($type)
    {
        $this->albumType = $type;
    }

    /**
     * @return int
     */
    public function getAlbumType()
    {
        return $this->albumType;
    }

    /**
     * Set main photo of album
     * @param \Macopedia\Community\Domain\Model\Photo $photo
     * @return void
     */
    public function setMainPhoto(Photo $photo = NULL)
    {
        $this->mainPhoto = $photo;
    }

    /**
     * Get main photo of album
     * @return \Macopedia\Community\Domain\Model\Photo
     */
    public function getMainPhoto()
    {
        return $this->mainPhoto;
    }

    /**
     * Set owner of album
     * @param \Macopedia\Community\Domain\Model\User $user
     * @return void
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get owner of album
     * @return \Macopedia\Community\Domain\Model\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Macopedia\Community\Domain\Model\Photo> $photos
     * @return void
     */
    public function setPhotos(ObjectStorage $photos)
    {
        $this->photos = $photos;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Macopedia\Community\Domain\Model\Photo>
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * @param \Macopedia\Community\Domain\Model\Photo the Photo to be added
     * @return void
     */
    public function addPhoto(Photo $photo)
    {
        $this->photos->attach($photo);
    }

    /**
     * @param \Macopedia\Community\Domain\Model\Photo the Photo to be removed
     * @return void
     */
    public function removePhoto(Photo $photoToRemove)
    {
        $this->photos->detach($photoToRemove);
    }

}