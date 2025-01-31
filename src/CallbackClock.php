<?php

declare(strict_types=1);

namespace Arokettu\Clock;

use Closure;
use DateTimeImmutable;
use Generator;
use Psr\Clock\ClockInterface;
use ReflectionFunction;

final class CallbackClock implements ClockInterface
{
    private Closure $callback;
    private Generator $generator;

    public function __construct(Closure $callback)
    {
        $r = new ReflectionFunction($callback);

        // if the closure creates a generator, use it
        if ($r->isGenerator()) {
            $callback = function () use ($callback): DateTimeImmutable {
                if (!isset($this->generator)) {
                    $this->generator = $callback();
                } else {
                    $this->generator->next();
                }
                return $this->generator->current();
            };
        }

        $this->callback = $callback;
    }

    public function now(): DateTimeImmutable
    {
        return ($this->callback)();
    }
}
