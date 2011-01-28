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

class Tx_Community_Persistence_Cacheable_TaggingQuery extends Tx_Extbase_Persistence_Query {

	/**
	 * @var array
	 */
	protected $tags = array();

	/**
	 * @var Tx_Community_Persistence_Cacheable_AsbtractCacheableRepository
	 */
	protected $repository;

	/**
	 * @var Tx_Community_Service_Cache_CacheService
	 */
	protected $cacheService;

	/**
	 * Execute a query
	 *
	 * @return array
	 */
	public function execute() {
		$objects = parent::execute();
		foreach($objects as $object) {
			$tags = $this->cacheService->getTagsForEntity($object);
			foreach ($tags as $tag) {
				$this->repository->addTag($tag);
			}
		}

		// very important! otherwise Tx_Extbase_Persistence_Repository::update will blow up in your face.
		reset($objects);
		return $objects;
	}

	/**
	 * Inject the cache service
	 *
	 * @param Tx_Community_Service_Cache_CacheService $cacheService
	 */
	public function injectCacheService(Tx_Community_Service_Cache_CacheService $cacheService) {
		$this->cacheService = $cacheService;
	}

	public function injectRepository(Tx_Community_Persistence_Cacheable_AbstractCacheableRepository $repository) {
		$this->repository = $repository;
	}
}
?>