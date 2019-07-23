<?php declare(strict_types=1);

namespace JK\Utils;

use DateTimeInterface, DateTimeImmutable, DateInterval;

final class CzechHolidays
{
	/** @var array  MM-DD => Holiday name **/
	private static $fixed = [
		'01-01' => 'Nový rok',
		'05-01' => 'Svátek práce',
		'05-08' => 'Den vítězství',
		'07-05' => 'Den slovanských věrozvěstů Cyrila a Metoděje',
		'07-06' => 'Den upálení mistra Jana Husa',
		'09-28' => 'Den české státnosti',
		'10-28' => 'Den vzniku samostatného československého státu',
		'11-17' => 'Den boje za svobodu a demokracii',
		'12-24' => 'Štědrý den',
		'12-25' => '1. svátek vánoční',
		'12-26' => '2. svátek vánoční',
	];

	private static $goodFriday = 'Velký pátek';
	private static $easter = 'Velikonoční neděle';
	private static $easterMonday = 'Velikonoční pondělí';

	/**
	 * @param  DateTimeInterface $day
	 * @return bool
	 */
	public static function isHoliday(DateTimeInterface $day): bool
	{
		return \array_key_exists(
			$day->format('m-d'),
			self::getHolidaysForYear((int) $day->format('Y'))
		);
	}

	/**
	 * @param integer $year
	 * @return array<string,string>
	 */
	public static function getHolidaysForYear(int $year): array
	{
		$holidays = self::$fixed + self::getEaster($year);
		\ksort($holidays);

		return $holidays;
	}

	/**
	 * @param  DateTimeInterface $day
	 * @return string|null
	 */
	public static function getHolidayName(DateTimeInterface $day): ?string
	{
	   $holidays = self::getHolidaysForYear((int) $day->format('Y'));

	   if (\array_key_exists($day->format('m-d'), $holidays)) {
		   return $holidays[$day->format('m-d')];
	   }

	   return null;
	}

	/**
	 * @param integer $year
	 * @return array<string,string>
	 */
	private static function getEaster(int $year): array
	{
		$easter = self::calculateEaster($year);
		$goodFriday = $easter->sub(new DateInterval('P2D'));
		$easterMonday = $easter->add(new DateInterval('P1D'));

		return [
			$goodFriday->format('m-d')   => self::$goodFriday,
			$easter->format('m-d')       => self::$easter,
			$easterMonday->format('m-d') => self::$easterMonday
		];
	}

	/**
	 * @link https://github.com/azuyalabs/yasumi/blob/1.6.1/src/Yasumi/Provider/ChristianHolidays.php#L561-L637
	 *
	 * @param int $year
	 * @return DateTimeImmutable
	 */
	private static function calculateEaster(int $year): DateTimeImmutable
	{
		if (\extension_loaded('calendar')) {
			$easter_days = \easter_days($year);
		} else {
			$golden = (int) (($year % 19) + 1); // The Golden Number
			// The Julian calendar applies to the original method from 326AD. The Gregorian calendar was first
			// introduced in October 1582 in Italy. Easter algorithms using the Gregorian calendar apply to years
			// 1583 AD to 4099 (A day adjustment is required in or shortly after 4100 AD).
			// After 1752, most western churches have adopted the current algorithm.
			if ($year <= 1752) {
				$dom = ($year + (int) ($year / 4) + 5) % 7; // The 'Dominical number' - finding a Sunday
				if ($dom < 0) {
					$dom += 7;
				}
				$pfm = (3 - (11 * $golden) - 7) % 30; // Uncorrected date of the Paschal full moon
				if ($pfm < 0) {
					$pfm += 30;
				}
			} else {
				$dom = ($year + (int) ($year / 4) - (int) ($year / 100) + (int) ($year / 400)) % 7; // The 'Dominical number' - finding a Sunday
				if ($dom < 0) {
					$dom += 7;
				}
				$solar = (int) (($year - 1600) / 100) - (int) (($year - 1600) / 400); // The solar correction
				$lunar = (int) (((int) (($year - 1400) / 100) * 8) / 25); // The lunar correction
				$pfm = (3 - (11 * $golden) + $solar - $lunar) % 30; // Uncorrected date of the Paschal full moon
				if ($pfm < 0) {
					$pfm += 30;
				}
			}
			// Corrected date of the Paschal full moon, - days after 21st March
			if (($pfm === 29) || ($pfm === 28 && $golden > 11)) {
				--$pfm;
			}
			$tmp = (4 - $pfm - $dom) % 7;
			if ($tmp < 0) {
				$tmp += 7;
			}
			$easter_days = (int) ($pfm + $tmp + 1); // Easter as the number of days after 21st March
		}
		$march21st = DateTimeImmutable::createFromFormat('Y-m-d', \sprintf('%4d-03-21', $year));
		return $march21st->add(new DateInterval(\sprintf('P%dD', $easter_days)));
	}
}
