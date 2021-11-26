<?php

namespace Macopedia\Community\Service\Notification;

use TYPO3\CMS\Core\Utility\GeneralUtility;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Tymoteusz Motylewski
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
 * Notify user with private message
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class PrivateMessageHandler extends AbstractHandler
{

    /**
     * @param  array $notification
     * @param  array $configuration
     * @return void
     */
    public function send(array $notification, array $configuration)
    {

        $message = GeneralUtility::makeInstance('Macopedia\Community\Domain\Model\Message');
        /* @var $message Message */
        $message->setSent(true);
        $message->setSentDate(time());
        $message->setSender($notification['sender']);
        $message->setRecipient($notification['recipient']);
        if ($configuration['subject'])
            $message->setSubject($configuration['subject']);
        if ($notification['subject'])
            $message->setSubject($notification['subject']);
        $message->setMessage($this->render($notification, $configuration));
        $this->repositoryService->get('message')->add($message);
    }

}

