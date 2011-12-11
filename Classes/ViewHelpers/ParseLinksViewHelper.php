<?php
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
class Tx_Community_ViewHelpers_ParseLinksViewHelper extends Tx_Fluid_ViewHelpers_BaseViewHelper {

	/**
	 * @see http://www.flashnutz.com/2010/07/find-links-within-text-and-convert-to-active-links-with-php/
	 * @param string $string The data to be parsed for links
	 * @return string
	 */
	public function render($string) {
		$regularExpressionsPattern = array(
			'/(((f|ht){1}tp\:\/\/)[-a-zA-Z0-9@:%_+.~#?&\/\/=]+)/ei',
			'/([[:space:][{}])?(www.[-a-zA-Z0-9@:%_+.~#?&\/\/=]+)/ei',
			'/([_.0-9a-z-]+@([0-9a-z][0-9a-z-]+.)+[a-z]{2,3})/ei'
		);
		$regularExpressionsReplacement = array(
			'"<a href=\"$1\" target=\"_blank\" rel=\"nofollow\">".$this->stringWrap("$1", 35)."</a>"',
			'"$1<a href=\"http://$2\" target=\"_blank\" rel=\"nofollow\">".$this->stringWrap("$2", 35)."</a>"',
			'"<a href=\"mailto:$1\" rel=\"nofollow\">".$this->stringWrap("$1", 35)."</a>"'
		);
		return preg_replace($regularExpressionsPattern, $regularExpressionsReplacement, $string);
	}

	/**
	 * @param $string
	 * @param $limit
	 * @return string
	 */
	protected function stringWrap($string, $limit) {
		return wordwrap($string, $limit, '<wbr />', TRUE);
	}
}
?>