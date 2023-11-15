<?php

namespace Arokettu\Clock\Tests;

use Arokettu\Clock\MutableClock;
use Arokettu\Clock\OffsetClock;
use Arokettu\Clock\ShiftedClock;
use Arokettu\Clock\SystemClock;
use PHPUnit\Framework\TestCase;

class OffsetClockTest extends TestCase
{
    public function testWithMutableClock()
    {
        $innerClock = MutableClock::fromDateString('2000-01-01 00:00 Z');
        $outerClock = OffsetClock::fromDateString($innerClock, '+1 year +1 day');

        self::assertEquals('2001-01-02T00:00:00+00:00', $outerClock->now()->format('c'));

        $outerClock->getInnerClock()->dateTime->modify('+1 month');

        self::assertEquals('2001-02-02T00:00:00+00:00', $outerClock->now()->format('c'));
    }

    public function testWithShiftedClock()
    {
        $interval = \DateInterval::createFromDateString('-5 min');

        $clock1 = new ShiftedClock($interval);
        $clock2 = new OffsetClock(new SystemClock(), $interval);

        $t1 = $clock1->now();
        $t2 = $clock2->now();
        $t3 = $clock1->now();
        $t4 = $clock2->now();

        self::assertGreaterThanOrEqual($t1, $t2);
        self::assertGreaterThanOrEqual($t2, $t3);
        self::assertGreaterThanOrEqual($t3, $t4);
    }
}
