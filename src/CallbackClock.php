<?php

declare(strict_types=1);

namespace Arokettu\Clock;

use Closure;
use DateTimeImmutable;
use Generator;
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
        $value = ($this->callback)();

        // if the closure creates a generator, use it
        if ($value instanceof Generator) {
            $this->callback = function () use ($value) {
                $date = $value->current();
                $value->next();
                return $date;
            };

            return $this->now();
        }

        return $value;
    }
}
