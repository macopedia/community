<?php

namespace Macopedia\Community\Domain\Model\Observer;

use TYPO3\CMS\Core\SingletonInterface;
use Macopedia\Community\Service\Cache\CacheServiceInterface;
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
class CacheObserver implements ObserverInterface, SingletonInterface
{

    /**
     * @var \Macopedia\Community\Service\Cache\CacheServiceInterface
     */
    protected $cacheService;

    /**
     * Update an observable object
     *
     * @param  ObservableInterface $observable
     */
    public function update(ObservableInterface $observable)
    {
        $this->cacheService->dropTagsForEntity($observable);
        $observable->detach($this);
    }

    /**
     * Inject the cache service
     */
    public function injectCacheService(CacheServiceInterface $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    /**
     * Simply returns the class name. Used to remove the current observer from an object
     */
    public function __toString()
    {
        return get_class($this);
    }
}
