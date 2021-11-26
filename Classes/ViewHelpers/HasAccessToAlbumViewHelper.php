<?php

namespace Macopedia\Community\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractConditionViewHelper;
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

use Macopedia\Community\Domain\Model\Album;
use Macopedia\Community\Domain\Model\User;
use Macopedia\Community\Domain\Model\Relation;

/**
 * Checks if the requestedUser and the requestingUser are the same.
 *
 */
class HasAccessToAlbumViewHelper extends AbstractConditionViewHelper
{

    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('album', 'object', 'Album Object.');
        $this->registerArgument('relation', 'object', 'Relation Object.');
        $this->registerArgument('requestingUser', 'object', 'Requesting User Object.');
    }

    protected static function evaluateCondition($arguments = null)
    {
        /** @var Album $album */
        $album = $arguments['album'];
        /** @var Relation $relation */
        $relation = $arguments['relation'];
        /** @var User $requestingUser */
        $requestingUser = $arguments['requestingUser'];

        if (
            ($album->getPrivate() == 0) || //public
            ($requestingUser && $requestingUser->getUid() === $album->getUser()->getUid()) || // my album
            ($requestingUser && $relation && $relation->getStatus() === Relation::RELATION_STATUS_CONFIRMED && ($album->getPrivate() == 2)) //friends can see it
        ) {
            return true;
        } else {
            return false;
        }
    }
        public function render()
    {
        if (static::evaluateCondition($this->arguments)) {
            return $this->renderThenChild();
        } else {
            return $this->renderElseChild();
        }
    }
}
