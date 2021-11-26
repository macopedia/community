<?php

namespace Macopedia\Community\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/***************************************************************
 * Copyright notice
 *
 * (c) 2013 Alexander Weiß
 *
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
/**
 * Renders a country flag for the given country object
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CountryFlagViewHelper extends AbstractViewHelper
{
    /**
     * Renders the CountryFlagViewHelper
     *
     * @return string Country Flag Image
     */
    public function render()
    {
        $country = $this->arguments['country'];
        return !empty($country) ? '<span title="' . $country->getShortNameEn() . '" class="tx_community_flags tx_community_flag_'
            . strtolower($country->getIsoCodeA2()) . '">&nbsp;</span>' : '';
    }

    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('country', 'SJBR\StaticInfoTables\Domain\Model\Country', 'Country-Object', false);
    }
}
