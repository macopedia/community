<?php

namespace Macopedia\Community\Domain\Model;

use Macopedia\Community\Domain\Model\Observer\AbstractObservableEntity;
use TYPO3\CMS\Extbase\Annotation as Extbase;

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

class WallPost extends AbstractObservableEntity
{
    /**
     * Sender
     *
     * @var \Macopedia\Community\Domain\Model\User $sender
     */
    protected $sender;

    /**
     * recipient
     *
     * @var \Macopedia\Community\Domain\Model\User $recipient
     */
    protected $recipient;

    /**
     * Subject
     *
     * @var string $subject
     */
    protected $subject;

    /**
     * message
     *
     * @var string $message
     * @Extbase\Validate("NotEmpty")
     */
    protected $message;

    /**
     * Setter for sender
     *
     * @param \Macopedia\Community\Domain\Model\User $sender
     */
    public function setSender($sender)
    {
        $this->sender = $sender;
    }

    /**
     * Getter for sender
     *
     * @return \Macopedia\Community\Domain\Model\User sender
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Setter for recipient
     *
     * @param \Macopedia\Community\Domain\Model\User $recipient
     */
    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;
    }

    /**
     * Getter for recipient
     *
     * @return \Macopedia\Community\Domain\Model\User recipient
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * Setter for subject
     *
     * @param string $subject Subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * Getter for subject
     *
     * @return string Subject
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Setter for message
     *
     * @param string $message message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * Getter for message
     *
     * @return string message
     */
    public function getMessage()
    {
        return $this->message;
    }
}
