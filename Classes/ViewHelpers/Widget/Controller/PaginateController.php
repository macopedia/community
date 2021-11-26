<?php

namespace Macopedia\Community\ViewHelpers\Widget\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetController;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010 Georg Ringer <typo3@ringerge.org>
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
 * Paginate controller to create the pagination.
 * Copied from news extension
 */
class PaginateController extends AbstractWidgetController
{
    /**
     * @var array
     */
    protected $configuration = ['itemsPerPage' => 10, 'insertAbove' => false, 'insertBelow' => true, 'pagesAfter' => 2, 'pagesBefore' => 2, 'lessPages' => true, 'forcedNumberOfLinks' => 4];
    /**
     * @var \TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    protected $objects;

    /**
     * @var int
     */
    protected $currentPage = 1;

    /**
     * @var int
     */
    protected $pagesBefore = 1;

    /**
     * @var int
     */
    protected $pagesAfter = 1;

    /**
     * @var bool
     */
    protected $lessPages = false;

    /**
     * @var int
     */
    protected $forcedNumberOfLinks = 10;

    /**
     * @var int
     */
    protected $numberOfPages = 1;

    /**
     * Initialize the action and get correct configuration
     */
    public function initializeAction()
    {
        $this->objects = $this->widgetConfiguration['objects'];
        $this->configuration = GeneralUtility::array_merge_recursive_overrule(
            $this->configuration,
            $this->widgetConfiguration['configuration'],
            true
        );
        $this->numberOfPages = ceil(count($this->objects) / (int)$this->configuration['itemsPerPage']);
        $this->pagesBefore = (int)$this->configuration['pagesBefore'];
        $this->pagesAfter = (int)$this->configuration['pagesAfter'];
        $this->lessPages = (bool)$this->configuration['lessPages'];
        $this->forcedNumberOfLinks = (int)$this->configuration['forcedNumberOfLinks'];
    }

    /**
     * If a certain number of links should be displayed, adjust before and after
     * amounts accordingly.
     */
    protected function adjustForForcedNumberOfLinks()
    {
        $forcedNumberOfLinks = $this->forcedNumberOfLinks;
        if ($forcedNumberOfLinks > $this->numberOfPages - 2) {
            $forcedNumberOfLinks = $this->numberOfPages - 2;
        }
        $totalNumberOfLinks = min($this->currentPage - 1, $this->pagesBefore) +
            min($this->pagesAfter, $this->numberOfPages - $this->currentPage - 1) + 1;

        if ($totalNumberOfLinks <= $forcedNumberOfLinks) {
            $delta = (int)(ceil(($forcedNumberOfLinks - $totalNumberOfLinks) / 2));
            $incr = ($forcedNumberOfLinks & 1) == 0 ? 1 : 0;
            if ($this->currentPage - ($this->pagesBefore + $delta) < 2) {
                // Too little from the right to adjust
                $this->pagesAfter = $forcedNumberOfLinks - $this->currentPage - 2;
                $this->pagesBefore = $forcedNumberOfLinks - $this->pagesAfter - 1;
            } elseif ($this->currentPage + ($this->pagesAfter + $delta) >= $this->numberOfPages - 1) {
                $this->pagesBefore = $forcedNumberOfLinks - ($this->numberOfPages - $this->currentPage - 1);
                $this->pagesAfter = $forcedNumberOfLinks - $this->pagesBefore - 1;
            } else {
                $this->pagesBefore += $delta;
                $this->pagesAfter += $delta - $incr;
            }
        }
    }

    /**
     * Main action which does all the fun
     *
     * @param int $currentPage
     */
    public function indexAction($currentPage = 1)
    {
        // set current page
        $this->currentPage = (int)$currentPage;
        if ($this->currentPage < 1) {
            $this->currentPage = 1;
        } elseif ($this->currentPage > $this->numberOfPages) {
            $this->currentPage = $this->numberOfPages;
        }

        // modify query
        $itemsPerPage = (int)$this->configuration['itemsPerPage'];
        $query = $this->objects->getQuery();

        // limit should only be used if needed
        if ($itemsPerPage > $query->getLimit()) {
            $query->setLimit($itemsPerPage);
        }

        if ($this->currentPage > 1) {
            $query->setOffset((int)($itemsPerPage * ($this->currentPage - 1)));
        }
        $modifiedObjects = $query->execute();

        $this->view->assign('contentArguments', [
            $this->widgetConfiguration['as'] => $modifiedObjects,
        ]);
        $this->view->assign('configuration', $this->configuration);
        $this->view->assign('pagination', $this->buildPagination());
    }

    /**
     * Returns an array with the keys
     * "pages", "current", "numberOfPages", "nextPage" & "previousPage"
     *
     * @return array
     */
    protected function buildPagination()
    {
        $this->adjustForForcedNumberOfLinks();

        $pages = [];
        $start = (int)max($this->currentPage - $this->pagesBefore, 1);
        $end = (int)min($this->numberOfPages - 1, $this->currentPage + $this->pagesAfter + 1);
        for ($i = $start; $i < $end; $i++) {
            $j = $i + 1;
            $pages[] = ['number' => $j, 'isCurrent' => ($j === $this->currentPage)];
        }

        $pagination = [
            'pages' => $pages,
            'current' => $this->currentPage,
            'numberOfPages' => $this->numberOfPages,
            'pagesBefore' => $this->pagesBefore,
            'pagesAfter' => $this->pagesAfter,
        ];
        if ($this->currentPage < $this->numberOfPages) {
            $pagination['nextPage'] = $this->currentPage + 1;
        }
        if ($this->currentPage > 1) {
            $pagination['previousPage'] = $this->currentPage - 1;
        }

        // Less pages
        if ($start > 1 && $this->lessPages) {
            $pagination['lessPages'] = true;
        }
        // More pages
        if ($end < $this->numberOfPages - 1 && $this->lessPages) {
            $pagination['morePages'] = true;
        }
        return $pagination;
    }
}
