<?php

namespace Macopedia\Community\Domain\Model\Observer;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Object\ObjectManager;

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
 * An abstract class to make observable models easier
 *
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Pascal Jungblut <mail@pascalj.com>
 */
abstract class AbstractObservableEntity extends AbstractEntity implements ObservableInterface
{
    /**
     * Overrides the normal _isDirty function and notifies the observers if something has changed
     */
    public function _isDirty($property = null, $notify = true)
    {
        $dirty = parent::_isDirty($property);
        if ($dirty && $notify) {
            $this->notify();
        }
        return $dirty;
    }

    /**
     * Overrides the normal _isNew function and notifies the observers if this object is new (and will be persisted)
     */
    public function _isNew($notify = true)
    {
        $new = parent::_isNew();
        if ($new && $notify) {
            $this->notify();
        }
        return $new;
    }

    /**
     * Attach an observer to this object
     *
     * @param ObserverInterface $observer
     */
    public function attach(ObserverInterface $observer)
    {
        $this->observers[] = $observer;
    }

    /**
     * Detach an observer from this object
     *
     * @param ObserverInterface $observer
     */
    public function detach(ObserverInterface $observer)
    {
        $this->observers = array_diff($this->observers, [$observer]);
    }

    /**
     * Notify all observers that something has changed
     */
    public function notify()
    {
        if ($this->observers) {
            foreach ($this->observers as $observer) {
                $observer->update($this);
            }
        }
    }

    /**
     * inject the object manager
     *
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     */
    public function injectObjectManager(ObjectManager $objectManager)
    {
        $this->attach($objectManager->get('Macopedia\Community\Domain\Model\Observer\CacheObserver'));
    }
}
