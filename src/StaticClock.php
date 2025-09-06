<?php

/**
 * @copyright 2023 Anton Smirnov
 * @license MIT https://spdx.org/licenses/MIT.html
 */

declare(strict_types=1);

namespace Arokettu\Clock;

use DateTimeImmutable;
use DateTimeInterface;
use Psr\Clock\ClockInterface;

final class StaticClock implements ClockInterface
{
    use Helpers\CreateFromFactories;

    private DateTimeImmutable $dateTime;

    public function __construct(DateTimeInterface|null $dateTime = null)
    {
        $this->dateTime = $dateTime ?
            DateTimeImmutable::createFromInterface($dateTime) :
            new DateTimeImmutable('now');
    }

    public function now(): DateTimeImmutable
    {
        return $this->dateTime;
    }

    public function set(DateTimeInterface $dateTime): self
    {
        $this->dateTime = DateTimeImmutable::createFromInterface($dateTime);
        return $this;
    }

    public function __debugInfo(): array
    {
        return [
            'now' => $this->dateTime,
        ];
    }
}
