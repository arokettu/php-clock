<?php

declare(strict_types=1);

namespace Arokettu\Clock\Tests;

use Arokettu\Clock\MutableClock;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use PHPUnit\Framework\TestCase;

class MutableClockTest extends TestCase
{
    public function testTime()
    {
        // accepts null, meaning now
        // three consecutive time generations should be t1 <= t2 <= t3
        $lowerBoundary = new \DateTimeImmutable('now');
        $clock0 = new MutableClock();
        $time0 = $clock0->now();
        $upperBoundary = new \DateTimeImmutable('now');

        self::assertGreaterThanOrEqual($lowerBoundary, $time0);
        self::assertLessThanOrEqual($upperBoundary, $time0);

        // accepts immutable
        $clock1 = new MutableClock(new \DateTimeImmutable('2023-01-01 12:00'));
        $this->assertEquals(new \DateTimeImmutable('2023-01-01 12:00'), $clock1->now());

        // accepts mutable
        $clock2 = new MutableClock(new \DateTime('2050-07-25 16:00'));
        $this->assertEquals(new \DateTimeImmutable('2050-07-25 16:00'), $clock2->now());

        if (class_exists(CarbonImmutable::class)) {
            // accepts carbon
            $clock3 = new MutableClock(new CarbonImmutable('2000-02-03 14:32'));
            $this->assertEquals(new \DateTimeImmutable('2000-02-03 14:32'), $clock3->now());
        }

        // accepts carbon mutable
        $clock4 = new MutableClock(new Carbon('2258-03-14 12:34'));
        $this->assertEquals(new \DateTimeImmutable('2258-03-14 12:34'), $clock4->now());
    }

    public function testTz()
    {
        $clock1 = new MutableClock(new \DateTime('now', new \DateTimeZone('UTC')));
        self::assertEquals('UTC', $clock1->now()->getTimezone()->getName());

        $clock2 = new MutableClock(new Carbon('now', new \DateTimeZone('Europe/Tallinn')));
        self::assertEquals('Europe/Tallinn', $clock2->now()->getTimezone()->getName());
    }

    public function testModifyByValue()
    {
        $clock = new MutableClock();

        // accepts immutable
        $clock->set(new \DateTimeImmutable('2023-01-01 12:00'));
        $this->assertEquals(new \DateTimeImmutable('2023-01-01 12:00'), $clock->now());

        // accepts mutable
        $clock->set(new \DateTime('2050-07-25 16:00'));
        $this->assertEquals(new \DateTimeImmutable('2050-07-25 16:00'), $clock->now());

        if (class_exists(CarbonImmutable::class)) {
            // accepts carbon
            $clock->set(new CarbonImmutable('2000-02-03 14:32'));
            $this->assertEquals(new \DateTimeImmutable('2000-02-03 14:32'), $clock->now());
        }

        // accepts carbon mutable
        $clock->set(new Carbon('2258-03-14 12:34'));
        $this->assertEquals(new \DateTimeImmutable('2258-03-14 12:34'), $clock->now());

        // setting by value creates a new dt instance
        $dateTime = new \DateTime();
        $clock = new MutableClock($dateTime);
        $dateTime->modify('+3 weeks');

        self::assertNotEquals($dateTime, $clock->now());
    }

    public function testModifyByReference()
    {
        $clock = new MutableClock();

        // accepts mutable
        $clock->setInstance(new \DateTime('2050-07-25 16:00'));
        $this->assertEquals(new \DateTimeImmutable('2050-07-25 16:00'), $clock->now());

        // accepts carbon mutable
        $clock->setInstance(new Carbon('2258-03-14 12:34'));
        $this->assertEquals(new \DateTimeImmutable('2258-03-14 12:34'), $clock->now());

        // accepts mutable
        $clock->dateTime = new \DateTime('2050-07-25 16:00');
        $this->assertEquals(new \DateTimeImmutable('2050-07-25 16:00'), $clock->now());

        // accepts carbon mutable
        $clock->dateTime = new Carbon('2258-03-14 12:34');
        $this->assertEquals(new \DateTimeImmutable('2258-03-14 12:34'), $clock->now());

        // setting by value creates a new dt instance
        $dateTime = new \DateTime();
        $clock = new MutableClock($dateTime);
        $dateTime->modify('+3 weeks');

        self::assertNotEquals($dateTime, $clock->now());
    }

    public function testModifyByReferenceOnlyMutable()
    {
        $this->expectException(\TypeError::class);
        $clock = new MutableClock();
        $clock->setInstance(new \DateTimeImmutable('2023-01-01 12:00'));
    }

    public function testModifyByReferenceOnlyMutableCarbon()
    {
        if (!class_exists(CarbonImmutable::class)) {
            $this->markTestSkipped();
        }

        $this->expectException(\TypeError::class);
        $clock = new MutableClock();
        $clock->setInstance(new CarbonImmutable('2000-02-03 14:32'));
    }

    public function testModifyInnerObject()
    {
        $clock = new MutableClock(new \DateTime('2112-12-12'));

        $clock->dateTime->modify('+3 weeks');

        self::assertEquals(
            (new \DateTimeImmutable('2112-12-12'))->modify('+3 weeks'),
            $clock->now()
        );
    }

    public function testDeepCloning()
    {
        $clock1 = new MutableClock();
        $clock2 = clone $clock1;

        $clock1->dateTime->modify('+3 weeks');

        self::assertNotEquals($clock1->now(), $clock2->now());
    }
}
