<?php

declare(strict_types=1);

namespace Arokettu\Clock\Helpers;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;

/**
 * @internal
 */
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

        // should be a dead code but keep it anyway
        return DateTimeImmutable::createFromFormat('U u', $dateTime->format('U u'))
            ->setTimezone($dateTime->getTimezone());
    }

    public static function createMutableFromInterface(DateTimeInterface $dateTime): DateTime
    {
        if ($dateTime instanceof DateTime) {
            return clone $dateTime; // decouple the instance, like DateTime::createFromInterface(DateTime) does
        }

        if ($dateTime instanceof DateTimeImmutable && method_exists(DateTime::class, 'createFromImmutable')) {
            return DateTime::createFromImmutable($dateTime);
        }

        $dt = DateTime::createFromFormat('U u', $dateTime->format('U u'));
        $dt->setTimezone($dateTime->getTimezone());

        return $dt;
    }
}
