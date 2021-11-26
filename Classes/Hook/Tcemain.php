<?php

namespace Macopedia\Community\Hook;

use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Backend\Utility\BackendUtility;

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
/**
 * Class called by hooks in TCEmain
 *
 *
 */
class Tcemain
{
    /**
     * This method is called by a hook in the TYPO3 Core Engine (TCEmain), e.g. by list module if deleting a record
     * inspired by Comments extension
     * @param string $command new, delete, ...
     * @param string $table Table we are working on
     * @param int $id Record uid of the updated record
     * @param mixed $value
     * @param \TYPO3\CMS\Core\DataHandling\DataHandler &$pObj reference to parent object
     * @return void
     */
    public function processCmdmap_postProcess($command, $table, $id, $value, DataHandler &$pObj)
    {
        if ($command === 'delete' && $table === 'fe_users' && is_int($id)) {
            $relationsCmdMap = $this->getCmdMapToDeleteRelations($id);
            $wallPostsCmdMap = $this->getCmdMapToDeleteWallPosts($id);

            $cmdmap = array_merge($relationsCmdMap, $wallPostsCmdMap);
            if (count($cmdmap)) {
                /* @var $tce \TYPO3\CMS\Core\DataHandling\DataHandler */
                $tce = GeneralUtility::makeInstance('\TYPO3\CMS\Core\DataHandling\DataHandler');
                $tce->start(false, $cmdmap, $pObj->BE_USER);

                $GLOBALS['TYPO3_DB']->sql_query('START TRANSACTION');
                $tce->process_cmdmap();
                if (count($tce->errorLog)) {
                    $GLOBALS['TYPO3_DB']->sql_query('ROLLBACK');
                    $pObj->errorLog = array_merge($pObj->errorLog, $tce->errorLog);
                } else {
                    $GLOBALS['TYPO3_DB']->sql_query('COMMIT');
                }
            }
        }
    }


    protected function getCmdMapToDeleteRelations($userId)
    {
        $cmdmap = array();
        $relations = $this->getRelations($userId);
        foreach ($relations as $relation) {
            $cmdmap['tx_community_domain_model_relation'][$relation['uid']]['delete'] = true;
        }
        return $cmdmap;
    }

    protected function getCmdMapToDeleteWallPosts($userId)
    {
        $cmdmap = array();
        $wallPosts = $this->getWallPosts($userId);
        foreach ($wallPosts as $wallPost) {
            $cmdmap['tx_community_domain_model_relation'][$wallPost['uid']]['delete'] = true;
        }
        return $cmdmap;
    }


    /**
     * Hides relations after hiding a user
     * @param $status
     * @param $table
     * @param $id
     * @param $fieldArray
     * @param $this
     */
    public function processDatamap_postProcessFieldArray($status, $table, $id, $fieldArray, &$pObj)
    {
        if ($status === 'update' && $table === 'fe_users' && $fieldArray['disable'] == 1 && is_int($id)) {
            $dataArr = array();

            $relations = $this->getRelations($id);
            foreach ($relations as $relation) {
                $dataArr['tx_community_domain_model_relation'][$relation['uid']]['hidden'] = 1;
            }

            $wallPosts = $this->getWallPosts($id);
            foreach ($wallPosts as $wallPost) {
                $dataArr['tx_community_domain_model_wallpost'][$wallPost['uid']]['hidden'] = 1;
            }

            $tce = GeneralUtility::makeInstance('\TYPO3\CMS\Core\DataHandling\DataHandler');
            $tce->start($dataArr, array());

            $GLOBALS['TYPO3_DB']->sql_query('START TRANSACTION');
            $tce->process_datamap();
            if (count($tce->errorLog)) {
                $GLOBALS['TYPO3_DB']->sql_query('ROLLBACK');
                $pObj->errorLog = array_merge($pObj->errorLog, $tce->errorLog);
            } else {
                $GLOBALS['TYPO3_DB']->sql_query('COMMIT');
            }
        }
    }

    protected function getRelations($userId)
    {
        $relations = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
            'uid',
            'tx_community_domain_model_relation',
            '(initiating_user=' . $userId . ' OR requested_user=' . $userId . ')' .
            BackendUtility::deleteClause('tx_community_domain_model_relation')
        );
        return $relations;
    }

    protected function getWallPosts($userId)
    {
        $w = 'tx_community_domain_model_wallpost';
        $wallPosts = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
            "$w.uid",
            'tx_community_domain_model_wallpost, fe_users',
            "fe_users.uid = $w.recipient AND ($w.recipient=$userId OR ($w.sender=$userId AND (fe_users.deleted=1 OR fe_users.disable=1)))" .
            BackendUtility::deleteClause($w)
        );
        return $wallPosts;
    }
}
