<?php
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
class Tx_Community_Domain_Model_Album extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * totaly public album
	 *
	 * @var integer
	 */
	const PRIVACY_AVAILABLE_FOR_ALL = 0;

	/**
	 * album for logged in
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
	 * @var Tx_Community_Domain_Model_User
	 */
	protected $user;

	/**
	 * Name of the album
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $name;

	/**
	 * Only friends, only logged in or everyone
	 *
	 * @var string
	 * @validate NotEmpty
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
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Community_Domain_Model_Photo>
	 * @lazy
	 * @cascade remove
	 */
	protected $photos;

	/**
	 * mainPhoto - the proto that represents the album on list
	 *
	 * @var Tx_Community_Domain_Model_Photo
	 * @lazy
	 */
	protected $mainPhoto;

	public function __construct() {
		$this->initStorageObjects();
	}

	/**
	 * Initializes all Tx_Extbase_Persistence_ObjectStorage instances.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		$this->photos = new Tx_Extbase_Persistence_ObjectStorage();
	}

	/**
	 * @param string $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param int $private
	 * @return void
	 */
	public function setPrivate($private) {
		$this->private = $private;
	}

	/**
	 * @return int
	 */
	public function getPrivate() {
		return $this->private;
	}

	/**
	 * @param int $type
	 * @return void
	 */
	public function setAlbumType($type) {
		$this->albumType = $type;
	}

	/**
	 * @return int
	 */
	public function getAlbumType() {
		return $this->albumType;
	}

	/**
	 * Set main photo of album
	 * @param Tx_Community_Domain_Model_Photo $photo
	 * @return void
	 */
	public function setMainPhoto(Tx_Community_Domain_Model_Photo $photo = NULL) {
		$this->mainPhoto = $photo;
	}

	/**
	 * Get main photo of album
	 * @return Tx_Community_Domain_Model_Photo
	 */
	public function getMainPhoto() {
		return $this->mainPhoto;
	}

	/**
	 * Set owner of album
	 * @param Tx_Community_Domain_Model_User $user
	 * @return void
	 */
	public function setUser(Tx_Community_Domain_Model_User $user) {
		$this->user = $user;
	}

	/**
	 * Get owner of album
	 * @return Tx_Community_Domain_Model_User
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_Community_Domain_Model_Photo> $photos
	 * @return void
	 */
	public function setPhotos(Tx_Extbase_Persistence_ObjectStorage $photos) {
		$this->photos = $photos;
	}

	/**
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Community_Domain_Model_Photo>
	 */
	public function getPhotos() {
		return $this->photos;
	}

	/**
	 * @param Tx_Community_Domain_Model_Photo the Photo to be added
	 * @return void
	 */
	public function addPhoto(Tx_Community_Domain_Model_Photo $photo) {
		$this->photos->attach($photo);
	}

	/**
	 * @param Tx_Community_Domain_Model_Photo the Photo to be removed
	 * @return void
	 */
	public function removePhoto(Tx_Community_Domain_Model_Photo $photoToRemove) {
		$this->photos->detach($photoToRemove);
	}

}
?>