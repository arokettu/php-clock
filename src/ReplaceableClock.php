<?php

declare(strict_types=1);

namespace Arokettu\Clock;

use DateTimeImmutable;
use Psr\Clock\ClockInterface;

final class ReplaceableClock implements ClockInterface
{
    private $innerClock;

    public function __construct(ClockInterface $innerClock)
    {
        $this->innerClock = $innerClock;
    }

    public function now(): DateTimeImmutable
    {
        return $this->innerClock->now();
    }

    public function getInnerClock(): ClockInterface
    {
        return $this->innerClock;
    }

    public function setInnerClock(ClockInterface $innerClock): self
    {
        $this->innerClock = $innerClock;
        return $this;
    }
}
