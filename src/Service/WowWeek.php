<?php

namespace App\Service;


class WowWeek
{
    const EU_DELAY = 3;

    const EU_Start_Week = 1606863600;

    private static $affixesTurn = [
        [10, 122, 124, 121],
        [9, 11, 13, 121],
        [10, 8, 12, 121],
        [9, 6, 14, 121],
        [10, 11, 3, 121],
        [9, 7, 124, 121],
        [10, 123, 12, 121],
        [9, 122, 4, 121],
        [10, 8, 14, 121],
        [9, 6, 13, 121],
        [10, 123, 3, 121],
        [9, 7, 4, 121],
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
