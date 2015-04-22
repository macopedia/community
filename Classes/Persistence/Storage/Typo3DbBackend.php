<?php
namespace Macopedia\Community\Persistence\Storage;
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
 * Edited storage backend to enable
 *  Macopedia\Community\Persistence\QOM\SQL usage in queries
 *  custom orderings
 */
class Typo3DbBackend extends \TYPO3\CMS\Extbase\Persistence\Generic\Storage\Typo3DbBackend {

	/**
	* Transforms a constraint into SQL and parameter arrays
	*
	* @param \TYPO3\CMS\Extbase\Persistence\Generic\Qom\ConstraintInterface $constraint The constraint
	* @param \TYPO3\CMS\Extbase\Persistence\Generic\Qom\SourceInterface $source The source
	* @param array &$sql The query parts
	* @param array &$parameters The parameters that will replace the markers
	* @param array $boundVariableValues The bound variables in the query (key) and their values (value)
	* @return void
	*/
	protected function parseConstraint(\TYPO3\CMS\Extbase\Persistence\Generic\Qom\Statement $constraint = NULL, \TYPO3\CMS\Extbase\Persistence\Generic\Qom\SourceInterface $source, array &$sql, array &$parameters) {
		if ($constraint instanceof \TYPO3\CMS\Extbase\Persistence\Generic\Qom\Statement) {
			$sql['where'][] = $constraint->getStatement();
		} else {
			parent::parseConstraint($constraint, $source, $sql, $parameters);
		}
	}

	/**
	* Transforms orderings into SQL.
	*
	* @param array $orderings An array of orderings (\TYPO3\CMS\Extbase\Persistence\Generic\Qom\Ordering)
	* @param \TYPO3\CMS\Extbase\Persistence\Generic\Qom\SourceInterface $source The source
	* @param array &$sql The query parts
	* @return void
	*/
	protected function parseOrderings(array $orderings, \TYPO3\CMS\Extbase\Persistence\Generic\Qom\SourceInterface $source, array &$sql) {
		foreach ($orderings as $propertyName => $order) {
			switch ($order) {
				case \TYPO3\CMS\Extbase\Persistence\Generic\Qom\QueryObjectModelConstantsInterface::JCR_ORDER_ASCENDING: // Deprecated since Extbase 1.1
				case \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING:
					$order = 'ASC';
					break;
				case \TYPO3\CMS\Extbase\Persistence\Generic\Qom\QueryObjectModelConstantsInterface::JCR_ORDER_DESCENDING: // Deprecated since Extbase 1.1
				case \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING:
					$order = 'DESC';
					break;
				default:
					throw new \TYPO3\CMS\Extbase\Persistence\Generic\Exception\UnsupportedOrderException('Unsupported order encountered.', 1242816074);
			}
			if (substr(trim($propertyName),0,1) === '(') {
				$sql['orderings'][] = $propertyName.' '.$order;
			} else {
				if ($source instanceof \TYPO3\CMS\Extbase\Persistence\Generic\Qom\SelectorInterface) {
					$className = $source->getNodeTypeName();
					$tableName = $this->dataMapper->convertClassNameToTableName($className);
					while (strpos($propertyName, '.') !== FALSE) {
						$this->addUnionStatement($className, $tableName, $propertyName, $sql);
					}
				} elseif ($source instanceof \TYPO3\CMS\Extbase\Persistence\Generic\Qom\JoinInterface) {
					$tableName = $source->getLeft()->getSelectorName();
				}
				$columnName = $this->dataMapper->convertPropertyNameToColumnName($propertyName, $className);
				if (strlen($tableName) > 0) {
					$sql['orderings'][] = $tableName . '.' . $columnName . ' ' . $order;
				} else {
					$sql['orderings'][] = $columnName . ' ' . $order;
				}
			}
		}
	}
}