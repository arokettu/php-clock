<?php

declare(strict_types=1);

namespace Arokettu\Clock;

use DateInterval;
use DateTimeImmutable;
use DateTimeZone;
use Psr\Clock\ClockInterface;

final class ShiftedClock implements ClockInterface
{
    /** @var DateInterval */
    private $dateInterval;
    /** @var DateTimeZone|null */
    private $timeZone;

    public function __construct(DateInterval $dateInterval, DateTimeZone $timeZone = null)
    {
        $this->dateInterval = Helpers\DateTimeHelper::cloneInterval($dateInterval); // decouple mutable object
        $this->timeZone = $timeZone;
    }

    public function now(): DateTimeImmutable
    {
        return (new DateTimeImmutable('now', $this->timeZone))->add($this->dateInterval);
    }
}
