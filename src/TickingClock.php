<?php

declare(strict_types=1);

namespace Arokettu\Clock;

use DateInterval;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Psr\Clock\ClockInterface;

final class TickingClock implements ClockInterface
{
    private DateInterval $dateInterval;
    private DateTimeImmutable $dateTime;

    public function __construct(DateInterval $dateInterval, DateTimeInterface|null $dateTime = null)
    {
        $this->dateInterval = clone $dateInterval; // decouple mutable object
        $this->dateTime = $dateTime ?
            DateTimeImmutable::createFromInterface($dateTime) :
            new DateTimeImmutable('now');
    }

    public static function fromDateString(
        string $dateInterval,
        string $dateTime = 'now',
        DateTimeZone|null $timeZone = null
    ): self {
        return new self(
            DateInterval::createFromDateString($dateInterval),
            new DateTimeImmutable($dateTime, $timeZone)
        );
    }

    public function now(): DateTimeImmutable
    {
        $dt = $this->dateTime;
        $this->dateTime = $dt->add($this->dateInterval);
        return $dt;
    }

    public function __debugInfo(): array
    {
        return [
            'now' => $this->dateTime,
        ];
    }
}
