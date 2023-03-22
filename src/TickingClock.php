<?php

declare(strict_types=1);

namespace Arokettu\Clock;

use DateInterval;
use DateTimeImmutable;
use DateTimeInterface;
use Psr\Clock\ClockInterface;

class TickingClock implements ClockInterface
{
    private DateInterval $dateInterval;
    private DateTimeImmutable $dateTime;

    public function __construct(DateInterval $dateInterval, ?DateTimeInterface $dateTime = null)
    {
        $this->dateInterval = clone $dateInterval; // decouple mutable object
        $this->dateTime = $dateTime ?
            Helpers\DateTimeHelper::createImmutableFromInterface($dateTime) :
            new DateTimeImmutable('now');
    }

    public function now(): DateTimeImmutable
    {
        $dt = $this->dateTime;
        $this->dateTime = $dt->add($this->dateInterval);
        return $dt;
    }
}
