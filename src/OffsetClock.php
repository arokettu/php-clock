<?php

/**
 * @copyright 2023 Anton Smirnov
 * @license MIT https://spdx.org/licenses/MIT.html
 */

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
    /** @var T */
    private $innerClock;
    /** @var DateInterval */
    private $dateInterval;

    /**
     * @param T $innerClock
     */
    public function __construct(ClockInterface $innerClock, DateInterval $dateInterval)
    {
        $this->innerClock = $innerClock;
        $this->dateInterval = Helpers\DateTimeHelper::cloneInterval($dateInterval); // decouple mutable object
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
