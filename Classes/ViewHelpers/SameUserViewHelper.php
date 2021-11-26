<?php

namespace Macopedia\Community\ViewHelpers;

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
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractConditionViewHelper;

/**
 * Checks if the requestedUser and the requestingUser are the same.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Pascal Jungblut <mail@pascalj.com>
 */
class SameUserViewHelper extends AbstractConditionViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('requestingUser', 'object', 'Requesting User.');
        $this->registerArgument('requestedUser', 'object', 'Requested User.');
    }

    protected static function evaluateCondition($arguments = null)
    {
        $requestingUser = $arguments['requestingUser'];
        $requestedUser = $arguments['requestedUser'];

        if ($requestingUser instanceof User) {
            $requestingUser = $requestingUser->getUid();
        }

        if ($requestedUser instanceof User) {
            $requestedUser = $requestedUser->getUid();
        }

        if ((is_int($requestingUser) && $requestingUser === $requestedUser)
            || ($requestingUser === null && $requestedUser === null)
        ) {
            return true;
        }
        return false;
    }

    public function render()
    {
        if (static::evaluateCondition($this->arguments)) {
            return $this->renderThenChild();
        }
        return $this->renderElseChild();
    }
}
