<?php

namespace Macopedia\Community\Persistence\Storage;

use TYPO3\CMS\Extbase\Persistence\Generic\Qom\AndInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\Qom\OrInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\Qom\NotInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\Qom\ComparisonInterface;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;
use Macopedia\Community\Persistence\QOM\SQL;
/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Mapper\ColumnMap;
use TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Utility\TypeHandlingUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Qom;

/**
 * QueryParser, converting the qom to string representation
 */
class Typo3DbQueryParser extends \TYPO3\CMS\Extbase\Persistence\Generic\Storage\Typo3DbQueryParser
{
    /**
     * Walks through the qom's constraints and extracts the properties and values.
     *
     * In the qom the query structure and values are glued together. This walks through the
     * qom and only extracts the parts necessary for generating the hash and filling the
     * statement. It leaves out the actual statement generation, as it is the most time
     * consuming.
     *
     * @param Qom\ConstraintInterface $comparison The constraint. Could be And-, Or-, Not- or ComparisonInterface
     * @param string $qomPath current position of the child in the qom
     * @return array Array of parameters and operators
     * @throws \Exception
     */
    protected function preparseComparison($comparison, $qomPath = '')
    {
        $parameters = array();
        $operators = array();
        $objectsToParse = array();

        $delimiter = '';
        if ($comparison instanceof AndInterface) {
            $delimiter = 'AND';
            $objectsToParse = array($comparison->getConstraint1(), $comparison->getConstraint2());
        } elseif ($comparison instanceof OrInterface) {
            $delimiter = 'OR';
            $objectsToParse = array($comparison->getConstraint1(), $comparison->getConstraint2());
        } elseif ($comparison instanceof NotInterface) {
            $delimiter = 'NOT';
            $objectsToParse = array($comparison->getConstraint());
        } elseif ($comparison instanceof ComparisonInterface) {
            $operand1 = $comparison->getOperand1();
            $parameterIdentifier = $this->normalizeParameterIdentifier($qomPath . $operand1->getPropertyName());
            $comparison->setParameterIdentifier($parameterIdentifier);
            $operator = $comparison->getOperator();
            $operand2 = $comparison->getOperand2();
            if ($operator === QueryInterface::OPERATOR_IN) {
                $items = array();
                foreach ($operand2 as $value) {
                    if (VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version) < 7000000) {
                        $value = $this->getPlainValue($value);
                    } else {
                        $value = $this->dataMapper->getPlainValue($value);
                    }
                    if ($value !== null) {
                        $items[] = $value;
                    }
                }
                $parameters[$parameterIdentifier] = $items;
            } else {
                $parameters[$parameterIdentifier] = $operand2;
            }
            $operators[] = $operator;
        } elseif ($comparison instanceof SQL) {
            $parameters = array(array(), (string)$comparison);
            return array($parameters, $operators);
        } elseif (!is_object($comparison)) {
            $parameters = array(array(), $comparison);
            return array($parameters, $operators);
        } else {
            throw new \Exception('Can not hash Query Component "' . get_class($comparison) . '".', 1392840462);
        }

        $childObjectIterator = 0;
        foreach ($objectsToParse as $objectToParse) {
            list($preparsedParameters, $preparsedOperators) = $this->preparseComparison($objectToParse, $qomPath . $delimiter . $childObjectIterator++);
            if (!empty($preparsedParameters)) {
                $parameters = array_merge($parameters, $preparsedParameters);
            }
            if (!empty($preparsedOperators)) {
                $operators = array_merge($operators, $preparsedOperators);
            }
        }

        return array($parameters, $operators);
    }
}
