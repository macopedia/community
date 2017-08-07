<?php

namespace Macopedia\Community\ViewHelpers;

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
 * Shows the date of newest message between users
 *
 * @author Konrad Baumgart
 */
class LastMessageDateViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
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
    public function injectRepositoryService(\Macopedia\Community\Service\RepositoryServiceInterface $repositoryService)
    {
        $this->repositoryService = $repositoryService;
    }

    /**
     * Gives the date of most recent message between user1 and user2
     * @param User $user1
     * @param User $user2
     */
    public function render($user1, $user2)
    {
        return $this->repositoryService->get('message')->findRecentBetweenUsers($user1, $user2)->getSentDate();
    }
}