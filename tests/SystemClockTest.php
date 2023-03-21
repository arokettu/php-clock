<?php

declare(strict_types=1);

namespace Arokettu\Clock\Tests;

use Arokettu\Clock\SystemClock;
use PHPUnit\Framework\TestCase;

class SystemClockTest extends TestCase
{
    public function testNative()
    {
        $clock = new SystemClock();

        // three consecutive time generations should be t1 <= t2 <= t3
        $lowerBoundary = new \DateTimeImmutable('now');
        $time = $clock->now();
        $upperBoundary = new \DateTimeImmutable('now');

        self::assertGreaterThanOrEqual($lowerBoundary, $time);
        self::assertLessThanOrEqual($upperBoundary, $time);
    }

    public function testTz()
    {
        $clock = new SystemClock(new \DateTimeZone('UTC'));
        self::assertEquals('UTC', $clock->now()->getTimezone()->getName());

        $clock = new SystemClock(new \DateTimeZone('Europe/Tallinn'));
        self::assertEquals('Europe/Tallinn', $clock->now()->getTimezone()->getName());
    }
}
