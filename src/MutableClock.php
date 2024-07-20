<?php

declare(strict_types=1);

namespace Arokettu\Clock;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Psr\Clock\ClockInterface;

final class MutableClock implements ClockInterface
{
    use Helpers\CreateFromFactories;

    public DateTime $dateTime;

    public function __construct(DateTimeInterface|null $dateTime = null)
    {
        $this->dateTime = $dateTime ? DateTime::createFromInterface($dateTime) : new DateTime('now');
    }

    public function now(): DateTimeImmutable
    {
        return DateTimeImmutable::createFromMutable($this->dateTime);
    }

    public function set(DateTimeInterface $dateTime): self
    {
        $this->dateTime = DateTime::createFromInterface($dateTime);
        return $this;
    }

    public function setInstance(DateTime $dateTime): self
    {
        $this->dateTime = $dateTime; // no decoupling
        return $this;
    }

    // deep cloning
    public function __clone()
    {
        $this->dateTime = clone $this->dateTime;
    }

    public function __debugInfo(): array
    {
        return [
            'now' => $this->now(),
        ];
    }
}
