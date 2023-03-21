<?php

namespace Arokettu\Clock;

use DateTimeImmutable;
use DateTimeInterface;
use Psr\Clock\ClockInterface;

final class FixedClock implements ClockInterface
{
    /** @var DateTimeImmutable */
    private $dateTime;

    public function __construct(DateTimeInterface $dateTime)
    {
        $this->dateTime = Helpers\DateTimeHelper::createFromInterface($dateTime);
    }

    public function now(): DateTimeImmutable
    {
        return $this->dateTime;
    }
}
