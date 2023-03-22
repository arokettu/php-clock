<?php

declare(strict_types=1);

namespace Arokettu\Clock;

use Closure;
use DateTimeImmutable;
use Psr\Clock\ClockInterface;

final class CallbackClock implements ClockInterface
{
    /** @var Closure */
    private $callback;

    public function __construct(Closure $callback)
    {
        $this->callback = $callback;
    }

    public function now(): DateTimeImmutable
    {
        return ($this->callback)();
    }
}
