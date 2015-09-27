<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 Tymoteusz Motylewski
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
 * Update class for extmgr,
 * inspired by news extension
 *
 * @package TYPO3
 * @subpackage tx_community
 */
class ext_update {
	const STATUS_WARNING = -1;
	const STATUS_ERROR = 0;
	const STATUS_OK = 1;

	protected $messageArray = array();

	protected function changeGender() {
		$status = self::STATUS_OK;;
		$title = 'Changing gender type form varchar to int';

		$res =  $GLOBALS['TYPO3_DB']->exec_SELECTquery(
					'count(*)',
					'fe_users',
					"gender like '%male%'",
					'',
					'',
					''
				);

		$entry = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
		$message = '';
		if ($entry['count(*)'] <=0 ) {
			$message = "Everything is up to date";
		} else {
			$updateArray = array('gender' => 0);

			$res = $GLOBALS['TYPO3_DB']->exec_UPDATEquery('fe_users', "gender = 'male'", $updateArray);
			if ($res === FALSE) {
				$message .= "\n".' Could not change gender "male"';
				$status = self::STATUS_ERROR;
			}

			$updateArray['gender'] = 1;
			$res = $GLOBALS['TYPO3_DB']->exec_UPDATEquery('fe_users', "gender = 'female'", $updateArray);

			if ($res === FALSE) {
				$message .= "\n".' Could not change gender "female"';
				$status = self::STATUS_ERROR;
			}

			$sql = "ALTER TABLE fe_users CHANGE gender gender int(11) unsigned default '0'";

			if ($GLOBALS['TYPO3_DB']->admin_query($sql) === FALSE) {
					$message .= ' SQL ERROR: ' .  $GLOBALS['TYPO3_DB']->sql_error();
					$status = self::STATUS_ERROR;
				} else {
					$message .= 'OK!';
					$status = self::STATUS_OK;
				}
		}
		$this->messageArray[] = array($status, $title, $message);
	}


	/**
	 * Main update function called by the extension manager.
	 *
	 * @return string
	 */
	public function main() {
		$this->changeGender();
		return $this->generateOutput();
	}



	/**
	 * Generates more or less readable output.
	 *
	 * @todo: beautify output :)
	 * @return string
	 */
	protected function generateOutput() {
		$output = '';
		foreach ($this->messageArray as $messageItem) {
			$output .= '<strong>' . $messageItem[1] . '</strong><br />' .
				'&nbsp;&nbsp;&nbsp;->' . $messageItem[2] . '<br /><br />';
		}
		return $output;
	}

	/**
	 * Called by the extension manager to determine if the update menu entry
	 * should by showed.
	 *
	 * @return bool
	 * @todo find a better way to determine if update is needed or not.
	 */
	public function access() {
		return TRUE;
	}
}
