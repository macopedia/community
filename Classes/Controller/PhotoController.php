<?php

namespace Macopedia\Community\Controller;

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

use Macopedia\Community\Domain\Model;
use Macopedia\Community\Domain\Model\Album;
use Macopedia\Community\Domain\Model\Photo;
use Macopedia\Community\Domain\Model\Relation;

/**
 * Controller for the Photo object
 */
class PhotoController extends BaseController
{
    /**
     * Displays a form for creating a new  Photo
     *
     * @param Model\Album $album album we create photo in
     */
    public function newAction(Album $album)
    {
        $this->view->assign('album', $album);
    }

    /**
     * Creates a new Photo and forwards to the list action.
     *
     * @param Model\Album $album album we create photo in
     */
    public function createAction(Album $album)
    {
        // handleUpload() returns numer in case of error
        $fileName = $this->handleUpload(
            'newPhoto.image',
            $this->settings['album']['image']['prefix'],
            $this->settings['album']['image']['types'],
            (int)($this->settings['album']['image']['maxSize'])
        );

        if (!is_int($fileName)) {
            $newPhoto = new Photo();
            $newPhoto->setImage($fileName);
            $album->addPhoto($newPhoto);
            if (!$album->getMainPhoto()) {
                $album->setMainPhoto($newPhoto);
            }
            $this->repositoryService->get('photo')->add($newPhoto);
            $this->repositoryService->get('album')->update($album);
            $this->addFlashMessage($this->_('photo.album.uploadSuccess'));
            $this->redirect('show', 'album', null, ['album' => $album->getUid()]);
        } else {
            $this->addFlashMessage($this->_('profile.album.uploadError'));
            $this->redirect('new');
        }
    }

    /**
     * Deletes an existing Photo
     *
     * @param Model\Photo $photo the Photo to be deleted
     */
    public function deleteAction(Photo $photo)
    {
        $album = $photo->getAlbum();
        $album->removePhoto($photo);
        if (!$album->getPhotos()->contains($album->getMainPhoto())) {
            //we have to change the main photo, as it was deleted
            if ($album->getPhotos()->count()) {
                $album->getPhotos()->rewind();
                $album->setMainPhoto($album->getPhotos()->current());
            } else {
                $album->setMainPhoto();
            }
        }
        $this->repositoryService->get('album')->update($album);
        $this->repositoryService->get('photo')->remove($photo);
        $this->addFlashMessage($this->_('profile.album.photoRemoved'));
        $this->redirect('show', 'Album', null, ['album' => $album]);
    }

    /**
     * Sets an existing photo as user's avatar
     * It's posible to set other user's photo as own avatar
     *
     * @param Model\Photo $photo the Photo to be set as avatar
     */
    public function avatarAction(Photo $photo)
    {
        $album = $photo->getAlbum();
        if ($this->hasAccessToAlbum($album)) {
            $imagePath = $photo->getImage();
            $this->requestingUser->setImage($imagePath);
            $this->repositoryService->get('user')->update($this->requestingUser);
            if ($album->getAlbumType() == Album::ALBUM_TYPE_AVATAR
                && $album->getUser()->getUid() == $this->requestingUser->getUid()
            ) {
                //don't have to copy photo to special album
            } else {
                $newPhoto = new Photo();
                $newPhoto->setImage($imagePath);

                $this->photoToSpecialAlbum($newPhoto, Album::ALBUM_TYPE_AVATAR);
            }
            $this->addFlashMessage($this->_('profile.album.photoSetAsAvatar'));
        } else {
            $this->addFlashMessage($this->_('profile.album.accessDenied'));
        }
        $this->redirect('show', 'Album', null, ['album' => $album]);
    }

    /**
     * Sets an existing photo as main photo of it's album
     *
     * @param Model\Photo $photo the Photo to be set as main
     */
    public function mainPhotoAction(Photo $photo)
    {
        $album = $photo->getAlbum();
        $album->setMainPhoto($photo);
        $this->repositoryService->get('album')->update($album);
        $this->redirect('show', 'Album', null, ['album' => $photo->getAlbum()]);
    }

    /**
     * Checks if requesting user can see given album
     *
     * @param Model\Album $album
     * @return bool
     */
    public function hasAccessToAlbum(Album $album)
    {
        $requestingUser = $this->requestingUser;
        $relation = $this->getRelation();

        if (($requestingUser && ($album->getUser()->getUid() === $requestingUser->getUid())) ||
            $relation->getStatus() === Relation::RELATION_STATUS_CONFIRMED ||
            ($album->getPrivate() <= 1 && $requestingUser) ||
            $album->getPrivate() === 0
        ) {
            return true;
        }
        return false;
    }
}
