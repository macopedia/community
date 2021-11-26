<?php

namespace Macopedia\Community\Controller;

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

use Macopedia\Community\Domain\Model\Message;
use Macopedia\Community\Domain\Model\User;
use Macopedia\Community\Service\Notification\Notification;
use TYPO3\CMS\Extbase\Annotation as Extbase;

/**
 * The controller for messages
 *
 * There are 2 ways of displaying message box:
 * - classic view with inbox, outbox and unreaded box
 * - threaded view (like on Facebook)
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Pascal Jungblut <mail@pascalj.com>
 */
class MessageController extends BaseController
{
    /**
     * Show the inbox of a user
     */
    public function inboxAction()
    {
        $messages = $this->repositoryService->get('message')->findIncomingForUser($this->getRequestingUser());
        $this->view->assign('messages', $messages);
    }

    /**
     * Show the outgoing messages of a user
     */
    public function outboxAction()
    {
        $messages = $this->repositoryService->get('message')->findOutgoingForUser($this->getRequestingUser());
        $this->view->assign('messages', $messages);
    }

    /**
     * Show the unread messages for a user
     */
    public function unreadAction()
    {
        $messages = $this->repositoryService->get('message')->findUnreadForUser($this->getRequestingUser());
        $this->view->assign('messages', $messages);
    }

    /**
     * Show people you chatted with
     */
    public function listThreadsAction()
    {
        $users = $this->repositoryService->get('user')->getChatMates($this->getRequestingUser());
        $this->view->assign('users', $users);
    }

    /**
     * Show messages between you and given user
     * Also send a message from form included in thread view
     *
     * @param User $user
     * @param Message $message
     */
    public function threadAction(User $user)
    {
        $messages = $this->repositoryService->get('message')->findBetweenUsers($this->getRequestingUser(), $user);
        foreach ($messages as $message) {
            // Set read date for messages we read first time
            // When we read message that we have sent, it is still unread by recipient
            if ($message->getSender()->getUid() == $user->getUid() && !$message->getReadDate()) {
                $message->setReadDate(new \DateTime('@' . $GLOBALS['EXEC_TIME']));
            }
        }

        $this->view->assign('messages', $messages);
    }

    /**
     * Display a form for writing a message
     *
     * @param User $user recipient
     * @param Message $message
     * @Extbase\IgnoreValidation("message")
     */
    public function writeAction(
        User $user = null,
        Message $message = null
    ) {
        if ($this->getRequestedUser()->getUid() == $this->getRequestingUser()->getUid()) {
            return '';
        }
        $this->view->assign('recipient', $this->getRequestedUser());
        $this->view->assign('message', $message);
    }

    /**
     * Display a form for writing a message
     *
     * @param User $user recipient
     * @param Message $message
     * @Extbase\IgnoreValidation("message")
     */
    public function writeThreadedAction(
        User $user = null,
        Message $message = null
    ) {
        if ($this->getRequestedUser()->getUid() == $this->getRequestingUser()->getUid()) {
            return '';
        }
        $this->view->assign('recipient', $this->getRequestedUser());
        $this->view->assign('message', $message);
    }

    /**
     * Send a private message
     *
     * @param Message $message
     */
    public function sendAction(Message $message)
    {
        $this->sendMessage($message);

        //We reset message argument, so that we don't see old message in write message form
        $this->request->setArgument('message', null);

        if ($this->request->getPluginName() == 'MessageBox') {
            $this->redirect('read', null, null, ['user' => $message->getRecipient()]);
        } elseif ($this->request->getPluginName() == 'ThreadedMessageWriteBox') {
            $this->redirect('thread', null, null, ['user' => $message->getRecipient()], $this->settings['threadedMessagePage']);
        } else {
            $this->forward('write');
        }
    }

    /**
     * Sending a message - needed by few actions
     * @param Message $message
     */
    private function sendMessage(Message $message)
    {
        $message->setSent(true);
        $message->setSentDate(new \DateTime('@' . $GLOBALS['EXEC_TIME']));
        $message->setSender($this->getRequestingUser());
        $message->setRecipient($this->getRequestedUser());
        $this->repositoryService->get('message')->add($message);

        $this->addFlashMessage($this->_('message.send.success'));

        // we have to persist now to get the uid of the new created wall post in email notification
        $persistenceManager = $this->objectManager->get('TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager');
        /* @var $persistenceManager \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager */
        $persistenceManager->persistAll();

        $notification = new Notification(
            'messageSend',
            $this->requestingUser,
            $this->requestedUser
        );
        $notification->setMessage($message);
        $this->notificationService->notify($notification);
    }

    /**
     * Read a certain message
     *
     * @param Message $message
     */
    public function readAction(Message $message)
    {

        //We can read only when we are sender or recipient of this message
        $hasAccess = false;

        if ($message->getRecipient() && $this->getRequestingUser()->getUid() == $message->getRecipient()->getUid()) {
            $hasAccess = true;

            //do not flag message as read when reading your own message
            $message->setRead(true);
            $message->setReadDate(new \DateTime('@' . $GLOBALS['EXEC_TIME']));
            $this->repositoryService->get('message')->update($message);
        }

        if ($message->getSender() && $this->getRequestingUser()->getUid() == $message->getSender()->getUid()) {
            $hasAccess = true;
        }

        if ($hasAccess) {
            $this->view->assign('message', $message);
        } else {
            return '';
        }
    }

    /**
     * Delete the message action used in classic message view
     *
     * @param Message $message
     * @param string $redirectAction
     */
    public function deleteAction(Message $message, $redirectAction = null)
    {
        if (!$this->getRequestingUser()) {
            return;
        }
        $this->deleteMessage($message);

        if (isset($redirectAction)) {
            $this->redirect($redirectAction);
        } else {
            $this->redirect('inbox');
        }
    }

    /**
     * Delete message used in threaded view
     *
     * @param Message $message
     */
    public function deleteThreadedAction(Message $message)
    {
        if (!$this->getRequestingUser()) {
            return;
        }
        $this->deleteMessage($message);

        $this->redirect('thread', null, null, ['user' => $message->getRecipient()], $this->settings['threadedMessagePage']);
    }

    /**
     * Delete message
     *
     * @param Message $message
     */
    protected function deleteMessage($message)
    {
        if ($message->getSender() && $message->getSender()->getUid() == $this->getRequestingUser()->getUid()) {
            $message->setSenderDeleted(true);
        } elseif ($message->getRecipient() && $message->getRecipient()->getUid() == $this->getRequestingUser()->getUid()) {
            $message->setRecipientDeleted(true);
        }
        $this->repositoryService->get('message')->update($message);
        $this->addFlashMessage($this->_('message.delete.success'));
    }
}
