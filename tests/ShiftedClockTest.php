<?php

declare(strict_types=1);

namespace Arokettu\Clock\Tests;

use Arokettu\Clock\ShiftedClock;
use PHPUnit\Framework\TestCase;

class ShiftedClockTest extends TestCase
{
    public function testTime(): void
    {
        $clock = new ShiftedClock(\DateInterval::createFromDateString('+1 day'));

        // three consecutive time generations should be t1 <= t2 <= t3
        $lowerBoundary = new \DateTimeImmutable('+1 day');
        $time = $clock->now();
        $upperBoundary = new \DateTimeImmutable('+1 day');

        self::assertGreaterThanOrEqual($lowerBoundary, $time);
        self::assertLessThanOrEqual($upperBoundary, $time);
    }

    public function testFactory(): void
    {
        $clock = ShiftedClock::fromDateString('+1 day');

        // three consecutive time generations should be t1 <= t2 <= t3
        $lowerBoundary = new \DateTimeImmutable('+1 day');
        $time = $clock->now();
        $upperBoundary = new \DateTimeImmutable('+1 day');

        self::assertGreaterThanOrEqual($lowerBoundary, $time);
        self::assertLessThanOrEqual($upperBoundary, $time);
    }

    public function testTz(): void
    {
        $shift = \DateInterval::createFromDateString('-1 year');

        $clock1 = new ShiftedClock($shift, new \DateTimeZone('UTC'));
        self::assertEquals('UTC', $clock1->now()->getTimezone()->getName());

        $clock2 = new ShiftedClock($shift, new \DateTimeZone('Europe/Tallinn'));
        self::assertEquals('Europe/Tallinn', $clock2->now()->getTimezone()->getName());
    }

    public function testTzFactory(): void
    {
        $clock1 = ShiftedClock::fromDateString('-1 year', new \DateTimeZone('UTC'));
        self::assertEquals('UTC', $clock1->now()->getTimezone()->getName());

        $clock2 = ShiftedClock::fromDateString('-1 year', new \DateTimeZone('Europe/Tallinn'));
        self::assertEquals('Europe/Tallinn', $clock2->now()->getTimezone()->getName());
    }
}
