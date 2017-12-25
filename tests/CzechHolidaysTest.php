<?php
namespace JK\Utils\Tests;

use JK\Utils\CzechHolidays;
use PHPUnit\Framework\TestCase;
use DateTime;

final class CzechHolidaysTest extends TestCase
{
	/**
	 * @covers JK\Utils\CzechHolidays::isHoliday
	 * @covers JK\Utils\CzechHolidays::getHolidayName
	 */
	public function testWorkDay()
	{
		$workDate = DateTime::createFromFormat('Y-m-d', '2018-01-31');
		$this->assertFalse(CzechHolidays::isHoliday($workDate));
		$this->assertFalse(CzechHolidays::getHolidayName($workDate));
	}

	/**
	 * @covers JK\Utils\CzechHolidays::isHoliday
	 * @covers JK\Utils\CzechHolidays::getHolidayName
	 */
	public function testFixedHoliday()
	{
		$holiday = DateTime::createFromFormat('Y-m-d', '2018-01-01');
		$this->assertTrue(CzechHolidays::isHoliday($holiday));
		$this->assertSame('Nový rok', CzechHolidays::getHolidayName($holiday));
	}

	/**
	 * @covers JK\Utils\CzechHolidays::isHoliday
	 * @covers JK\Utils\CzechHolidays::getHolidayName
	 */
	public function testEasterSunday()
	{
		$holiday = DateTime::createFromFormat('Y-m-d', '2017-04-16');
		$this->assertTrue(CzechHolidays::isHoliday($holiday));
		$this->assertSame('Velikonoční neděle', CzechHolidays::getHolidayName($holiday));
	}

	/**
	 * @covers JK\Utils\CzechHolidays::getHolidaysForYear
	 * @covers JK\Utils\CzechHolidays::calculateEaster
	 * @covers JK\Utils\CzechHolidays::getEaster
	 */	
	public function testHolidaysForYear()
	{
		$holidays2018 = [
			'01-01' => 'Nový rok',
			'03-30' => 'Velký pátek',
			'04-01' => 'Velikonoční neděle',
			'04-02' => 'Velikonoční pondělí',
			'05-01' => 'Svátek práce',
			'05-08' => 'Den vítězství',
			'07-05' => 'Den slovanských věrozvěstů Cyrila a Metoděje',
			'07-06' => 'Den upálení mistra Jana Husa',
			'09-28' => 'Den české státnosti',
			'10-28' => 'Den vzniku samostatného československého státu',
			'11-17' => 'Den boje za svobodu a demokracii',
			'12-24' => 'Štědrý den',
			'12-25' => '1. svátek vánoční',
			'12-26' => '2. svátek vánoční'
		];
		$this->assertSame($holidays2018, CzechHolidays::getHolidaysForYear(2018));
	}
}
