<?php

declare(strict_types=1);

namespace Arokettu\Clock;

use DateTimeImmutable;
use DateTimeZone;
use Psr\Clock\ClockInterface;

final class SystemClock implements ClockInterface
{
    private ?DateTimeZone $timeZone;

    public function __construct(?DateTimeZone $timeZone = null)
    {
        $this->timeZone = $timeZone;
    }

    public function now(): DateTimeImmutable
    {
        return new DateTimeImmutable('now', $this->timeZone);
    }
}
