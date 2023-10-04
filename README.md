# Clock

[![Packagist](https://img.shields.io/packagist/v/arokettu/clock.svg?style=flat-square)](https://packagist.org/packages/arokettu/clock)
[![PHP](https://img.shields.io/packagist/php-v/arokettu/clock.svg?style=flat-square)](https://packagist.org/packages/arokettu/clock)
[![Packagist](https://img.shields.io/github/license/arokettu/php-clock.svg?style=flat-square)](LICENSE.md)
[![Gitlab pipeline status](https://img.shields.io/gitlab/pipeline/sandfox/php-clock/master.svg?style=flat-square)](https://gitlab.com/sandfox/php-clock/-/pipelines)
[![Codecov](https://img.shields.io/codecov/c/gl/sandfox/php-clock?style=flat-square)](https://codecov.io/gl/sandfox/php-clock/)

A collection of clock abstraction classes for [PSR-20].

[PSR-20]: https://www.php-fig.org/psr/psr-20/

## Installation

```bash
composer require arokettu/clock
```

Supported versions:

* 1.x (LTS-ish, PHP 7.0+)
* 2.x (current, PHP 8.0+)

## Example

```php
<?php

$clock = new \Arokettu\Clock\SystemClock();
$clockPsrAwareValidator->isValid($clock);
```

For a specific example, `lcobucci/jwt`:

```php
<?php

use Arokettu\Clock\SystemClock;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;

$cfg = Configuration::forSymmetricSigner(new Sha256(), '...');
$token = $cfg->parser()->parse('...');

$cfg->validator()->assert(
    $token,
    new StrictValidAt(new SystemClock())
);
```

## Documentation

Available clock classes:

* SystemClock. 
  Plain class that returns operating system clock, also available as a separate package:
  [arokettu/system-clock](https://packagist.org/packages/arokettu/system-clock)
* ShiftedClock. System clock + fixed interval
* StaticClock. Clock that returns a single set value
* MutableClock. Based on mutable DateTime class
* TickingClock. Clock that advances an interval every call
* CallbackClock. A wrapper for a closure that also supports generator closures
* RoundingClock. A clock wrapper that rounds time to a certain precision

Read full documentation here: <https://sandfox.dev/php/clock.html>

Also on Read the Docs: https://arokettu-clock.readthedocs.io/

## Support

Please file issues on our main repo at GitLab: <https://gitlab.com/sandfox/php-clock/-/issues>

Feel free to ask any questions in our room on Gitter: <https://gitter.im/arokettu/community>

## License

The library is available as open source under the terms of the [MIT License](LICENSE.md).
