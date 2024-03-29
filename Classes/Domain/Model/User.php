<?php

namespace Macopedia\Community\Domain\Model;

use Macopedia\Community\Domain\Model\Observer\CacheObserver;
use Macopedia\Community\Domain\Model\Observer\ObservableInterface;
use Macopedia\Community\Domain\Model\Observer\ObserverInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Model\FrontendUser;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010 Pascal Jungblut <mail@pascal-jungblut.com>
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
 * A normal user of the community
 *
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Pascal Jungblut <mail@pascalj.com>
 */
class User extends FrontendUser implements ObservableInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $politicalView;

    /**
     * @var string
     */
    protected $religiousView;

    /**
     * @var string
     */
    protected $activities;

    /**
     * @var string
     */
    protected $interests;

    /**
     * @var string
     */
    protected $music;

    /**
     * @var string
     */
    protected $movies;

    /**
     * @var string
     */
    protected $books;

    /**
     * @var string
     */
    protected $quotes;

    /**
     * @var string
     */
    protected $aboutMe;

    /**
     * @var string
     */
    protected $cellphone;

    /**
     * @var int
     */
    protected $gender;

    /**
     * @var \DateTime
     */
    protected $dateOfBirth;

    /**
     * Sets the name value
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = trim($name);
    }

    /**
     * Returns the name value, if empty it returns the username
     *
     * @return string
     */
    public function getName()
    {
        $name = trim($this->name);
        return $name ? $name : $this->username;
    }

    /**
     * Sets the firstName value
     *
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = trim($firstName);
    }

    /**
     * Sets the middleName value
     *
     * @param string $middleName
     */
    public function setMiddleName($middleName)
    {
        $this->middleName = trim($middleName);
    }

    /**
     * Sets the lastName value
     *
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = trim($lastName);
    }

    /**
     * @return string
     */
    public function getPoliticalView()
    {
        return $this->politicalView;
    }

    /**
     * @param $politicalView
     */
    public function setPoliticalView($politicalView)
    {
        $this->politicalView = $politicalView;
    }

    /**
     * @return string
     */
    public function getReligiousView()
    {
        return $this->religiousView;
    }

    /**
     * @param $religiousView
     */
    public function setReligiousView($religiousView)
    {
        $this->religiousView = $religiousView;
    }

    /**
     * @return string
     */
    public function getActivities()
    {
        return $this->activities;
    }

    /**
     * @param $activities
     */
    public function setActivities($activities)
    {
        $this->activities = $activities;
    }

    /**
     * @return string
     */
    public function getInterests()
    {
        return $this->interests;
    }

    /**
     * @param $interests
     */
    public function setInterests($interests)
    {
        $this->interests = $interests;
    }

    /**
     * @return string
     */
    public function getMusic()
    {
        return $this->music;
    }

    /**
     * @param $music
     */
    public function setMusic($music)
    {
        $this->music = $music;
    }

    /**
     * @return string
     */
    public function getMovies()
    {
        return $this->movies;
    }

    /**
     * @param $movies
     */
    public function setMovies($movies)
    {
        $this->movies = $movies;
    }

    /**
     * @return string
     */
    public function getBooks()
    {
        return $this->books;
    }

    /**
     * @param $books
     */
    public function setBooks($books)
    {
        $this->books = $books;
    }

    /**
     * @return string
     */
    public function getQuotes()
    {
        return $this->quotes;
    }

    /**
     * @param $quotes
     */
    public function setQuotes($quotes)
    {
        $this->quotes = $quotes;
    }

    /**
     * @return string
     */
    public function getAboutMe()
    {
        return $this->aboutMe;
    }

    /**
     * @param $aboutMe
     */
    public function setAboutMe($aboutMe)
    {
        $this->aboutMe = $aboutMe;
    }

    /**
     * @return string
     */
    public function getCellphone()
    {
        return $this->cellphone;
    }

    /**
     * @param $cellphone
     */
    public function setCellphone($cellphone)
    {
        $this->cellphone = $cellphone;
    }

    /**
     * @param int $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return int
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @return \DateTime
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * @param \DateTime $dateOfBirth
     */
    public function setDateOfBirth(\DateTime $dateOfBirth = null)
    {
        $this->dateOfBirth = $dateOfBirth;
    }

    /**
     * Counts age from date of birth
     * @return int
     */
    public function getAge()
    {
        $age = date('Y') - $this->dateOfBirth->format('Y');
        // Check if birthday month/day has been reached
        if (date('m') < $this->dateOfBirth->format('m')) {
            $age--;
        } elseif (date('m') == $this->dateOfBirth->format('m') && date('d') < $this->dateOfBirth->format('d')) {
            $age--;
        }
        return $age;
    }

    public function initializeObject()
    {
        $objectManager = GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');
        $cacheObserver = $objectManager->get('Macopedia\Community\Domain\Model\Observer\CacheObserver');
        $this->attach($cacheObserver);
    }

    /**
     * @var \Macopedia\Community\Domain\Model\Observer\CacheObserver $cacheObserver
     */
    public function injectCacheObserver(CacheObserver $cacheObserver)
    {
        $this->attach($cacheObserver);
    }

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
     * @param \Macopedia\Community\Domain\Model\Observer\ObserverInterface $observer
     */
    public function attach(ObserverInterface $observer)
    {
        $this->observers[] = $observer;
    }

    /**
     * Detach an observer from this object
     *
     * @param \Macopedia\Community\Domain\Model\Observer\ObserverInterface $observer
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
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }
}
