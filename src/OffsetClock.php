<?php

declare(strict_types=1);

namespace Arokettu\Clock;

use DateInterval;
use DateTimeImmutable;
use Psr\Clock\ClockInterface;

/**
 * @template T of ClockInterface
 */
final class OffsetClock implements ClockInterface
{
    private DateInterval $dateInterval;

    /**
     * @param T $innerClock
     */
    public function __construct(
        private ClockInterface $innerClock,
        DateInterval $dateInterval,
    ) {
        $this->dateInterval = clone $dateInterval; // decouple mutable object
    }

    public static function fromDateString(ClockInterface $innerClock, string $dateInterval): self
    {
        return new self($innerClock, DateInterval::createFromDateString($dateInterval));
    }

    public function now(): DateTimeImmutable
    {
        return $this->innerClock->now()->add($this->dateInterval);
    }

    /**
     * @return T
     */
    public function getInnerClock(): ClockInterface
    {
        return $this->innerClock;
    }
}
