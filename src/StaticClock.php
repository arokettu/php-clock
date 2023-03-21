<?php

declare(strict_types=1);

namespace Arokettu\Clock;

use DateTimeImmutable;
use DateTimeInterface;
use Psr\Clock\ClockInterface;

final class StaticClock implements ClockInterface
{
    /** @var DateTimeImmutable */
    private $dateTime;

    public function __construct(DateTimeInterface $dateTime)
    {
        $this->dateTime = Helpers\DateTimeHelper::createImmutableFromInterface($dateTime);
    }

    public function now(): DateTimeImmutable
    {
        return $this->dateTime;
    }

    public function set(DateTimeInterface $dateTime)
    {
        $this->dateTime = Helpers\DateTimeHelper::createImmutableFromInterface($dateTime);
    }
}
