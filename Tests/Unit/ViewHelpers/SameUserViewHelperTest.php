<?php

namespace Macopedia\Community\Tests\ViewHelpers;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Tymoteusz Motylewski
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
use Macopedia\Community\ViewHelpers\SameUserViewHelper;

/**
 * Test for the SameUserViewHelper
 *
 *
 */
class SameUserViewHelperTest extends \TYPO3\TestingFramework\Fluid\Unit\ViewHelpers\ViewHelperBaseTestcase
{

    /**
     * @var \Macopedia\Community\ViewHelpers\SameUserViewHelper|\PHPUnit_Framework_MockObject_MockObject|\TYPO3\TestingFramework\Core\AccessibleObjectInterface
     */
    protected $viewHelper;

    public function setUp()
    {
        parent::setUp();
        $this->viewHelper = $this->getAccessibleMock(SameUserViewHelper::class, ['renderThenChild', 'renderElseChild']);
        $this->injectDependenciesIntoViewHelper($this->viewHelper);
        $this->viewHelper->initializeArguments();
    }

    /**
     * @test
     * @dataProvider thenProvider
     */
    public function viewHelperRendersThenChildIfConditionIsTrue($user1, $user2)
    {
        $this->viewHelper->expects($this->once())->method('renderThenChild')->will($this->returnValue('then'));
        $this->viewHelper->expects($this->never())->method('renderElseChild');
        $this->viewHelper->setArguments(['requestingUser' => $user1, 'requestedUser' => $user2]);

        $actualResult = $this->viewHelper->render();
        $this->assertEquals('then', $actualResult);
    }

    public function thenProvider()
    {
        $user1 = $this->getAccessibleMock(User::class, null);
        $user1->_set('uid', 1);
        $user2 = $this->getAccessibleMock(User::class, null);
        $user2->_set('uid', 1);
        $user3 = $this->getAccessibleMock(User::class, null);
        $user3->_set('uid', 10);

        return array(
            array($user1, $user2),
            array($user1, $user1),
            array(null, null),
            array(3, 3),
            array($user1, 1),
            array($user3, 10)
        );
    }


    /**
     * @test
     * @dataProvider elseProvider
     */
    public function viewHelperRendersElseChildIfConditionIsFalse($user1, $user2)
    {
        $this->viewHelper->expects($this->once())->method('renderElseChild')->will($this->returnValue('else'));
        $this->viewHelper->expects($this->never())->method('renderThenChild');

        $this->viewHelper->setArguments(['requestingUser' => $user1, 'requestedUser' => $user2]);
        $actualResult = $this->viewHelper->render();
        $this->assertEquals('else', $actualResult);
    }

    public function elseProvider()
    {
        $user1 = $this->getAccessibleMock(User::class, null);
        $user1->_set('uid', 1);
        $user2 = $this->getAccessibleMock(User::class, null);
        $user2->_set('uid', 8);

        return array(
            array("sss", 23323),
            array($user1, $user2),
            array($user1, null),
            array(null, $user1),
            array(2, 1),
            array($user2, 2),
            array($user2, 0),
            array($user2, 1)
        );
    }
}


