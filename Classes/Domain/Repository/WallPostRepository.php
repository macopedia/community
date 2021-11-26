<?php

namespace Macopedia\Community\Domain\Repository;

use Macopedia\Community\Domain\Model\User;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
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

use TYPO3\CMS\Extbase\Persistence\Repository;

class WallPostRepository extends Repository
{
    /**
     * Finds most recent posts by the specified blog
     *
     * @param User $user The owner of wall
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface Wall posts
     */
    public function findRecentByRecipient(User $user)
    {
        $query = $this->createQuery();
        return $query->matching($query->equals('recipient', $user))
            ->setOrderings(['crdate' => QueryInterface::ORDER_DESCENDING])
            ->execute();
    }

    /**
     * Deletes  all (sent,receved...) wall posts for given user - useful when we delete him
     *
     * @param User $user
     */
    public function deleteAllForUser(User $user)
    {
        $query = $this->createQuery();
        $messages = $query->matching(
            $query->logicalOr([$query->equals('sender', $user), $query->equals('recipient', $user)])
        )->execute();

        foreach ($messages as $message) {
            if (!$message->getRecipient() || $message->getRecipient()->getUid() == $user->getUid()) {
                //delete all messages from my own wall, and all I send to already deleted user
                $this->remove($message);
            }
        }
    }
}
