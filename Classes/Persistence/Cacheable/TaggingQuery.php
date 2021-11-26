<?php

namespace Macopedia\Community\Persistence\Cacheable;

use TYPO3\CMS\Extbase\Persistence\Generic\Query;
use Macopedia\Community\Service\Cache\CacheService;
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
class TaggingQuery extends Query
{

    /**
     * @var array
     */
    protected $tags = array();

    /**
     * @var AsbtractCacheableRepository
     */
    protected $repository;

    /**
     * @var \Macopedia\Community\Service\Cache\CacheService
     */
    protected $cacheService;

    /**
     * Execute a query
     *
     * @return array
     */
    public function execute()
    {
        $objects = parent::execute();
        foreach ($objects as $object) {
            $tags = $this->cacheService->getTagsForEntity($object);
            foreach ($tags as $tag) {
                $this->repository->addTag($tag);
            }
        }

        // very important! otherwise \TYPO3\CMS\Extbase\Persistence\Repository::update will blow up in your face.
        reset($objects);
        return $objects;
    }

    /**
     * Inject the cache service
     *
     * @param \Macopedia\Community\Service\Cache\CacheService $cacheService
     */
    public function injectCacheService(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    public function injectRepository(AbstractCacheableRepository $repository)
    {
        $this->repository = $repository;
    }
}
