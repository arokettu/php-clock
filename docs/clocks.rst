Clocks
#######

.. highlight:: php

System time based
=================

.. _system_clock_class:

SystemClock
-----------

``Arokettu\Clock\SystemClock``

.. note::
    Can be installed separately as ``arokettu/system-clock`` where the class name is ``Arokettu\SystemClock\SystemClock``.
    See :ref:`system_clock_package`.

A basic system clock::

    <?php

    $clock = new \Arokettu\Clock\SystemClock();
    // optionally with a timezone
    $clock = new \Arokettu\Clock\SystemClock(new DateTimeZone('Europe/Tallinn'));

    $clock->now(); // whatever time is now

ShiftedClock
------------

``Arokettu\Clock\ShiftedClock``

A system clock with a constant time shift::

    <?php

    $shift = DateInterval::createFromDateString('1 week ago');
    $clock = new \Arokettu\Clock\ShiftedClock($shift);
    // optionally with a timezone
    $clock = new \Arokettu\Clock\ShiftedClock($shift, new DateTimeZone('Europe/Tallinn'));

    $clock->now(); // exactly a week ago

Abstract time based
===================

StaticClock
-----------

``Arokettu\Clock\StaticClock``

Returns a specific time that can be changed manually::

    <?php

    $clock = new \Arokettu\Clock\StaticClock(); // 'now'
    // or a specific time
    $clock = new \Arokettu\Clock\StaticClock(new DateTimeImmutable('2007-01-01'));

    $clock->now(); // happy new 2007

    $clock->set(new DateTimeImmutable('2015-10-21')); // back to the future

MutableClock
------------

TickingClock
------------

CallbackClock
-------------
