<?php

declare(strict_types=1);

namespace Arokettu\Clock;

use Arokettu\DateTime\DateTimeTruncate;
use DateTimeImmutable;
use Psr\Clock\ClockInterface;

/**
 * @template T of ClockInterface
 */
final class RoundingClock implements ClockInterface
{
    public const ROUND_MICROSECONDS = DateTimeTruncate::TO_MICROSECONDS;
    public const ROUND_MILLISECONDS = DateTimeTruncate::TO_MILLISECONDS;
    public const ROUND_SECONDS = DateTimeTruncate::TO_SECONDS;
    public const ROUND_MINUTES = DateTimeTruncate::TO_MINUTES;
    public const ROUND_HOURS = DateTimeTruncate::TO_HOURS;
    public const ROUND_DAYS = DateTimeTruncate::TO_DAYS;
    public const ROUND_WEEKS = DateTimeTruncate::TO_WEEKS;
    public const ROUND_MONTHS = DateTimeTruncate::TO_MONTHS;
    public const ROUND_YEARS = DateTimeTruncate::TO_YEARS;
    public const ROUND_ISO_YEARS = DateTimeTruncate::TO_ISO_YEARS;

    /**
     * @param T $innerClock
     */
    public function __construct(
        private ClockInterface $innerClock,
        private int $rounding,
    ) {}

    public function now(): DateTimeImmutable
    {
        return DateTimeTruncate::truncate($this->innerClock->now(), $this->rounding);
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
