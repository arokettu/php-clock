<?php

/**
 * @copyright 2023 Anton Smirnov
 * @license MIT https://spdx.org/licenses/MIT.html
 */

declare(strict_types=1);

use Carbon\Carbon;
use Carbon\CarbonImmutable;

// hide Carbon startup deprecations
if (@class_exists(Carbon::class)) {
    @new Carbon();
}
if (@class_exists(CarbonImmutable::class)) {
    @new CarbonImmutable();
}
