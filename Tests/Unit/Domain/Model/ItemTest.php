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
 * Test case for class Tx_PbBesocial_Domain_Model_Item.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage BeSocial
 *
 * @author Mikolaj Jedrzejewski <mj@plusb.de>
 */
class Tx_PbBesocial_Domain_Model_ItemTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_PbBesocial_Domain_Model_Item
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_PbBesocial_Domain_Model_Item();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getUrlReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setUrlForStringSetsUrl() { 
		$this->fixture->setUrl('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getUrl()
		);
	}
	
	/**
	 * @test
	 */
	public function getDateReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getDate()
		);
	}

	/**
	 * @test
	 */
	public function setDateForIntegerSetsDate() { 
		$this->fixture->setDate(12);

		$this->assertSame(
			12,
			$this->fixture->getDate()
		);
	}
	
	/**
	 * @test
	 */
	public function getResultReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setResultForStringSetsResult() { 
		$this->fixture->setResult('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getResult()
		);
	}
	
}
?>