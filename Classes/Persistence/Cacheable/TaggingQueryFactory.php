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

class Tx_Community_Persistence_Cacheable_TaggingQueryFactory extends Tx_Extbase_Persistence_QueryFactory {

	/**
	 * @var Tx_Community_Persistence_Cacheable_AbstractCacheableRepository
	 */
	protected $repository;

	/**
	 * Creates a tagging query for a given classname
	 *
	 * @param string $className
	 */
	public function create($className) {
		$persistenceManager = Tx_Extbase_Dispatcher::getPersistenceManager();

		$reflectionService = $persistenceManager->getBackend()->getReflectionService();

		$dataMapFactory = t3lib_div::makeInstance('Tx_Extbase_Persistence_Mapper_DataMapFactory');
		$dataMapFactory->injectReflectionService($reflectionService);

		$dataMapper = t3lib_div::makeInstance('Tx_Extbase_Persistence_Mapper_DataMapper');
		$dataMapper->injectIdentityMap($persistenceManager->getBackend()->getIdentityMap());
		$dataMapper->injectSession($persistenceManager->getSession());
		$dataMapper->injectReflectionService($reflectionService);
		$dataMapper->injectDataMapFactory($dataMapFactory);

		$querySettings = t3lib_div::makeInstance('Tx_Extbase_Persistence_Typo3QuerySettings');

		$query = t3lib_div::makeInstance('Tx_Community_Persistence_Cacheable_TaggingQuery', $className);
		$query->injectPersistenceManager($persistenceManager);
		$query->injectCacheService(t3lib_div::makeinstance('Tx_Community_Service_Cache_CacheService'));
		$query->injectRepository($this->repository);
		$query->injectDataMapper($dataMapper);
		$query->setQuerySettings($querySettings);

		return $query;
	}

	public function injectRepository(Tx_Community_Persistence_Cacheable_AbstractCacheableRepository $repository) {
		$this->repository = $repository;
	}
}
?>