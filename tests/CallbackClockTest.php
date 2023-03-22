<?php

declare(strict_types=1);

namespace Arokettu\Clock\Tests;

use Arokettu\Clock\CallbackClock;
use PHPUnit\Framework\TestCase;

final class CallbackClockTest extends TestCase
{
    public function testTime()
    {
        $innerTime = new \DateTimeImmutable('1990-01-01 01:00', new \DateTimeZone('UTC'));
        $outerTime = $innerTime;

        $clock = new CallbackClock(function () use (&$innerTime) {
            return $innerTime = $innerTime->modify('+1 hour');
        });

        for ($i = 0; $i < 10; $i++) {
            $outerTime = $outerTime->modify('+1 hour');

            self::assertEquals($outerTime, $clock->now());
        }
    }

    public function testIncorrectReturn()
    {
        $this->expectException(\TypeError::class);
        $clock = new CallbackClock(function () {
            return new \DateTime();
        });
        $clock->now();
    }
}
