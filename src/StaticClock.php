<?php

declare(strict_types=1);

namespace Arokettu\Clock;

use DateTimeImmutable;
use DateTimeInterface;
use Psr\Clock\ClockInterface;

final class StaticClock implements ClockInterface
{
    private DateTimeImmutable $dateTime;

    public function __construct(?DateTimeInterface $dateTime = null)
    {
        $this->dateTime = $dateTime ?
            Helpers\DateTimeHelper::createImmutableFromInterface($dateTime) :
            new DateTimeImmutable('now');
    }

    public function now(): DateTimeImmutable
    {
        return $this->dateTime;
    }

    public function set(DateTimeInterface $dateTime): self
    {
        $this->dateTime = Helpers\DateTimeHelper::createImmutableFromInterface($dateTime);
        return $this;
    }
}
