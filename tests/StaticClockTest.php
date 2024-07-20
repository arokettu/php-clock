<?php

declare(strict_types=1);

namespace Arokettu\Clock\Tests;

use Arokettu\Clock\StaticClock;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use PHPUnit\Framework\TestCase;

class StaticClockTest extends TestCase
{
    public function testTime(): void
    {
        // accepts null, meaning now
        // three consecutive time generations should be t1 <= t2 <= t3
        $lowerBoundary = new \DateTimeImmutable('now');
        $clock0 = new StaticClock();
        $time0 = $clock0->now();
        $upperBoundary = new \DateTimeImmutable('now');

        self::assertGreaterThanOrEqual($lowerBoundary, $time0);
        self::assertLessThanOrEqual($upperBoundary, $time0);

        // accepts immutable
        $clock1 = new StaticClock(new \DateTimeImmutable('2023-01-01 12:00'));
        $this->assertEquals(new \DateTimeImmutable('2023-01-01 12:00'), $clock1->now());

        // accepts mutable
        $clock2 = new StaticClock(new \DateTimeImmutable('2050-07-25 16:00'));
        $this->assertEquals(new \DateTimeImmutable('2050-07-25 16:00'), $clock2->now());

        // accepts carbon
        $clock3 = new StaticClock(new CarbonImmutable('2000-02-03 14:32'));
        $this->assertEquals(new \DateTimeImmutable('2000-02-03 14:32'), $clock3->now());

        // accepts carbon mutable
        $clock4 = new StaticClock(new Carbon('2258-03-14 12:34'));
        $this->assertEquals(new \DateTimeImmutable('2258-03-14 12:34'), $clock4->now());
    }

    public function testModify(): void
    {
        $clock = new StaticClock();

        // accepts immutable
        $clock->set(new \DateTimeImmutable('2023-01-01 12:00'));
        $this->assertEquals(new \DateTimeImmutable('2023-01-01 12:00'), $clock->now());

        // accepts mutable
        $clock->set(new \DateTime('2050-07-25 16:00'));
        $this->assertEquals(new \DateTimeImmutable('2050-07-25 16:00'), $clock->now());

        // accepts carbon
        $clock->set(new CarbonImmutable('2000-02-03 14:32'));
        $this->assertEquals(new \DateTimeImmutable('2000-02-03 14:32'), $clock->now());

        // accepts carbon mutable
        $clock->set(new Carbon('2258-03-14 12:34'));
        $this->assertEquals(new \DateTimeImmutable('2258-03-14 12:34'), $clock->now());
    }

    public function testTz(): void
    {
        $clock1 = new StaticClock(new \DateTime('now', new \DateTimeZone('UTC')));
        self::assertEquals('UTC', $clock1->now()->getTimezone()->getName());

        $clock2 = new StaticClock(new Carbon('now', new \DateTimeZone('Europe/Tallinn')));
        self::assertEquals('Europe/Tallinn', $clock2->now()->getTimezone()->getName());
    }

    public function testFactory(): void
    {
        $clock1 = StaticClock::fromDateString('2003-03-20 15:37');
        self::assertEquals(new \DateTime('2003-03-20 15:37'), $clock1->now());

        $clock2 = StaticClock::fromDateString('2003-03-20 15:37', new \DateTimeZone('Africa/Lagos'));
        self::assertEquals(new \DateTime('2003-03-20 15:37 Africa/Lagos'), $clock2->now());

        $tz = date_default_timezone_get();
        date_default_timezone_set('UTC');
        $clock3 = StaticClock::fromTimestamp(1698701296);
        self::assertEquals('2023-10-30T21:28:16+00:00', $clock3->now()->format('c'));
        date_default_timezone_set($tz);

        $clock4 = StaticClock::fromTimestamp(1698701296, new \DateTimeZone('Europe/Tallinn'));
        self::assertEquals('2023-10-30T23:28:16+02:00', $clock4->now()->format('c'));

        $clock5 = StaticClock::fromTimestamp(1698701296.8452);
        self::assertEquals('2023-10-30T21:28:16.845200+00:00', $clock5->now()->format('Y-m-d\TH:i:s.uP'));

        $clock6 = StaticClock::fromTimestamp(1698701296.8);
        self::assertEquals('2023-10-30T21:28:16.800000+00:00', $clock6->now()->format('Y-m-d\TH:i:s.uP'));

        $clock7 = StaticClock::fromTimestamp(1698701296.000008);
        self::assertEquals('2023-10-30T21:28:16.000008+00:00', $clock7->now()->format('Y-m-d\TH:i:s.uP'));
    }

    public function testDebugData(): void
    {
        self::assertEquals([
            'now' => new \DateTimeImmutable('@1698701296'),
        ], StaticClock::fromTimestamp(1698701296)->__debugInfo());
    }
}
