<?php

namespace Macopedia\Community\Domain\Model;
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

class Message extends Observer\AbstractObservableEntity
{

    /**
     * The sender
     *
     * @var \Macopedia\Community\Domain\Model\User
     */
    protected $sender;

    /**
     * The recipient
     *
     * @var \Macopedia\Community\Domain\Model\User
     */
    protected $recipient;

    /**
     * @var bool
     */
    protected $sent;

    /**
     * @var bool
     */
    protected $read;

    /**
     * @var \DateTime
     */
    protected $sentDate;

    /**
     * @var \DateTime
     */
    protected $readDate;

    /**
     * @var string
     */
    protected $subject;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var bool
     */
    protected $senderDeleted;

    /**
     * @var bool
     */
    protected $recipientDeleted;

    /**
     * Get value of $this->sender
     *
     * @access public
     * @return \Macopedia\Community\Domain\Model\User
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Set the value of $this->sender
     *
     * @param \Macopedia\Community\Domain\Model\User $value
     * @access public
     */
    public function setSender($value)
    {
        $this->sender = $value;
    }

    /**
     * Get value of $this->recipient
     *
     * @access public
     * @return \Macopedia\Community\Domain\Model\User
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * Set the value of $this->recipient
     *
     * @param \Macopedia\Community\Domain\Model\User $value
     * @access public
     */
    public function setRecipient($value)
    {
        $this->recipient = $value;
    }

    /**
     * Get value of $this->sent
     *
     * @access public
     * @return bool
     */
    public function getSent()
    {
        return $this->sent;
    }

    /**
     * Set the value of $this->sent
     *
     * @param bool $value
     * @access public
     */
    public function setSent($value)
    {
        $this->sent = $value;
    }

    /**
     * Get value of $this->read
     *
     * @access public
     * @return bool
     */
    public function getRead()
    {
        return $this->read;
    }

    /**
     * Set the value of $this->read
     *
     * @param bool $value
     * @access public
     */
    public function setRead($value)
    {
        $this->read = $value;
    }

    /**
     * Get value of $this->sentDate
     *
     * @access public
     * @return \DateTime
     */
    public function getSentDate()
    {
        return $this->sentDate;
    }

    /**
     * Set the value of $this->sentDate
     *
     * @param \DateTime $value
     * @access public
     */
    public function setSentDate($value)
    {
        $this->sentDate = $value;
    }

    /**
     * Get value of $this->readDate
     *
     * @access public
     * @return \DateTime
     */
    public function getReadDate()
    {
        return $this->readDate;
    }

    /**
     * Set the value of $this->readDate
     *
     * @param \DateTime $value
     * @access public
     */
    public function setReadDate($value)
    {
        $this->readDate = $value;
    }

    /**
     * Get value of $this->subject
     *
     * @access public
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set the value of $this->subject
     *
     * @param mixed $value
     * @access public
     */
    public function setSubject($value)
    {
        $this->subject = $value;
    }

    /**
     * Get value of $this->message
     *
     * @access public
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set the value of $this->message
     *
     * @param string $value
     * @access public
     */
    public function setMessage($value)
    {
        $this->message = $value;
    }

    /**
     * Get value of $this->senderDeleted
     *
     * @access public
     * @return bool
     */
    public function getSenderDeleted()
    {
        return $this->senderDeleted;
    }

    /**
     * Set the value of $this->senderDeleted
     *
     * @param bool $value
     * @access public
     */
    public function setSenderDeleted($value)
    {
        $this->senderDeleted = $value;
    }

    /**
     * Get value of $this->recipientDeleted
     *
     * @access public
     * @return bool
     */
    public function getRecipientDeleted()
    {
        return $this->recipientDeleted;
    }

    /**
     * Set the value of $this->recipientDeleted
     *
     * @param bool $value
     * @access public
     */
    public function setRecipientDeleted($value)
    {
        $this->recipientDeleted = $value;
    }
}

?>