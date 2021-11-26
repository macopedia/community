<?php

namespace Macopedia\Community\Service\Notification;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011 Tymoteusz Motylewski
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

use Macopedia\Community\Domain\Model\User;
use Macopedia\Community\Exception\UnexpectedException;
use TYPO3\CMS\Core\Log\LogLevel;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\Mail\MailMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Email notifications
 */
class MailHandler extends AbstractHandler
{
    /**
     * Sends e-mail to recipients
     * Mail is sent from address $configuration[sender]
     * $notification->getSender() is added to ReplyTo, because we can't send mail as a user
     *
     * Info about mails
     * @see http://buzz.typo3.org/article/your-first-blog/
     *
     * @param  Notification $notification
     * @param  array $configuration
     * @throws \Macopedia\Community\Exception\UnexpectedException
     */
    public function send(Notification $notification, array $configuration)
    {

        /* @var $mail \TYPO3\CMS\Core\Mail\MailMessage */
        $mail = GeneralUtility::makeInstance(MailMessage::class);

        $notifySenderFlag = $configuration['notifySender'];
        if ($notifySenderFlag == 1) { //sending message to sender user instead of recipient e.g "copy of message to my email"
            $recipient = $notification->getSender();
        } else {
            /* @var $recipient User */
            $recipient = $notification->getRecipient();
        }
        if (isset($recipient) && empty($configuration['overrideRecipient'])) {
            $mail->addTo($recipient->getEmail(), $recipient->getUsername());
        }
        if (!empty($configuration['recipient'])) {
            $mail->addTo($configuration['recipient']);
        } else {
            throw new UnexpectedException('No recipient set while sending mail via MailHandler', 1316515690);
        }

        if ($configuration['serverEmail']) {
            $mail->setFrom($configuration['serverEmail']);
        } else {
            throw new UnexpectedException('No sender while sending mail via MailHandler', 1316515689);
        }

        //We can't send from user's email, as other servers won't accept mails from foreign domains from us
        if ($configuration['replyToSenderUser'] && $notification->getSender()) {
            $mail->addReplyTo($notification->getSender()->getEmail(), $notification->getSender()->getUsername());
        }

        if ($notification->getReplyTo()) {
            $mail->addReplyTo($notification->getReplyTo()->getEmail(), $notification->getReplyTo()->getUsername());
        }
        try {
            $content = $this->render($notification, $configuration);
            $mail->setSubject($content['subject']);
            $mail->setBody($content['bodyPlain'], 'text/plain');
            $mail->addPart($content['bodyHTML'], 'text/html');
            $mail->send();
        } catch (\Exception $e) {
            GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__)->log(LogLevel::ERROR, "Couldn't send email: " . $e->getMessage());
        }
    }
}
