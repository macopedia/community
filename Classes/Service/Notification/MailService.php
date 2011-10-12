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
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Tymoteusz Motylewski <t.motylewski@gmail.com>
 * @author Konrad
 */
class Tx_Community_Service_Notification_MailService extends Tx_Community_Service_Notification_BaseHandler {

	/**
	 * Sends e-mail to recipients
	 * Mail is sent from address $configuration[sender]
	 * $arguments['sender'] is added to ReplyTo, because we can't send mail as a user
	 *
	 * Info about mails
	 * @see http://buzz.typo3.org/article/your-first-blog/
	 *
	 * @param  array $arguments
	 * @param  array $configuration
	 * @return void
	 */
	public function send(array $arguments, array $configuration) {
		/* @var $recipient Tx_Community_Domain_Model_User */
		$recipient = $arguments['recipient'];

		$mail = t3lib_div::makeInstance('t3lib_mail_Message');
		/* @var $mail t3lib_mail_Message */

		if ($arguments['recipient']) {
			if ($arguments['recipient'] instanceof Tx_Community_Domain_Model_User) {
				$mail->addTo($arguments['recipient']->getEmail(), $arguments['recipient']->getUsername());
			} else {
				$mail->addTo($arguments['recipient']);
			}
		}
		if ($configuration['recipient']) {
			$mail->addTo($configuration['recipient']);
		}
		if (is_array($arguments['recipients'])) {
			foreach($arguments['recipients'] as $recipient) {
				if ($recipient instanceof Tx_Community_Domain_Model_User) {
					$mail->addTo($recipient->getEmail(), $recipient->getUsername());
				} else {
					$mail->addTo($recipient);
				}
			}
		}

		if ($configuration['sender']) {
			$mail->setFrom($configuration['sender']);
		} else {
			throw new Tx_Community_Exception_UnexpectedException('No sender while sending mail via MailService', 1316515689);
		}

		//We can't send from user's email, as other servers won't accept mails from foreign domains from us
		if ($configuration['useSenderFromArgumentsAsReplyTo'] && $arguments['sender']) {
			if ($arguments['sender'] instanceof Tx_Community_Domain_Model_User) {
				$mail->addReplyTo($arguments['sender']->getEmail(), $arguments['sender']->getUsername());
			} else {
				$mail->addReplyTo($arguments['sender']);
			}
		}

		if ($arguments['replyTo']) {
			if ($arguments['replyTo'] instanceof Tx_Community_Domain_Model_User) {
				$mail->addReplyTo($arguments['replyTo']->getEmail(), $arguments['replyTo']->getUsername());
			} else {
				$mail->addReplyTo($arguments['replyTo']);
			}
		}

		if ($configuration['subject'])
			$mail->setSubject($configuration['subject']);
		if ($arguments['subject'])
			$mail->setSubject($arguments['subject']);

		$content = $this->render($arguments, $configuration);
		$mail->setBody($content, 'text/html')
			->send();

		// TODO: Add plain version
		// $mail->addPart($bodyText, 'text/plain');
	}

}
?>