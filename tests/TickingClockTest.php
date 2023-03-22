<?php

declare(strict_types=1);

namespace Arokettu\Clock\Tests;

use Arokettu\Clock\TickingClock;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use PHPUnit\Framework\TestCase;

class TickingClockTest extends TestCase
{
    public function testTime(): void
    {
        $i = \DateInterval::createFromDateString('+10 min');

        // accepts null, meaning now
        // three consecutive time generations should be t1 <= t2 <= t3
        $lowerBoundary = new \DateTimeImmutable('now');
        $clock0 = new TickingClock($i);
        $time0 = $clock0->now();
        $upperBoundary = new \DateTimeImmutable('now');

        self::assertGreaterThanOrEqual($lowerBoundary, $time0);
        self::assertLessThanOrEqual($upperBoundary, $time0);

        // tick
        $time01 = $clock0->now();
        self::assertGreaterThanOrEqual($lowerBoundary->modify('+10 min'), $time01);
        self::assertLessThanOrEqual($upperBoundary->modify('+10 min'), $time01);

        // accepts immutable
        $clock1 = new TickingClock($i, new \DateTimeImmutable('2023-01-01 12:00'));
        $this->assertEquals(new \DateTimeImmutable('2023-01-01 12:00'), $clock1->now());

        // accepts mutable
        $clock2 = new TickingClock($i, new \DateTimeImmutable('2050-07-25 16:00'));
        $this->assertEquals(new \DateTimeImmutable('2050-07-25 16:00'), $clock2->now());

        // accepts carbon
        $clock3 = new TickingClock($i, new CarbonImmutable('2000-02-03 14:32'));
        $this->assertEquals(new \DateTimeImmutable('2000-02-03 14:32'), $clock3->now());

        // accepts carbon mutable
        $clock4 = new TickingClock($i, new Carbon('2258-03-14 12:34'));
        $this->assertEquals(new \DateTimeImmutable('2258-03-14 12:34'), $clock4->now());
    }

    public function testTz(): void
    {
        $i = \DateInterval::createFromDateString('+10 min');

        $clock1 = new TickingClock($i, new \DateTime('now', new \DateTimeZone('UTC')));
        self::assertEquals('UTC', $clock1->now()->getTimezone()->getName());

        $clock2 = new TickingClock($i, new Carbon('now', new \DateTimeZone('Europe/Tallinn')));
        self::assertEquals('Europe/Tallinn', $clock2->now()->getTimezone()->getName());
    }

    public function testIntervals(): void
    {
        $intervals = [
            '+1 min',
            '+1 day',
            '+1 month - 1 week',
            '-1 year',
        ];

        foreach ($intervals as $diff) {
            $interval = \DateInterval::createFromDateString($diff);
            $time = new \DateTimeImmutable('2121-12-12');
            $clock = new TickingClock($interval, $time);

            for ($i = 0; $i < 10; $i++) {
                self::assertEquals($time, $clock->now());
                $time = $time->modify($diff);
            }
        }
    }
}
