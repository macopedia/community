<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Pascal Jungblut <mail@pascalj.de>
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
 * Checks if the requestedUser and the requestingUser are the same.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Konrad Baumgart
 */
class Tx_Community_ViewHelpers_HasAccessToAlbumViewHelper extends Tx_Fluid_ViewHelpers_IfViewHelper {

	/**
	 * @param Tx_Community_Domain_Model_Album $album
	 * @param Tx_Community_Domain_Model_Relation $relation
	 * @param Tx_Community_Domain_Model_User $requestingUser
	 */
	public function render(Tx_Community_Domain_Model_Album $album, Tx_Community_Domain_Model_Relation $relation = NULL, Tx_Community_Domain_Model_User $requestingUser = NULL) {
		if (
				($album->getPrivate() == 0) || //public
				($requestingUser && $requestingUser->getUid() === $album->getUser()->getUid()) || // my album
				($requestingUser && $relation && $relation->getStatus() === Tx_Community_Domain_Model_Relation::RELATION_STATUS_CONFIRMED && ($album->getPrivate() == 2)) //friends can see it
			) {
			return $this->renderThenChild();
		} else {
			return $this->renderElseChild();
		}
	}
}
?>