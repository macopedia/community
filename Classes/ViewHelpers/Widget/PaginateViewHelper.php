<?php

namespace Macopedia\Community\ViewHelpers\Widget;

use TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetViewHelper;
use Macopedia\Community\ViewHelpers\Widget\Controller\PaginateController;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
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
 * This ViewHelper renders a Pagination of objects.
 * Copied from news extension
 *
 * = Examples =
 *
 * <code title="required arguments">
 * <f:widget.paginate objects="{blogs}" as="paginatedBlogs">
 *   // use {paginatedBlogs} as you used {blogs} before, most certainly inside
 *   // a <f:for> loop.
 * </f:widget.paginate>
 * </code>
 */
class PaginateViewHelper extends AbstractWidgetViewHelper
{

    /**
     * @var Controller\PaginateController
     */
    protected $controller;

    /**
     * Inject controller
     *
     * @param Controller\PaginateController $controller
     * @return void
     */
    public function injectController(PaginateController $controller)
    {
        $this->controller = $controller;
    }

    /**
     * Render everything
     *
     * @return string
     */
    public function render()
    {
        $objects = $this->arguments['objects'];
        $as = $this->arguments['as'];
        $configuration = $this->arguments['configuration'];
        return $this->initiateSubRequest();
    }

    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('objects', QueryResultInterface::class, '', true);
        $this->registerArgument('as', 'string', '', true);
        $this->registerArgument('configuration', 'mixed', '', false, ['itemsPerPage' => 10, 'insertAbove' => false, 'insertBelow' => true]);
    }
}
