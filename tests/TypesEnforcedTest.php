<?php

/**
 * @copyright 2023 Anton Smirnov
 * @license MIT https://spdx.org/licenses/MIT.html
 */

declare(strict_types=1);

namespace Arokettu\Clock\Tests;

use Arokettu\Clock\ShiftedClock;
use Arokettu\Clock\SystemClock;
use PHPUnit\Framework\TestCase;

final class TypesEnforcedTest extends TestCase
{
    public function testSystemClock(): void
    {
        $this->expectException(\TypeError::class);
        new SystemClock(new \stdClass());
    }

    public function testShiftedClock(): void
    {
        $this->expectException(\TypeError::class);
        new ShiftedClock(new \DateInterval('PT1S'), new \stdClass());
    }
}
