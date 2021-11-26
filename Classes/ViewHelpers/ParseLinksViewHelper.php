<?php

namespace Macopedia\Community\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use Macopedia\Community\Helper\UrlLinkerHelper;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011 Simon Schaufelberger
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
 * Parses a string for links and replaces them with clickable links
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class ParseLinksViewHelper extends AbstractViewHelper
{
    /**
     * @see http://www.flashnutz.com/2010/07/find-links-within-text-and-convert-to-active-links-with-php/
     * @return string
     */
    public function render()
    {
        $string = $this->arguments['string'];
        return UrlLinkerHelper::htmlEscapeAndLinkUrls($string);
    }

    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('string', 'string', 'The data to be parsed for links', true);
    }
}
