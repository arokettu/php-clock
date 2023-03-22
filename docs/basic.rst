Basic Usage
###########

.. highlight:: php

All classes implement the ``Psr\Clock\ClockInterface`` and can be used with any package that accepts it::

    <?php

    $clock = new \Arokettu\Clock\SystemClock();
    $clockPsrAwareValidator->isValid($clock);

``lcobucci/jwt``::

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

``ordinary/uid``::

    <?php

    use Arokettu\Clock\SystemClock;
    use Ordinary\UID\Generator as UIDGenerator;
    use Random\Randomizer;

    $generator = new UIDGenerator(new SystemClock(), new Randomizer());

    var_dump($generator->generate(4)->value());
