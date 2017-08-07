<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Alexander Weiss <aweisswa@gmx.de>
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
 * Class that adds the wizard icon.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Alexander Weiss <aweisswa@gmx.de>
 */
class Tx_Community_Resources_Private_Php_wizicon
{

    /**
     * Processing the wizard items array
     *
     * @param array $wizardItems The wizard items
     *
     * @return array Modified array with wizard items
     */
    function proc($wizardItems)
    {
        // name of the plugin to load on startup
        $extKeyPlugin = 'community_listusers';

        $wizardItems['plugins_tx_community'] = array(
            'icon' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('community') . 'Resources/Public/Images/newElementWizardIcon.png',
            'title' => $GLOBALS['LANG']->sL('LLL:EXT:community/Resources/Private/Language/locallang_db.xml:wizard.title'),
            'description' => $GLOBALS['LANG']->sL('LLL:EXT:community/Resources/Private/Language/locallang_db.xml:wizard.description'),
            'params' => '&defVals[tt_content][CType]=list&defVals[tt_content][list_type]=' . $extKeyPlugin
        );
        return $wizardItems;
    }
}
