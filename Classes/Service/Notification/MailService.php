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
 * 
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Tymoteusz Motylewski <t.motylewski@gmail.com>
 */
class Tx_Community_Service_Notification_MailService extends Tx_Community_Service_Notification_BaseHandler {



	/**
	 *
	 *
	 * @see http://buzz.typo3.org/article/your-first-blog/
	 */
	public function send(Tx_Community_Domain_Model_User $sender, $recipients, $configuration) {



		$mail = t3lib_div::makeInstance('t3lib_mail_Message');
		$mail->setFrom(array($email => $name))
		  ->setTo(array($email => $name))
		  ->setSubject($subject)
		  ->setBody($body)
		  ->send();


		// $mail->setBody($bodyHtml, 'text/html');
		// $mail->addPart($bodyText, 'text/plain');
	}



		
	
}
?>