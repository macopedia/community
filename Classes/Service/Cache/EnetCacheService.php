<?php

namespace Macopedia\Community\Service\Cache;

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapFactory;

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
class EnetCacheService implements CacheServiceInterface, SingletonInterface
{
    /**
     * The cache handler
     *
     * @var object
     */
    protected static $cacheHandler;

    /**
     * The datamap factory
     *
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapFactory
     */
    protected static $dataMapFactory;

    /**
     * Constructor, initialize the cacheHander
     */
    public function __construct()
    {
        if (!$this->cacheHandler) {
            $this->cacheHandler = GeneralUtility::makeInstance('tx_enetcache');
        }
        if (!$this->dataMapFactory) {
            $this->dataMapFactory = new DataMapFactory(GeneralUtility::makeInstance('\TYPO3\CMS\Extbase\Reflection\ReflectionService'));
            $this->dataMapFactory->injectReflectionService(GeneralUtility::makeInstance('\TYPO3\CMS\Extbase\Reflection\ReflectionService'));
        }
    }

    /**
     * Sets a cache entry
     *
     * @param mixed $content
     * @param array $identifier
     * @param array $tags
     * @param int $lifetime
     */
    public function set($content, array $identifier, array $tags, $lifetime = 86400)
    {
        $this->cacheHandler->set($content, $identifier, $tags, $lifetime);
    }

    /**
     * Get a cache entry
     *
     * @param array $identifier
     */
    public function get(array $identifier)
    {
        $this->cacheHandler->get($identifier);
    }

    /**
     * Drop entries with $tags
     *
     * @param array $tags
     */
    public function drop(array $tags)
    {
        $this->cacheHandler->drop($tags);
    }

    /**
     * Flush the whole cache
     */
    public function flush()
    {
        $this->cacheHandler->flush();
    }

    /**
     * Drop the tags for a certain entity
     *
     * @param \TYPO3\CMS\Extbase\DomainObject\AbstractEntity $entity
     */
    public function dropTagsForEntity(AbstractEntity $entity)
    {
        $map = $this->dataMapFactory->buildDataMap(get_class($entity));
        $tableName = $map->getTableName();

        $tags = [
            $tableName . '_' . $entity->getUid(),
        ];
        $this->drop($tags);
    }

    /**
     * @param \TYPO3\CMS\Extbase\DomainObject\AbstractEntity $object
     */
    public function getTagsForEntity(AbstractEntity $object)
    {
        $map = $this->dataMapFactory->buildDataMap(get_class($object));
        $tableName = $map->getTableName();

        $tags = [
            $tableName, $tableName . '_' . $object->getUid(),
        ];

        return $tags;
    }
}
