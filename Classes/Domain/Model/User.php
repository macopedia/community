<?php

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
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Pascal Jungblut <mail@pascalj.com>
 */
class Tx_Community_Domain_Model_User extends Tx_Extbase_Domain_Model_FrontendUser implements Tx_Community_Domain_Model_Observer_ObservableInterface  {

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
	 * @var string
	 */
	protected $gender;

	/**
	 * @var DateTime
	 */
	protected $dateOfBirth;

	/**
	 *
	 * @return
	 */
	public function getPoliticalView()
	{
	    return $this->politicalView;
	}

	/**
	 *
	 * @param $politicalView
	 */
	public function setPoliticalView($politicalView)
	{
	    $this->politicalView = $politicalView;
	}

	/**
	 *
	 * @return
	 */
	public function getReligiousView()
	{
	    return $this->religiousView;
	}

	/**
	 *
	 * @param $religiousView
	 */
	public function setReligiousView($religiousView)
	{
	    $this->religiousView = $religiousView;
	}

	/**
	 *
	 * @return
	 */
	public function getActivities()
	{
	    return $this->activities;
	}

	/**
	 *
	 * @param $activities
	 */
	public function setActivities($activities)
	{
	    $this->activities = $activities;
	}

	/**
	 *
	 * @return string
	 */
	public function getInterests()
	{
	    return $this->interests;
	}

	/**
	 *
	 * @param $interests
	 */
	public function setInterests($interests)
	{
	    $this->interests = $interests;
	}

	/**
	 *
	 * @return string
	 */
	public function getMusic()
	{
	    return $this->music;
	}

	/**
	 *
	 * @param $music
	 */
	public function setMusic($music)
	{
	    $this->music = $music;
	}

	/**
	 *
	 * @return string
	 */
	public function getMovies()
	{
	    return $this->movies;
	}

	/**
	 *
	 * @param $movies
	 */
	public function setMovies($movies)
	{
	    $this->movies = $movies;
	}

	/**
	 *
	 * @return string
	 */
	public function getBooks()
	{
	    return $this->books;
	}

	/**
	 *
	 * @param $books
	 */
	public function setBooks($books)
	{
	    $this->books = $books;
	}

	/**
	 *
	 * @return string
	 */
	public function getQuotes()
	{
	    return $this->quotes;
	}

	/**
	 *
	 * @param $quotes
	 */
	public function setQuotes($quotes)
	{
	    $this->quotes = $quotes;
	}

	/**
	 *
	 * @return string
	 */
	public function getAboutMe()
	{
	    return $this->aboutMe;
	}

	/**
	 *
	 * @param $aboutMe
	 */
	public function setAboutMe($aboutMe)
	{
	    $this->aboutMe = $aboutMe;
	}

	/**
	 *
	 * @return string
	 */
	public function getCellphone()
	{
	    return $this->cellphone;
	}

	/**
	 *
	 * @param $cellphone
	 */
	public function setCellphone($cellphone)
	{
	    $this->cellphone = $cellphone;
	}

	/**
	 *
	 * @param string $gender
	 * @return void
	 */
	public function setGender($gender) {
		$this->gender = $gender;
	}

	/**
	 * @return string
	 */
	public function getGender() {
		return $this->gender;
	}

	/**
	 *
	 * @return DateTime
	 */
	public function getDateOfBirth()
	{
	    return $this->dateOfBirth;
	}

	/**
	 *
	 * @param DateTime $dateOfBirth
	 */
	public function setDateOfBirth(DateTime $dateOfBirth)
	{
	    $this->dateOfBirth = $dateOfBirth;
	}
	
	/**
	 * Counts age from date of birth
	 * @return integer
	 */
	public function getAge()
	{
		$age = date('Y')-$this->dateOfBirth->format('Y');
		// Check if birthday month/day has been reached
		if (date('m')<$this->dateOfBirth->format('m')) {
			$age--;
		} elseif (date('m') == $this->dateOfBirth->format('m') && date('d')<$this->dateOfBirth->format('d')) {
			$age--;
		}
		return $age;
	}

	public function initializeObject() {
		parent::initializeObject();
		$objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager');
		$cacheObserver = $objectManager->get('Tx_Community_Domain_Model_Observer_CacheObserver');
		$this->attach($cacheObserver);
	}

	/**
	 * @var Tx_Community_Domain_Model_Observer_CacheObserver $cacheObserver
	 */
	public function injectCacheObserver(Tx_Community_Domain_Model_Observer_CacheObserver $cacheObserver) {
		$this->attach($cacheObserver);
	}


	/**
	 * Overrides the normal _isDirty function and notifies the observers if something has changed
	 */
	public function _isDirty($property = NULL, $notify = TRUE) {
		$dirty = parent::_isDirty($property);
		if ($dirty && $notify) {
			$this->notify();
		}
		return $dirty;
	}

	/**
     * Overrides the normal _isNew function and notifies the observers if this object is new (and will be persisted)
	 */
	public function _isNew($notify = TRUE) {
		$new = parent::_isNew();
		if ($new && $notify) {
			$this->notify();
		}
		return $new;
	}

	/**
	 * Attach an observer to this object
	 *
	 * @param Tx_Community_Domain_Model_Observer_ObserverInterface $observer
	 */
	public function attach(Tx_Community_Domain_Model_Observer_ObserverInterface $observer) {
		$this->observers[] = $observer;
	}

	/**
	 * Detach an observer from this object
	 *
	 * @param Tx_Community_Domain_Model_Observer_ObserverInterface $observer
	 */
	public function detach(Tx_Community_Domain_Model_Observer_ObserverInterface $observer) {
		$this->observers = array_diff($this->observers, array($observer));
	}

	/**
	 * Notify all observers that something has changed
	 */
	public function notify() {
		foreach($this->observers as $observer) {
			$observer->update($this);
		}
	}
}
?>