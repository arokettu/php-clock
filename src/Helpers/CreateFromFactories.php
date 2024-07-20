<?php

declare(strict_types=1);

namespace Arokettu\Clock\Helpers;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;

/**
 * @internal
 */
trait CreateFromFactories
{
    /**
     * @param DateTimeInterface|null $dateTime
     */
    abstract public function __construct($dateTime = null);

    /**
     * @param DateTimeZone|null $timeZone
     */
    public static function fromDateString(string $datetime, $timeZone = null): self
    {
        return new self(new DateTimeImmutable($datetime, $timeZone));
    }

    /**
     * @param int|float $timestamp
     * @param DateTimeZone|null $timeZone
     */
    public static function fromTimestamp($timestamp, $timeZone = null): self
    {
        if (is_int($timestamp)) {
            $dt = self::dtFromIntTimestamp($timestamp);
        } else {
            $dt = self::dtFromFloatTimestamp($timestamp); // also a type check
        }
        if ($timeZone !== null) {
            $dt = $dt->setTimezone($timeZone);
        }
        return new self($dt);
    }

    private static function dtFromIntTimestamp(int $timestamp): DateTimeImmutable
    {
        return DateTimeImmutable::createFromFormat('U', \strval($timestamp));
    }

    private static function dtFromFloatTimestamp(float $timestamp): DateTimeImmutable
    {
        return DateTimeImmutable::createFromFormat('U.u', sprintf('%.6F', $timestamp));
    }
}
