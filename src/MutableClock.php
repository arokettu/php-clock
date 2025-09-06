<?php

/**
 * @copyright 2023 Anton Smirnov
 * @license MIT https://spdx.org/licenses/MIT.html
 */

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
    use Helpers\CreateFromFactories;

    /** @var DateTime */
    private $dateTime;

    /**
     * @param DateTimeInterface|null $dateTime
     */
    public function __construct($dateTime = null)
    {
        $this->dateTime = $dateTime === null ?
            new DateTime('now') :
            Helpers\DateTimeHelper::createMutableFromInterface($dateTime);
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

    /**
     * @return mixed
     */
    public function __get(string $name)
    {
        if ($name === 'dateTime') {
            return $this->dateTime;
        }

        throw new InvalidArgumentException('No such field: ' . $name); // @codeCoverageIgnore
    }

    /**
     * @param mixed $value
     */
    public function __set(string $name, $value)
    {
        if ($name === 'dateTime') {
            $this->setInstance($value);
            return;
        }

        throw new InvalidArgumentException('No such field: ' . $name); // @codeCoverageIgnore
    }

    public function __debugInfo(): array
    {
        return [
            'now' => $this->now(),
        ];
    }
}
