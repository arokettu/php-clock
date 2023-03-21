<?php

declare(strict_types=1);

namespace Arokettu\Clock\Helpers;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use LogicException;

final class DateTimeHelper
{
    public static function createImmutableFromInterface(DateTimeInterface $dateTime): DateTimeImmutable
    {
        if ($dateTime instanceof DateTimeImmutable) {
            return $dateTime;
        }

        if ($dateTime instanceof DateTime) {
            return DateTimeImmutable::createFromMutable($dateTime);
        }

        // just in case DateTimeInterface gets instantiable
        if (method_exists(DateTimeImmutable::class, 'createFromInterface')) {
            return DateTimeImmutable::createFromInterface($dateTime);
        }

        throw new LogicException(
            '$dateTime is DateTimeInterface but neither DateTime nor DateTimeImmutable and ' .
            'can\'t be converted from the interface. The library needs an upgrade apparently'
        );
    }
}
