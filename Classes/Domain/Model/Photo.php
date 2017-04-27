<?php

namespace Macopedia\Community\Domain\Model;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011 Konrad Baumgart
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
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
 * Image that is in user's gallery
 */
class Photo extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * image
     *
     * @var string
     * @validate NotEmpty
     */
    protected $image;

    /**
     * album
     *
     * @var \Macopedia\Community\Domain\Model\Album
     * @validate NotEmpty
     * @lazy
     */
    protected $album;

    /**
     * @param string $image
     * @return void
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }


    /**
     * @param \Macopedia\Community\Domain\Model\Album $album
     * @return void
     */
    public function setAlbum($album)
    {
        $this->album = $album;
    }

    /**
     * @return \Macopedia\Community\Domain\Model\Album
     */
    public function getAlbum()
    {
        return $this->album;
    }

}

?>