<?php

declare(strict_types=1);

namespace Arokettu\Clock\Tests;

use Arokettu\Clock\RoundingClock;
use Arokettu\Clock\StaticClock;
use PHPUnit\Framework\TestCase;

class RoundingClockTest extends TestCase
{
    public function testRounding()
    {
        $c = new StaticClock(new \DateTimeImmutable('2023-04-05 03:26:08.012340 UTC'));
        $f = "Y-m-d\\TH:i:s.uP"; // like RFC3339_EXTENDED but with microseconds

        $mcs = new RoundingClock($c, RoundingClock::ROUND_MICROSECONDS);
        self::assertEquals('2023-04-05T03:26:08.012340+00:00', $mcs->now()->format($f));

        $ms = new RoundingClock($c, RoundingClock::ROUND_MILLISECONDS);
        self::assertEquals('2023-04-05T03:26:08.012000+00:00', $ms->now()->format($f));

        $s = new RoundingClock($c, RoundingClock::ROUND_SECONDS);
        self::assertEquals('2023-04-05T03:26:08.000000+00:00', $s->now()->format($f));

        $min = new RoundingClock($c, RoundingClock::ROUND_MINUTES);
        self::assertEquals('2023-04-05T03:26:00.000000+00:00', $min->now()->format($f));

        $h = new RoundingClock($c, RoundingClock::ROUND_HOURS);
        self::assertEquals('2023-04-05T03:00:00.000000+00:00', $h->now()->format($f));

        $d = new RoundingClock($c, RoundingClock::ROUND_DAYS);
        self::assertEquals('2023-04-05T00:00:00.000000+00:00', $d->now()->format($f));

        $w = new RoundingClock($c, RoundingClock::ROUND_WEEKS);
        self::assertEquals('2023-04-03T00:00:00.000000+00:00', $w->now()->format($f)); // 3 was Monday

        $mon = new RoundingClock($c, RoundingClock::ROUND_MONTHS);
        self::assertEquals('2023-04-01T00:00:00.000000+00:00', $mon->now()->format($f));

        $y = new RoundingClock($c, RoundingClock::ROUND_YEARS);
        self::assertEquals('2023-01-01T00:00:00.000000+00:00', $y->now()->format($f));

        $yIso = new RoundingClock($c, RoundingClock::ROUND_ISO_YEARS);
        self::assertEquals('2023-01-02T00:00:00.000000+00:00', $yIso->now()->format($f)); // Jan 2 was Monday
    }
}
