<?php

namespace Macopedia\Community\Persistence\Cacheable;

use TYPO3\CMS\Extbase\Persistence\Generic\QueryFactory;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;
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
class TaggingQueryFactory extends QueryFactory
{

    /**
     * @var \Macopedia\Community\Persistence\Cacheable\AbstractCacheableRepository
     */
    protected $repository;

    /**
     * Creates a tagging query for a given classname
     *
     * @param string $className
     */
    public function create($className)
    {
        $objectManager = new ObjectManager();
        $persistenceManager = $objectManager->get('TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface');
        $backend = $objectManager->get('TYPO3\CMS\Extbase\Persistence\Generic\Backend');

        $reflectionService = $backend->getReflectionService();

        $dataMapFactory = GeneralUtility::makeInstance('\TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapFactory');
        $dataMapFactory->injectReflectionService($reflectionService);

        $dataMapper = GeneralUtility::makeInstance('\TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper');
        $dataMapper->injectIdentityMap($backend->getIdentityMap());
        $dataMapper->injectSession($backend->getSession());
        $dataMapper->injectReflectionService($reflectionService);
        $dataMapper->injectDataMapFactory($dataMapFactory);

        $querySettings = GeneralUtility::makeInstance('\TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings');

        $query = GeneralUtility::makeInstance('\Macopedia\Community\Persistence\Cacheable\TaggingQuery', $className);
        $query->injectPersistenceManager($persistenceManager);
        $query->injectCacheService(GeneralUtility::makeinstance('\Macopedia\Community\Service\Cache\CacheService'));
        $query->injectRepository($this->repository);
        $query->injectDataMapper($dataMapper);
        $query->setQuerySettings($querySettings);

        return $query;
    }

    public function injectRepository(AbstractCacheableRepository $repository)
    {
        $this->repository = $repository;
    }
}

