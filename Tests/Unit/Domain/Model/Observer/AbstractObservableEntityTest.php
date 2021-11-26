<?php

namespace Macopedia\Community\Tests\Unit\Domain\Model\Observer;

use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
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

use Macopedia\Community\Domain\Model\Observer\CacheObserver,
    Macopedia\Community\Domain\Model\Observer\AbstractObservableEntity;

/**
 * Test for the cache observer
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Pascal Jungblut <mail@pascalj.com>
 */
class AbstractObservableEntityTest extends UnitTestCase
{

    private $cacheService;

    private $observable;

    private $observer;

    public function setUp()
    {
        $this->observable = $this->getMock('AbstractObservableEntity');
        $this->observer = new CacheObserver();
    }
}