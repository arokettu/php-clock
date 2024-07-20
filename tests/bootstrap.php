<?php

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
