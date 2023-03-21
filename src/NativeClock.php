<?php

namespace Arokettu\Clock;

use DateTimeImmutable;
use DateTimeZone;
use Psr\Clock\ClockInterface;

final class NativeClock implements ClockInterface
{
    /** @var DateTimeZone|null */
    private $timeZone;

    public function __construct(DateTimeZone $timeZone = null)
    {
        $this->timeZone = $timeZone;
    }

    public function now(): DateTimeImmutable
    {
        return new DateTimeImmutable('new', $this->timeZone);
    }
}
