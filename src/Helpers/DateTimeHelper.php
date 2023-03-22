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
        // @codeCoverageIgnoreStart
        return DateTimeImmutable::createFromFormat('U u', $dateTime->format('U u'))
            ->setTimezone($dateTime->getTimezone());
        // @codeCoverageIgnoreEnd
    }
}
