<?php

declare(strict_types=1);

namespace Arokettu\Clock\Tests;

use Arokettu\Clock\CallbackClock;
use PHPUnit\Framework\TestCase;

final class CallbackClockTest extends TestCase
{
    public function testTimeWithClosure(): void
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

    public function testTimeWithGenerator(): void
    {
        $innerTime = new \DateTimeImmutable('1990-01-01 01:00', new \DateTimeZone('UTC'));
        $outerTime = $innerTime;

        $clock = new CallbackClock(function () use ($innerTime) {
            while (true) {
                yield $innerTime = $innerTime->modify('+1 hour');
            }
        });

        for ($i = 0; $i < 10; $i++) {
            $outerTime = $outerTime->modify('+1 hour');

            self::assertEquals($outerTime, $clock->now());
        }
    }

    public function testIncorrectReturn(): void
    {
        $this->expectException(\TypeError::class);
        $clock = new CallbackClock(function () {
            return new \DateTime();
        });
        $clock->now();
    }

    public function testIncorrectYield(): void
    {
        $this->expectException(\TypeError::class);

        $innerGenerator = function () {
            while (true) {
                yield new \DateTimeImmutable();
            }
        };
        $outerGenerator = function () use ($innerGenerator) {
            yield $innerGenerator();
        };

        $clock = new CallbackClock($outerGenerator);
        $clock->now();
    }

    public function testCorrectYield(): void
    {
        $innerGenerator = function () {
            while (true) {
                yield new \DateTimeImmutable();
            }
        };
        $outerGenerator = function () use ($innerGenerator) {
            yield from $innerGenerator();
        };

        $clock = new CallbackClock($outerGenerator);

        for ($i = 0; $i < 10; $i++) {
            self::assertInstanceOf(\DateTimeImmutable::class, $clock->now());
        }
    }
}
