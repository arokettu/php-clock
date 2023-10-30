<?php

declare(strict_types=1);

namespace Arokettu\Clock;

use DateTimeImmutable;
use Psr\Clock\ClockInterface;

/**
 * @template T of ClockInterface
 */
final class RoundingClock implements ClockInterface
{
    public const ROUND_MICROSECONDS = 0;
    public const ROUND_MILLISECONDS = 1;
    public const ROUND_SECONDS = 2;
    public const ROUND_MINUTES = 3;
    public const ROUND_HOURS = 4;
    public const ROUND_DAYS = 5;
    public const ROUND_WEEKS = 6;
    public const ROUND_MONTHS = 7;
    public const ROUND_YEARS = 8;
    public const ROUND_ISO_YEARS = 9;

    /**
     * @param T $innerClock
     */
    public function __construct(
        private ClockInterface $innerClock,
        private int $rounding,
    ) {}

    public function now(): DateTimeImmutable
    {
        $now = $this->innerClock->now();

        // round mcs: noop
        if ($this->rounding <= self::ROUND_MICROSECONDS) {
            return $now;
        }

        // round time
        if ($this->rounding <= self::ROUND_HOURS) {
            $ms = $this->rounding <= self::ROUND_MILLISECONDS ? \intval($now->format('v')) : 0;
            $s  = $this->rounding <= self::ROUND_SECONDS ? \intval($now->format('s')) : 0;
            $m  = $this->rounding <= self::ROUND_MINUTES ? \intval($now->format('i')) : 0;
            $h  = \intval($now->format('H'));

            return $now->setTime($h, $m, $s, $ms * 1000);
        }

        $now = $now->setTime(0, 0, 0, 0);

        // if days, we're done
        if ($this->rounding <= self::ROUND_DAYS) {
            return $now;
        }

        if ($this->rounding === self::ROUND_WEEKS || $this->rounding === self::ROUND_ISO_YEARS) {
            $w = $this->rounding <= self::ROUND_WEEKS ? \intval($now->format('W')) : 1;
            $y = \intval($now->format('o'));

            return $now->setISODate($y, $w);
        }

        $m = $this->rounding <= self::ROUND_MONTHS ? \intval($now->format('n')) : 1;
        $y = \intval($now->format('Y'));

        return $now->setDate($y, $m, 1);
    }

    /**
     * @return T
     */
    public function getInnerClock(): ClockInterface
    {
        return $this->innerClock;
    }

    public static function toMicroseconds(ClockInterface $innerClock): self
    {
        return new self($innerClock, self::ROUND_MICROSECONDS);
    }

    public static function toMilliseconds(ClockInterface $innerClock): self
    {
        return new self($innerClock, self::ROUND_MILLISECONDS);
    }

    public static function toSeconds(ClockInterface $innerClock): self
    {
        return new self($innerClock, self::ROUND_SECONDS);
    }

    public static function toMinutes(ClockInterface $innerClock): self
    {
        return new self($innerClock, self::ROUND_MINUTES);
    }

    public static function toHours(ClockInterface $innerClock): self
    {
        return new self($innerClock, self::ROUND_HOURS);
    }

    public static function toDays(ClockInterface $innerClock): self
    {
        return new self($innerClock, self::ROUND_DAYS);
    }

    public static function toWeeks(ClockInterface $innerClock): self
    {
        return new self($innerClock, self::ROUND_WEEKS);
    }

    public static function toMonths(ClockInterface $innerClock): self
    {
        return new self($innerClock, self::ROUND_MONTHS);
    }

    public static function toYears(ClockInterface $innerClock): self
    {
        return new self($innerClock, self::ROUND_YEARS);
    }

    public static function toIsoYears(ClockInterface $innerClock): self
    {
        return new self($innerClock, self::ROUND_ISO_YEARS);
    }
}
