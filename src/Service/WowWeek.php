<?php

namespace App\Service;


use DateTimeImmutable;

class WowWeek
{
    const EU_DELAY = 0;

    const EU_Start_Week = 1670385600;

    /**
     * @var array|(int[]|string)[]
     */
    private static array $affixesTurn = [
        'Unknown',
        'Unknown',
        [9, 124, 6],
        [10, 134, 7],
        [9, 136, 123],
        'Unknown',
        'Unknown',
        'Unknown',
        'Unknown',
        'Unknown',
    ];

    private int $weekNumber;

    public function __construct()
    {
        $this->weekNumber = self::getCurrentWeekNumber();
    }

    public function getWeekNumber(): int
    {
        return $this->weekNumber;
    }

    public function nextWeek(): void
    {
        $this->weekNumber += 1;
    }

    public function setWeekNumber(int $weekNumber): void
    {
        $this->weekNumber = $weekNumber;
    }

    /**
     * @return int[]|string
     */
    public function getCurrentAffixes()
    {
        return self::$affixesTurn[($this->weekNumber + self::EU_DELAY) % count(self::$affixesTurn)];
    }

    public function getWednesday(): DateTimeImmutable
    {
        $wednesday = strtotime('wednesday +' . $this->weekNumber . ' week', self::EU_Start_Week);

        return (new DateTimeImmutable())->setTimestamp($wednesday);
    }

    public static function getCurrentWeekNumber(): float
    {
        $week0 = (new DateTimeImmutable())->setTimestamp(self::EU_Start_Week);

        $now = strtotime('now');
        $startWeek = strtotime('this Tuesday -6 day + 5 hour', $now);
        $endWeek = strtotime('this Tuesday +28 hour +59 minute +59 second', $now);
        if (!($now >= $startWeek && $now <= $endWeek)) {
            $startWeek = strtotime('this Tuesday +1 week -6 day + 5 hour', $now);
            $endWeek = strtotime('this Tuesday +1 week +28 hour +59 minute +59 second', $now);
            if (!($now >= $startWeek && $now <= $endWeek)) {
                $startWeek = strtotime('this Tuesday -1 week -6 day + 5 hour', $now);
                $endWeek = strtotime('this Tuesday -1 week +28 hour +59 minute +59 second', $now);
            }
        }

        $thisWeek = (new DateTimeImmutable())->setTimestamp($startWeek);

        return floor($week0->diff($thisWeek)->format('%a') / 7);
    }
}
