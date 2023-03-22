<?php

declare(strict_types=1);

namespace Arokettu\Clock;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use InvalidArgumentException;
use Psr\Clock\ClockInterface;

/**
 * @property DateTime $dateTime
 */
final class MutableClock implements ClockInterface
{
    /** @var DateTime */
    private $dateTime;

    public function __construct(DateTimeInterface $dateTime = null)
    {
        $this->dateTime = $dateTime ?
            Helpers\DateTimeHelper::createMutableFromInterface($dateTime) :
            new DateTime('now');
    }

    public function now(): DateTimeImmutable
    {
        return DateTimeImmutable::createFromMutable($this->dateTime);
    }

    public function set(DateTimeInterface $dateTime): self
    {
        $this->dateTime = Helpers\DateTimeHelper::createMutableFromInterface($dateTime);
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

    public function __get(string $name)
    {
        if ($name === 'dateTime') {
            return $this->dateTime;
        }

        throw new InvalidArgumentException('No such field: ' . $name); // @codeCoverageIgnore
    }

    public function __set(string $name, $value)
    {
        if ($name === 'dateTime') {
            $this->setInstance($value);
            return;
        }

        throw new InvalidArgumentException('No such field: ' . $name); // @codeCoverageIgnore
    }
}
