<?php

declare(strict_types=1);

namespace Arokettu\Clock;

use DateTimeImmutable;
use DateTimeInterface;
use Psr\Clock\ClockInterface;

final class StaticClock implements ClockInterface
{
    use Helpers\CreateFromFactories;

    /** @var DateTimeImmutable */
    private $dateTime;

    /**
     * @param DateTimeInterface|null $dateTime
     */
    public function __construct($dateTime = null)
    {
        $this->dateTime = $dateTime === null ?
            new DateTimeImmutable('now') :
            Helpers\DateTimeHelper::createImmutableFromInterface($dateTime);
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

    public function __debugInfo():  array
    {
        return [
            'now' => $this->dateTime,
        ];
    }
}
