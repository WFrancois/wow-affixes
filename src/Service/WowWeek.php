<?php

namespace App\Service;


class WowWeek
{
    const EU_DELAY = 0;

    const EU_Start_Week = 1560895200;

    private static $affixesTurn = [
        [5, 3, 9],
        [5, 14, 10],
        [11, 2, 9],
        [7, 12, 10],
        [6, 13, 9],
        [8, 12, 10],
        [5, 3, 9],
        [7, 2, 10],
        [11,4,9],
        [8,14,10],
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
