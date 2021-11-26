<?php

namespace Macopedia\Community\Persistence\Cacheable;

use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
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
/**
 * A cachable repository. Meaning that can return the tags that were used.
 *
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Pascal Jungblut <mail@pascalj.com>
 */
abstract class AbstractCacheableRepository extends Repository
{
    /**
     * The tags that were used fetched
     *
     * @var array
     */
    protected static $tags = array();

    /**
     * Get the tags for cache dropping
     */
    public function getTags()
    {
        return self::$tags;
    }

    /**
     * Constructs a new Repository
     *
     * @param \TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager
     */
    public function __construct(ObjectManagerInterface $objectManager)
    {
        parent::__construct($objectManager);
        $this->queryFactory = GeneralUtility::makeInstance('\Macopedia\Community\Persistence\Cacheable\TaggingQueryFactory');
        $this->queryFactory->injectRepository($this);
    }

    public function addTag($tag)
    {
        self::$tags[] = $tag;
    }

    public function createQuery()
    {
        return $this->queryFactory->create($this->objectType);
    }
}
