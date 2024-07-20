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
    /** @var DateInterval */
    private $dateInterval;
    /** @var DateTimeImmutable */
    private $dateTime;

    /**
     * @param DateTimeInterface|null $dateTime
     */
    public function __construct(DateInterval $dateInterval, $dateTime = null)
    {
        $this->dateInterval = Helpers\DateTimeHelper::cloneInterval($dateInterval); // decouple mutable object
        $this->dateTime = $dateTime === null ?
            new DateTimeImmutable('now') :
            Helpers\DateTimeHelper::createImmutableFromInterface($dateTime);
    }

    /**
     * @param DateTimeZone|null $timeZone
     */
    public static function fromDateString(
        string $dateInterval,
        string $dateTime = 'now',
        $timeZone = null
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

    public function __debugInfo():  array
    {
        return [
            'now' => $this->dateTime,
        ];
    }
}
