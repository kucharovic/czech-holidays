<?php

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
        '12-26' => '2. svátek vánoční'
    ];

    private static $easterFriday = 'Velký pátek';
    private static $easterSunday = 'Velikonoční neděle';
    private static $easterMonday = 'Velikonoční pondělí';

    /**
     * @param  DateTimeInterface $day
     * @return boolean
     */
    public static function isHoliday(DateTimeInterface $day)
    {
        return array_key_exists(
            $day->format('m-d'),
            self::getHolidaysForYear($day->format('Y'))
        );
    }

    /**
     * @param string|integer
     */
    public static function getHolidaysForYear($year)
    {
        $holidays = self::$fixed + self::getEaster($year);
        ksort($holidays);

        return $holidays;
    }

    /**
     * @param  DateTimeInterface $day
     * @return string|boolean
     */
    public static function getHolidayName(DateTimeInterface $day)
    {
       $holidays = self::getHolidaysForYear($day->format('Y'));

       if (array_key_exists($day->format('m-d'), $holidays)) {
           return $holidays[$day->format('m-d')];
       }

       return false;
    }

    /**
     * @param string|integer
     */
    private static function getEaster($year)
    {
        // number of days after March 21
        $easterDays = easter_days(intval($year));
        $march21th = DateTimeImmutable::createFromFormat('d-m-Y', '21-03-' . sprintf('%4d', $year));

        $easterSunday = $march21th->add(new DateInterval(sprintf('P%dD', $easterDays)));
        $easterFriday = $easterSunday->sub(new DateInterval('P2D'));
        $easterMonday = $easterSunday->add(new DateInterval('P1D'));

        return [
            $easterFriday->format('m-d') => self::$easterFriday,
            $easterSunday->format('m-d') => self::$easterSunday,
            $easterMonday->format('m-d') => self::$easterMonday
        ];
    }
}