<?php

declare(strict_types=1);

namespace Arokettu\Clock;

use DateInterval;
use DateTimeImmutable;
use DateTimeZone;
use Psr\Clock\ClockInterface;

final class ShiftedClock implements ClockInterface
{
    private DateInterval $dateInterval;
    private DateTimeZone|null $timeZone;

    public function __construct(DateInterval $dateInterval, DateTimeZone|null $timeZone = null)
    {
        $this->dateInterval = clone $dateInterval; // decouple mutable object
        $this->timeZone = $timeZone;
    }

    public static function fromDateString(string $dateInterval, DateTimeZone|null $timeZone = null): self
    {
        return new self(DateInterval::createFromDateString($dateInterval), $timeZone);
    }

    public function now(): DateTimeImmutable
    {
        return (new DateTimeImmutable('now', $this->timeZone))->add($this->dateInterval);
    }
}
