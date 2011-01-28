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

class Tx_Community_Service_Cache_NoCacheService implements Tx_Community_Service_Cache_CacheServiceInterface,t3lib_Singleton {

	/**
	 * Sets a cache entry
	 *
	 * @param mixed $content
	 * @param array $identifier
	 * @param array $tags
	 * @param integer $lifetime
	 */
	public function set($content, array $identifier, array $tags, $lifetime = 86400) {
		return;
	}

	/**
	 * Get a cache entry
	 *
	 * @param array $identifier
	 */
	public function get(array $identifier) {
		return;
	}

	/**
	 * Drop entries with $tags
	 *
	 * @param array $tags
	 */
	public function drop(array $tags) {
		return;
	}

	/**
	 * Flush the whole cache
	 */
	public function flush() {
		return;
	}

	/**
	 * Drop the tags for a certain entity
	 *
	 * @param Tx_Extbase_DomainObject_AbstractEntity $entity
	 */
	public function dropTagsForEntity(Tx_Extbase_DomainObject_AbstractEntity $entity) {
		return;
	}

	/**
	 *
	 * @param Tx_Extbase_DomainObject_AbstractEntity $object
	 */
	public function getTagsForEntity(Tx_Extbase_DomainObject_AbstractEntity $object) {
		return;
	}
}