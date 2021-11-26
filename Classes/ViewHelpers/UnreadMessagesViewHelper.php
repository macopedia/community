<?php

namespace Macopedia\Community\ViewHelpers;

use TYPO3\CMS\Fluid\ViewHelpers\IfViewHelper;
use Macopedia\Community\Service\RepositoryServiceInterface;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011 Konrad Baumgart
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

/**
 * Checks if there are new messages to user1 from user2
 *
 * @author Konrad Baumgart
 */
class UnreadMessagesViewHelper extends IfViewHelper
{
    /**
     * Repository service. Get all your repositories with it.
     *
     * @var \Macopedia\Community\Service\RepositoryServiceInterface
     */
    protected $repositoryService;

    /**
     * Inject the repository service.
     *
     * @param \Macopedia\Community\Service\RepositoryServiceInterface $repositoryService
     */
    public function injectRepositoryService(RepositoryServiceInterface $repositoryService)
    {
        $this->repositoryService = $repositoryService;
    }

    /**
     * Checks if there are new messages from $sender to $recipient
     * @param User $recipient
     * @param User $sender
     * @return string the rendered string
     */
    public function render($recipient, $sender)
    {
        if ($this->repositoryService->get('message')->findOneNewBetweenUsers($recipient, $sender)) {
            return $this->renderThenChild();
        } else {
            return $this->renderElseChild();
        }
    }
}
