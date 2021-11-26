<?php

namespace Macopedia\Community\Service\Access;

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

/**
 * AccessHelper interface. To implement your own access mechanism, simple implement this
 * interface and inject it into the BaseController. All you have to do is return true or false
 * in the hasAccess() function.
 *
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Pascal Jungblut <mail@pascalj.com>
 */
interface AccessServiceInterface
{
    /**
     * Check if requestingUser has access to $resource of $requestedUser. $requestingUser may be empty if
     * "anonymous" is requesting a resource.
     *
     * @param User $requestingUser
     * @param User $requestedUser
     * @param string $resource
     * @return bool
     */
    public function hasAccess(
        User $requestingUser = null,
        User $requestedUser = null,
        $resource = ''
    );
}
