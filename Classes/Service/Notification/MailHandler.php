<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 Tymoteusz Motylewski <t.motylewski@gmail.com>
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
 * Email notifications
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Tymoteusz Motylewski <t.motylewski@gmail.com>
 * @author Konrad
 */
class Tx_Community_Service_Notification_MailHandler extends Tx_Community_Service_Notification_AbstractHandler {

	/**
	 * Sends e-mail to recipients
	 * Mail is sent from address $configuration[sender]
	 * $notification->getSender() is added to ReplyTo, because we can't send mail as a user
	 *
	 * Info about mails
	 * @see http://buzz.typo3.org/article/your-first-blog/
	 *
	 * @param  Tx_Community_Service_Notification_Notification $notification
	 * @param  array $configuration
	 * @return void
	 */
	public function send(Tx_Community_Service_Notification_Notification $notification, array $configuration) {

		/* @var $mail t3lib_mail_Message */
		$mail = t3lib_div::makeInstance('t3lib_mail_Message');

		$notifySenderFlag = $configuration['notifySender'];
		if ($notifySenderFlag == 1) { //sending message to sender user instead of recipient e.g "copy of message to my email"
			$recipient = $notification->getSender();
		} else {
			/* @var $recipient Tx_Community_Domain_Model_User */
			$recipient = $notification->getRecipient();
		}
		if (isset($recipient) && empty($configuration['overrideRecipient'])) {
			$mail->addTo($recipient->getEmail(), $recipient->getUsername());
		}
		if (isset($configuration['recipient'])) {
			$mail->addTo($configuration['recipient']);
		}

		if ($configuration['serverEmail']) {
			$mail->setFrom($configuration['serverEmail']);
		} else {
			throw new Tx_Community_Exception_UnexpectedException('No sender while sending mail via MailHandler', 1316515689);
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
			$mail->setBody($content['body'], 'text/html')
				->send();
		} catch(Exception $e) {
			t3lib_div::sysLog("Couldn't send email: ".$e->getMessage(), 'community', t3lib_div::SYSLOG_SEVERITY_ERROR);
		}

		// TODO: Add plain version
		// $mail->addPart($bodyText, 'text/plain');
	}
}
?>