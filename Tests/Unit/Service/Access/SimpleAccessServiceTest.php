<?php

namespace Macopedia\Community\Tests\Unit\Service\Access;

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

use Macopedia\Community\Service\Access\SimpleAccessService;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test for the simple access service
 *
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Pascal Jungblut <mail@pascalj.com>
 */
class SimpleAccessServiceTest extends UnitTestCase
{
    /**
     * @test
     */
    public function hasAccessReturnsTrueForSameUser()
    {
        $stub = $this->getMock('User');
        $stub->expects(self::any())
            ->method('getUid')
            ->willReturn(1);
        $accessService = new SimpleAccessService();
        self::assertTrue($accessService->hasAccess($stub, $stub));
    }
}
