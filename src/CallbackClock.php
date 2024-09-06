<?php

declare(strict_types=1);

namespace Arokettu\Clock;

use Closure;
use DateTimeImmutable;
use Psr\Clock\ClockInterface;
use ReflectionFunction;

final class CallbackClock implements ClockInterface
{
    private Closure $callback;

    public function __construct(Closure $callback)
    {
        $r = new ReflectionFunction($callback);

        // if the closure creates a generator, use it
        if ($r->isGenerator()) {
            $this->callback = function () use (&$g, $callback): DateTimeImmutable {
                if ($g === null) {
                    $g = $callback();
                } else {
                    $g->next();
                }
                return $g->current();
            };
        } else {
            $this->callback = $callback;
        }
    }

    public function now(): DateTimeImmutable
    {
        return ($this->callback)();
    }
}
