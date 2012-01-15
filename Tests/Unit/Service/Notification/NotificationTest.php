<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2012 Tymoteusz Motylewski <t.motylewski@gmail.com>
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
 * Test for the notification class
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Tymoteusz Motylewski <t.motylewski@gmail.com>
 */
class Tx_Community_Tests_Service_Notification_NotificationTest extends Tx_Extbase_Tests_Unit_BaseTestCase {

	protected $notification;

	public function setUp() {
		$this->notification = new Tx_Community_Service_Notification_Notification();
	}

	/**
	 * @test
	 */
	public function magicMethodsTest() {
		$this->notification->setRelation('some string');
		$this->assertEquals('some string',  $this->notification->getRelation());

		$this->notification->setRule('ruleName'); //existing property
		$this->assertEquals('ruleName',  $this->notification->getRule());

		$this->assertEquals(NULL,  $this->notification->getNotSetbeforeProperty());
	}
}


