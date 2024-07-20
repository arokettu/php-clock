<?php

declare(strict_types=1);

namespace Arokettu\Clock\Tests;

use Arokettu\Clock\ShiftedClock;
use Arokettu\Clock\SystemClock;
use PHPUnit\Framework\TestCase;

class TypesEnforcedTest extends TestCase
{
    public function testSystemClock()
    {
        $this->expectException(\InvalidArgumentException::class);
        new SystemClock(new \stdClass());
    }

    public function testShiftedClock()
    {
        $this->expectException(\InvalidArgumentException::class);
        new ShiftedClock(new \DateInterval('PT1S'), new \stdClass());
    }
}
