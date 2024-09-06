# Changelog

## 2.x

### 2.6.0

*Jul 20, 2024*

* Float timestamps are now allowed in `MutableClock::fromTimestamp()` and `StaticClock::fromTimestamp()`

### 2.5.0

*Nov 15, 2023*

* Added `OffsetClock`

### 2.4.0

*Oct 31, 2023*

* Added simplified factory methods:
  * `StaticClock::fromDateString()` & `StaticClock::fromTimestamp()`
  * `MutableClock::fromDateString()` & `MutableClock::fromTimestamp()`
  * `RoundingClock::toMicroseconds()` ... `RoundingClock::toYears()`
  * `ShiftedClock::fromDateString()`
  * `TickingClock::fromDateString()`

### 2.3.0

*Oct 18, 2023*

* Added `getInnerClock()` to `RoundingClock`

### 2.2.0

*Jun 2, 2023*

* Requires `arokettu/system-clock` for deduplication purpose.
  Local implementation of SystemClock was removed.

### 2.1.0

*Apr 5, 2023*

* Rounding clock

### 2.0.0

*Mar 23, 2023*

Forked from 1.0.0

* Dropped support for PHP 7
* Removed a lot of internal hacks

## 1.x

### 1.6.1

*Sep 6, 2024*

* Fixed premature generation of next value in the CallbackClock [[gl#1]]

### 1.6.0

*Jul 20, 2024*

* Float timestamps are now allowed in `MutableClock::fromTimestamp()` and `StaticClock::fromTimestamp()`
* Fixed PHP 8.4 deprecations

### 1.5.0

*Nov 15, 2023*

* Added `OffsetClock`

### 1.4.0

*Oct 30, 2023*

* Added simplified factory methods:
  * `StaticClock::fromDateString()` & `StaticClock::fromTimestamp()`
  * `MutableClock::fromDateString()` & `MutableClock::fromTimestamp()`
  * `RoundingClock::toMicroseconds()` ... `RoundingClock::toYears()`
  * `ShiftedClock::fromDateString()`
  * `TickingClock::fromDateString()`

### 1.3.0

*Oct 18, 2023*

* Added `getInnerClock()` to `RoundingClock`

### 1.2.0

*Jun 2, 2023*

* Requires `arokettu/system-clock` for deduplication purpose.
  Local implementation of SystemClock was removed.

### 1.1.1

*Apr 5, 2023*

Fix timezone being lost in the rounding clock

### 1.1.0

*Apr 5, 2023*

* Rounding clock

### 1.0.0

*Mar 22, 2023*

Initial release

[gl#1]: https://gitlab.com/sandfox/php-clock/-/issues/1
