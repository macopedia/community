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

use Macopedia\Community\Domain\Model\Album;
use TYPO3\CMS\Extbase\Annotation as Extbase;

/**
 * Controller for the Album object
 */
class AlbumController extends BaseController
{
    /**
     * Displays all Albums of requested user
     */
    public function listAction()
    {
        $albums = $this->repositoryService->get('album')->findByUser($this->requestedUser);
        $this->view->assign('albums', $albums);
    }

    /**
     * Displays a single Album with it's photos
     *
     * @param Album $album the Album to display
     */
    public function showAction(Album $album)
    {
        $this->view->assign('album', $album);
    }

    /**
     * Redirects to show freshest album of requestedUser
     */
    public function showMostRecentAction()
    {
        $album = $this->repositoryService->get('album')->findOneByUser($this->requestedUser);
        $this->redirect('show', null, null, ['album' => $album]);
    }

    /**
     * Displays a form for creating a new Album
     *
     * @param Album $newAlbum a fresh Album object which has not yet been added to the repository
     * @Extbase\IgnoreValidation("newAlbum")
     */
    public function newAction(Album $newAlbum = null)
    {
        $this->view->assign('newAlbum', $newAlbum);
    }

    /**
     * Creates a new Album and forwards to the list action.
     *
     * @param Album $newAlbum a fresh Album object which has not yet been added to the repository
     */
    public function createAction(Album $newAlbum)
    {
        $newAlbum->setUser($this->requestingUser);
        $this->repositoryService->get('album')->add($newAlbum);
        $this->addFlashMessage($this->_('profile.album.createdAlbum'));
        $this->redirect('showAction');
    }

    /**
     * Displays a form for editing an existing Album
     *
     * @param Album $album the Album to display
     * @return string A form to edit a Album
     */
    public function editAction(Album $album)
    {
        $this->view->assign('album', $album);
    }

    /**
     * Updates an existing Album and forwards to the list action afterwards.
     *
     * @param Album $album the Album to display
     */
    public function updateAction(Album $album)
    {
        $this->repositoryService->get('album')->update($album);
        $this->addFlashMessage($this->_('profile.album.updatedAlbum'));
        $this->redirect('list');
    }

    /**
     * Deletes an existing Album
     *
     * @param Album $album the Album to be deleted
     */
    public function deleteAction(Album $album)
    {
        $this->repositoryService->get('album')->remove($album);
        $this->addFlashMessage($this->_('profile.album.removedAlbum'));
        $this->redirect('list');
    }
}
