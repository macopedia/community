<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 Konrad Baumgart
*  All rights reserved
*
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
 * Enables usage of raw SQL in queries
 * Requires change in Tx_Extbase_Persistence_Storage_Typo3DbBackend to work
 */
class Tx_Community_Persistence_QOM_SQL implements Tx_Extbase_Persistence_QOM_ConstraintInterface {

	/**
	* The SQL code that is to be inserted in query
	* @var string
	*/
	var $code;

	/**
	* @param string $SQL
	*/
	public function __construct($SQL = '') {
	$this->code = $SQL;
	}

	/**
	* @param type $code
	* @return void
	*/
	public function setCode($code) {
	$this->code = $code;
	}

	/**
	* @return string
	*/
	public function getCode() {
	return $this->code;
	}
}
?>