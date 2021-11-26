<?php

namespace Macopedia\Community\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011 Pascal Jungblut <mail@pascalj.de>
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
 * Checks if the requestedUser and the requestingUser are the same.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Pascal Jungblut <mail@pascalj.com>
 */
class InListViewHelper extends AbstractViewHelper
{
    public function render()
    {
        $list = $this->arguments['list'];
        $value = $this->arguments['value'];
        $seperator = $this->arguments['seperator'];
        return in_array($value, explode($seperator, $list));
    }

    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('list', 'string', 'A list seperated by $seperator', false, '');
        $this->registerArgument('value', 'string', 'The value to look for', false, '');
        $this->registerArgument('seperator', 'string', 'The seperator for the list', false, ',');
    }
}
