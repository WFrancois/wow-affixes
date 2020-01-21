<?php

namespace App\Service;


class WowWeek
{
    const EU_DELAY = 2;

    const EU_Start_Week = 1560895200;

    private static $affixesTurn = [
        [9, 7, 13, 120],
        [10, 11, 3, 120],
        [9, 6, 4, 120],
        [10, 5, 14, 120],
        [9, 11, 2, 120],
        [10, 7, 12, 120],
        [9, 6, 13, 120],
        [10, 8, 12, 120],
        [9, 5, 3, 120],
        [10, 7, 2, 120],
        [9, 11, 4, 120],
        [10, 8, 14, 120],
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
