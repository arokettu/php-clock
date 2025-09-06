<?php

/**
 * @copyright 2023 Anton Smirnov
 * @license MIT https://spdx.org/licenses/MIT.html
 */

declare(strict_types=1);

namespace Arokettu\Clock\Tests;

use Arokettu\Clock\ReplaceableClock;
use Arokettu\Clock\StaticClock;
use Arokettu\Clock\SystemClock;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class ReplaceableClockTest extends TestCase
{
    public function testClockReplacement()
    {
        $clock = new ReplaceableClock(new SystemClock());

        // works as SystemClock
        $lowerBoundary = new DateTimeImmutable('now');
        $time = $clock->now();
        $upperBoundary = new DateTimeImmutable('now');

        self::assertGreaterThanOrEqual($lowerBoundary, $time);
        self::assertLessThanOrEqual($upperBoundary, $time);
        self::assertInstanceOf(SystemClock::class, $clock->getInnerClock());

        $clock->setInnerClock(new StaticClock($staticTime = new DateTimeImmutable()));

        self::assertEquals($staticTime, $clock->now());
        self::assertInstanceOf(StaticClock::class, $clock->getInnerClock());
    }
}
