Clock
#####

|Packagist| |GitLab| |GitHub| |Bitbucket| |Gitea|

A collection of clock abstraction classes for PSR-20_.

.. _PSR-20: https://www.php-fig.org/psr/psr-20/

Installation
============

PHP 8.0+:

.. code-block:: bash

   composer require 'arokettu/clock'

PHP 7.0+:

.. code-block:: bash

   composer require 'arokettu/clock:^1'

or if you only need :ref:`the system clock <system_clock_package>`:

.. code-block:: bash

   composer require 'arokettu/system-clock'

Documentation
=============

This documentation covers both 1.x and 2.x branches.

.. toctree::
   :maxdepth: 2

   basic
   clocks
   system-clock
   upgrade

License
=======

The library is available as open source under the terms of the `MIT License`_.

.. _MIT License:        https://opensource.org/licenses/MIT

.. |Packagist|  image:: https://img.shields.io/packagist/v/arokettu/clock.svg?style=flat-square
   :target:     https://packagist.org/packages/arokettu/clock
.. |GitHub|     image:: https://img.shields.io/badge/get%20on-GitHub-informational.svg?style=flat-square&logo=github
   :target:     https://github.com/arokettu/php-clock
.. |GitLab|     image:: https://img.shields.io/badge/get%20on-GitLab-informational.svg?style=flat-square&logo=gitlab
   :target:     https://gitlab.com/sandfox/php-clock
.. |Bitbucket|  image:: https://img.shields.io/badge/get%20on-Bitbucket-informational.svg?style=flat-square&logo=bitbucket
   :target:     https://bitbucket.org/sandfox/php-clock
.. |Gitea|      image:: https://img.shields.io/badge/get%20on-Gitea-informational.svg?style=flat-square&logo=gitea
   :target:     https://sandfox.org/sandfox/php-clock
