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

## Example

```php
<?php

$clock = new \Arokettu\SystemClock\SystemClock();
$clockPsrAwareValidator->isValid($clock);
```

For a specific example, `lcobucci/jwt`:

```php
<?php

use Arokettu\SystemClock\SystemClock;
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

Read full documentation here: <https://sandfox.dev/php/clock.html>

Also on Read the Docs: https://arokettu-clock.readthedocs.io/

## Support

Please file issues on our main repo at GitLab: <https://gitlab.com/sandfox/php-clock/-/issues>

## License

The library is available as open source under the terms of the [MIT License](LICENSE.md).
