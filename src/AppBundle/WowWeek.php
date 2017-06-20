<?php
/**
 * Created by PhpStorm.
 * User: Francois "Wisak" Wroblewski
 * Date: 17/12/2016
 * Time: 23:32
 */

namespace AppBundle;


use DateTime;

class WowWeek
{
    const EU_DELAY = 1;
    const NA_DELAY = -1;

    const EU_Start_Week = 1451430000;

    private static $affixesTurn = array(
        array(6, 4, 9),
        array(7, 2, 10),
        array(5, 4, 9),
        array(8, 12, 10),
        array(7, 13, 9),
        array(11, 14, 10),
        array(6, 3, 9),
        array(5, 13, 10),
        array(7, 12, 9),
        array(8, 3, 10),
        array(11, 2, 9),
        array(5, 14, 10),
    );

    private $weekNumber;

    public function __construct()
    {
        $this->weekNumber = self::getCurrentWeekNumber();
    }

    public function getWeekNumber() {
        return $this->weekNumber;
    }

    public function nextWeek() {
        $this->weekNumber += 1;
    }

    public function setWeekNumber(int $weekNumber) {
        $this->weekNumber = $weekNumber;
    }

    public function getCurrentAffixes() {
        return self::$affixesTurn[($this->weekNumber + self::EU_DELAY) % count(self::$affixesTurn)];
    }

    public function getWednesday() {
        $wednesday = strtotime('wednesday +' . $this->weekNumber . ' week', self::EU_Start_Week);

        return (new DateTime())->setTimestamp($wednesday);
    }

    public static function getCurrentWeekNumber() {
        $week0 = (new DateTime())->setTimestamp(self::EU_Start_Week);

        $now     = strtotime('now');
        $startWeek = strtotime('this Tuesday -6 day + 9 hour', $now);
        $endWeek   = strtotime('this Tuesday +32 hour +59 minute +59 second', $now);
        if(!($now >= $startWeek && $now <= $endWeek)) {
            $startWeek = strtotime('this Tuesday +1 week -6 day + 9 hour', $now);
            $endWeek   = strtotime('this Tuesday +1 week +32 hour +59 minute +59 second', $now);
            if(!($now >= $startWeek && $now <= $endWeek)) {
                $startWeek = strtotime('this Tuesday -1 week -6 day + 9 hour', $now);
                $endWeek   = strtotime('this Tuesday -1 week +32 hour +59 minute +59 second', $now);
            }
        }

        $thisWeek = (new DateTime())->setTimestamp($startWeek);

        $interval = date_diff($week0, $thisWeek);
        return floor($interval->format('%a') / 7);
    }
}
