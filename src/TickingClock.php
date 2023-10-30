<?php

declare(strict_types=1);

namespace Arokettu\Clock;

use DateInterval;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Psr\Clock\ClockInterface;

class TickingClock implements ClockInterface
{
    /** @var DateInterval */
    private $dateInterval;
    /** @var DateTimeImmutable */
    private $dateTime;

    public function __construct(DateInterval $dateInterval, DateTimeInterface $dateTime = null)
    {
        $this->dateInterval = Helpers\DateTimeHelper::cloneInterval($dateInterval); // decouple mutable object
        $this->dateTime = $dateTime ?
            Helpers\DateTimeHelper::createImmutableFromInterface($dateTime) :
            new DateTimeImmutable('now');
    }

    public static function fromDateString(
        string $dateInterval,
        string $dateTime = 'now',
        DateTimeZone $timeZone = null
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
}
