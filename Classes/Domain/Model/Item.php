<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Mikolaj Jedrzejewski <mj@plusb.de>, plusB
 *  
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
 *
 *
 * @package pb_besocial
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_PbBesocial_Domain_Model_Item extends Tx_Extbase_DomainObject_AbstractEntity {

    /**
     * type
     *
     * @var string
     */
    protected $type;

	/**
	 * url
	 *
	 * @var string
	 */
	protected $url;

	/**
	 * date
	 *
	 * @var integer
	 */
	protected $date;

	/**
	 * result
	 *
	 * @var string
	 */
	protected $result;

	/**
	 * Returns the url
	 *
	 * @return string $url
	 */
	public function getUrl() {
		return $this->url;
	}

	/**
	 * Sets the url
	 *
	 * @param string $url
	 * @return void
	 */
	public function setUrl($url) {
		$this->url = $url;
	}

	/**
	 * Returns the date
	 *
	 * @return integer $date
	 */
	public function getDate() {
		return $this->date;
	}

	/**
	 * Sets the date
	 *
	 * @param integer $date
	 * @return void
	 */
	public function setDate($date) {
		$this->date = $date;
	}

	/**
	 * Returns the result json_decoded
	 *
	 * @return string $result
	 */
	public function getResult() {
		return json_decode($this->result);
	}

	/**
	 * Sets the result
	 *
	 * @param string $result
	 * @return void
	 */
	public function setResult($result) {
		$this->result = $result;
	}

    /**
     * Returns the type
     *
     * @return string $type
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Sets the type
     *
     * @param string $type
     * @return void
     */
    public function setType($type) {
        $this->type = $type;
    }

}
?>