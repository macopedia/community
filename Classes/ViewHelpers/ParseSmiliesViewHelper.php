<?php

namespace Macopedia\Community\ViewHelpers;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Alexander Weiß
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
 * Parses a string for Smilies and replaces them with small images
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class ParseSmiliesViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * Renders the SmiliesViewHelper
     *
     * @param string $string String with smilie codes
     *
     * @return string String with smilie images
     */
    public function render($string = '')
    {
        if ($string === '') {
            $string = $this->renderChildren();
        }
        // if ext:smilie is installed we will automatically replace the smilies
        if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('smilie')) {
            $smilie = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('tx_smilie');
            /* @var $smilie tx_smilie */
            return $smilie->replaceSmilies($string);
        }
        return $string;
    }
}

