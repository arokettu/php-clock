<?php

/**
 * @copyright 2023 Anton Smirnov
 * @license MIT https://spdx.org/licenses/MIT.html
 */

declare(strict_types=1);

namespace Arokettu\Clock;

use DateTimeImmutable;
use Psr\Clock\ClockInterface;

final class ReplaceableClock implements ClockInterface
{
    public function __construct(private ClockInterface $innerClock)
    {
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
