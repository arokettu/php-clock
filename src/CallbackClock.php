<?php

declare(strict_types=1);

namespace Arokettu\Clock;

use Closure;
use DateTimeImmutable;
use Psr\Clock\ClockInterface;
use ReflectionFunction;

final class CallbackClock implements ClockInterface
{
    /** @var Closure */
    private $callback;

    public function __construct(Closure $callback)
    {
        $r = new ReflectionFunction($callback);

        // if the closure creates a generator, use it
        if ($r->isGenerator()) {
            $g = $callback();

            $this->callback = function () use ($g): DateTimeImmutable {
                $date = $g->current();
                $g->next();
                return $date;
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
