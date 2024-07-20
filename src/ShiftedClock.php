<?php

declare(strict_types=1);

namespace Arokettu\Clock;

use DateInterval;
use DateTimeImmutable;
use DateTimeZone;
use InvalidArgumentException;
use Psr\Clock\ClockInterface;

final class ShiftedClock implements ClockInterface
{
    /** @var DateInterval */
    private $dateInterval;
    /** @var DateTimeZone|null */
    private $timeZone;

    /**
     * @param DateTimeZone|null $timeZone
     */
    public function __construct(DateInterval $dateInterval, $timeZone = null)
    {
        if ($timeZone !== null && !$timeZone instanceof DateTimeZone) {
            throw new InvalidArgumentException('$timeZone must be an instance of DateTimeZone or null');
        }

        $this->dateInterval = Helpers\DateTimeHelper::cloneInterval($dateInterval); // decouple mutable object
        $this->timeZone = $timeZone;
    }

    /**
     * @param DateTimeZone|null $timeZone
     */
    public static function fromDateString(string $dateInterval, $timeZone = null): self
    {
        return new self(DateInterval::createFromDateString($dateInterval), $timeZone);
    }

    public function now(): DateTimeImmutable
    {
        return (new DateTimeImmutable('now', $this->timeZone))->add($this->dateInterval);
    }
}
