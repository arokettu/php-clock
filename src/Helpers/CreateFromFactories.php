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
     * @param DateTimeZone|null $timeZone
     */
    public static function fromTimestamp(int $timestamp, $timeZone = null): self
    {
        $dt = DateTimeImmutable::createFromFormat('U', \strval($timestamp));
        if ($timeZone !== null) {
            $dt = $dt->setTimezone($timeZone);
        }
        return new self($dt);
    }
}
