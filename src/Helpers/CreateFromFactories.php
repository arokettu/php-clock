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
    abstract public function __construct(?DateTimeInterface $dateTime = null);

    public static function fromDateString(string $datetime, ?DateTimeZone $timeZone = null): self
    {
        return new self(new DateTimeImmutable($datetime, $timeZone));
    }

    public static function fromTimestamp(int $timestamp, ?DateTimeZone $timeZone = null): self
    {
        $dt = DateTimeImmutable::createFromFormat('U', \strval($timestamp));
        if ($timeZone) {
            $dt = $dt->setTimezone($timeZone);
        }
        return new self($dt);
    }
}
