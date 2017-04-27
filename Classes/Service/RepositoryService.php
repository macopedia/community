<?php

namespace Macopedia\Community\Service;
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
 * Standard repository helper.
 *
 * It uses Dependency injection to make repositories replaceable by
 * third party extensions. That's useful if you, for any reason, want to extend a certain model.
 * By changing the repository for that model, you can easily replace the model with your own.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Pascal Jungblut <mail@pascalj.com>
 */
class RepositoryService implements \Macopedia\Community\Service\RepositoryServiceInterface, \TYPO3\CMS\Core\SingletonInterface
{

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * Get the repository for the model $repositoryName (e.g. "user")
     *
     * @param string $repositoryName
     * @return \TYPO3\CMS\Extbase\Persistence\Repository
     */
    public function get($repositoryName)
    {
        return $this->repositories[$repositoryName] = $this->objectManager->get('Macopedia\Community\Domain\Repository\\' . ucfirst($repositoryName) . 'Repository');
    }

    /**
     * Inject the object manager so we can create objects on our own.
     *
     * @param \TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager
     */
    public function injectObjectManager(\TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }
}

?>