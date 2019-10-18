<?php

namespace App\Service;


class WowWeek
{
    const EU_DELAY = 2;

    const EU_Start_Week = 1560895200;

    private static $affixesTurn = [
        [7, 13, 9, 'Tides'],
        [11, 3, 10, 'Enchanted'],
        [6, 4, 9, 'Void'],
        [5, 14, 10, 'Tides'],
        [11, 2, 9, 'Enchanted'],
        [7, 12, 10, 'Void'],
        [6, 13, 9, 'Tides'],
        [8, 12, 10, 'Enchanted'],
        [5, 3, 9, 'Void'],
        [7, 2, 10, 'Tides'],
        [11, 4, 9, 'Enchanted'],
        [8, 14, 10, 'Void'],
    ];

    private $weekNumber;

    public function __construct()
    {
        $this->weekNumber = self::getCurrentWeekNumber();
    }

    public function getWeekNumber()
    {
        return $this->weekNumber;
    }

    public function nextWeek()
    {
        $this->weekNumber += 1;
    }

    public function setWeekNumber(int $weekNumber)
    {
        $this->weekNumber = $weekNumber;
    }

    public function getCurrentAffixes()
    {
        return self::$affixesTurn[($this->weekNumber + self::EU_DELAY) % count(self::$affixesTurn)];
    }

    public function getWednesday()
    {
        $wednesday = strtotime('wednesday +' . $this->weekNumber . ' week', self::EU_Start_Week);

        return (new \DateTime())->setTimestamp($wednesday);
    }

    public static function getCurrentWeekNumber()
    {
        $week0 = (new \DateTime())->setTimestamp(self::EU_Start_Week);

        $now = strtotime('now');
        $startWeek = strtotime('this Tuesday -6 day + 9 hour', $now);
        $endWeek = strtotime('this Tuesday +32 hour +59 minute +59 second', $now);
        if (!($now >= $startWeek && $now <= $endWeek)) {
            $startWeek = strtotime('this Tuesday +1 week -6 day + 9 hour', $now);
            $endWeek = strtotime('this Tuesday +1 week +32 hour +59 minute +59 second', $now);
            if (!($now >= $startWeek && $now <= $endWeek)) {
                $startWeek = strtotime('this Tuesday -1 week -6 day + 9 hour', $now);
                $endWeek = strtotime('this Tuesday -1 week +32 hour +59 minute +59 second', $now);
            }
        }

        $thisWeek = (new \DateTime())->setTimestamp($startWeek);

        $interval = date_diff($week0, $thisWeek);
        return floor($interval->format('%a') / 7);
    }
}
