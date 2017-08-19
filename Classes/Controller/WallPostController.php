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

/**
 * Controller for the WallPost object
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class WallPostController extends BaseController
{

    /**
     * Displays all WallPosts
     *
     */
    public function listAction()
    {
        $wallPosts = $this->repositoryService->get('wallPost')->findRecentByRecipient($this->getRequestedUser());
        $this->view->assign('wallPosts', $wallPosts);
    }

    /**
     * Creates a new WallPost and forwards to the list action.
     *
     * @param Model\WallPost $newWallPost a fresh WallPost object which has not yet been added to the repository
     * @dontvalidate $newWallPost
     */
    public function newAction(Model\WallPost $newWallPost = null)
    {
        $this->view->assign('newWallPost', $newWallPost);
        $this->view->assign('recipient', $this->getRequestedUser());
    }

    /**
     * Creates a new WallPost and forwards to the list action.
     *
     * @param Model\WallPost $newWallPost a fresh WallPost object which has not yet been added to the repository
     *
     */
    public function createAction(Model\WallPost $newWallPost)
    {
        $newWallPost->setRecipient($this->getRequestedUser());
        $newWallPost->setSender($this->getRequestingUser());
        $newWallPost->setSubject($this->getRequestingUser()->getName());

        $this->repositoryService->get('wallPost')->add($newWallPost);
        $this->addFlashMessage($this->_('wallPost.form.created'));

        // we have to persist now to get the uid of the new created wall post in email notification
        $persistenceManager = $this->objectManager->get('TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager');
        /* @var $persistenceManager \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager */
        $persistenceManager->persistAll();

        $notification = new \Macopedia\Community\Service\Notification\Notification(
            'wallPostCreate',
            $this->requestingUser,
            $this->requestedUser
        );
        $notification->setMessage($newWallPost);
        $this->notificationService->notify($notification);

        $this->redirectToWall($this->getRequestedUser());
    }

    /**
     * Deletes an existing WallPost
     *
     * @param Model\WallPost $wallPost the WallPost to be deleted
     */
    public function deleteAction(Model\WallPost $wallPost)
    {
        $this->repositoryService->get('wallPost')->remove($wallPost);
        $this->addFlashMessage($this->_('wallPost.list.deleted'));
        $this->redirectToWall($this->getRequestedUser());
    }
}
