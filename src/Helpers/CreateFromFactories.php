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
    abstract public function __construct(DateTimeInterface|null $dateTime = null);

    public static function fromDateString(string $datetime, DateTimeZone|null $timeZone = null): self
    {
        return new self(new DateTimeImmutable($datetime, $timeZone));
    }

    public static function fromTimestamp(int|float $timestamp, DateTimeZone|null $timeZone = null): self
    {
        if (\method_exists(DateTimeImmutable::class, 'createFromTimestamp')) {
            // coverage is generated by PHP 8.2 where this method is not yet available
            // @codeCoverageIgnoreStart
            $dt = DateTimeImmutable::createFromTimestamp($timestamp);
            // @codeCoverageIgnoreEnd
        } elseif (\is_int($timestamp)) {
            $dt = self::dtFromIntTimestamp($timestamp);
        } else {
            $dt = self::dtFromFloatTimestamp($timestamp);
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
