<?php
namespace Macopedia\Community\Domain\Repository;
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

use Macopedia\Community\Domain\Model\User;

class MessageRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * Find outgoing messages for the current user
     *
     * @param User $user
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findOutgoingForUser(User $user)
    {
        $query = $this->createQuery();
        return $query->matching(
            $query->logicalAnd(
                $query->equals('sender', $user),
                $query->equals('senderDeleted', false)
            )
        )->setOrderings(array('sentDate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING)
        )->execute();
    }

    /**
     * Find incoming messages
     *
     * @param User $user
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findIncomingForUser(User $user)
    {
        $query = $this->createQuery();
        return $query->matching(
            $query->logicalAnd(
                $query->equals('recipient', $user),
                $query->equals('recipientDeleted', false)
            )
        )->setOrderings(array('sentDate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING)
        )->execute();
    }

    /**
     * Find unread messages for a user
     *
     * @param User $user
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findUnreadForUser(User $user)
    {
        $query = $this->createQuery();
        return $query->matching(
            $query->logicalAnd(
                $query->equals('recipient', $user),
                $query->logicalNot(
                    $query->logicalOr(
                        $query->equals('recipientDeleted', true),
                        $query->equals('tx_community_read', true)
                    )
                )
            )
        )->execute();
    }

    /**
     * Find all messages between users (for user1 - we see messages that user1 hasn't deleted)
     * @param User $user1
     * @param User $user2
     */
    public function findBetweenUsers(User $user1, User $user2)
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalOr(
                $query->logicalAnd(
                    $query->equals('sender', $user1),
                    $query->equals('senderDeleted', false),
                    $query->equals('recipient', $user2)
                ),
                $query->logicalAnd(
                    $query->equals('sender', $user2),
                    $query->equals('recipient', $user1),
                    $query->equals('recipientDeleted', false)
                )
            )
        );
        $query->setOrderings(array('sentDate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING));
        return $query->execute();
    }

    /**
     * Find all threaded messages between users (there are no deleted messages )
     * When using threaded messages only sender can delete the message
     * @param User $user1
     * @param User $user2
     */
    public function findBetweenUsersThreaded(User $user1, User $user2)
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalOr(
                $query->logicalAnd(
                    $query->equals('sender', $user1),
                    $query->equals('senderDeleted', false),
                    $query->equals('recipient', $user2)
                ),
                $query->logicalAnd(
                    $query->equals('sender', $user2),
                    $query->equals('recipient', $user1),
                    $query->equals('senderDeleted', false)
                )
            )
        );
        $query->setOrderings(array('sentDate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING));
        return $query->execute();
    }

    /**
     * Find newest message between users (don't have to be new)
     * @param User $user1
     * @param User $user2
     */
    public function findRecentBetweenUsers(User $user1, User $user2)
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalOr(
                $query->logicalAnd(
                    $query->equals('sender', $user1),
                    $query->equals('senderDeleted', false),
                    $query->equals('recipient', $user2)
                ),
                $query->logicalAnd(
                    $query->equals('sender', $user2),
                    $query->equals('recipient', $user1),
                    $query->equals('recipientDeleted', false)
                )
            )
        );
        $query->setOrderings(array('sentDate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING));
        return $query->execute()->getFirst();
    }

    /**
     * Find all messages between users (for recipient - we see messages that he hasn't deleted)
     * @param User $recipient
     * @param User $sender
     */
    public function findOneNewBetweenUsers(User $recipient, User $sender)
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                $query->equals('recipient', $recipient),
                $query->equals('sender', $sender),
                $query->equals('recipientDeleted', false),
                $query->equals('read_date', 0)
            )
        );
        return $query->execute()->getFirst();
    }

    /**
     * Find all messages for the current user
     *
     * @param User $user
     */
    public function findForUser(User $user)
    {
        $query = $this->createQuery();
        return $query->matching(
            $query->logicalOr(
                $query->logicalAnd(
                    $query->equals('sender', $user),
                    $query->equals('senderDeleted', false)
                ),
                $query->logicalAnd(
                    $query->equals('recipient', $user),
                    $query->equals('recipientDeleted', false)
                )
            )
        )->execute();
    }

    /**
     * Deletes all (sent, receved...) messages for given user - useful when we delete him
     *
     * @param User $user
     * @return void
     */
    public function deleteAllForUser(User $user)
    {
        $query = $this->createQuery();
        $messages = $query->matching(
            $query->logicalOr(
                $query->equals('sender', $user),
                $query->equals('recipient', $user)
            )
        )->execute();
        foreach ($messages as $message) {
            /* @var $message Message */
            if ($user->getUid() == $message->getSender()->getUid()) {
                $message->setSenderDeleted(TRUE);
            } else {
                $message->setRecipientDeleted(TRUE);
            }
            $this->update($message);
        }
    }
}

?>
