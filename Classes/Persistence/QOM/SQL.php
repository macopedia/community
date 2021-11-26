<?php

namespace Macopedia\Community\Persistence\QOM;

use TYPO3\CMS\Extbase\Persistence\Generic\Qom\ConstraintInterface;

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
 * Requires change in \TYPO3\CMS\Extbase\Persistence\Generic\Storage\Typo3DbBackend to work
 */
class SQL implements ConstraintInterface
{
    /**
     * The SQL code that is to be inserted in query
     * @var string
     */
    public $code;

    /**
     * @param string $SQL
     */
    public function __construct($SQL = '')
    {
        $this->code = $SQL;
    }

    /**
     * @param type $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function __tostring()
    {
        return (string)str_replace(PHP_EOL, '', $this->getCode());
    }

    /**
     * Fills an array with the names of all bound variables in the constraints
     *
     * @param array &$boundVariables
     */
    public function collectBoundVariableNames(&$boundVariables)
    {
    }
}
