KachkaevPHPRBundle [![Build Status](https://secure.travis-ci.org/kachkaev/KachkaevPHPRBundle.png)](http://travis-ci.org/kachkaev/KachkaevPHPRBundle)
==================

Symfony2/Symfony3 bundle for the [php-r](https://github.com/kachkaev/php-r) library

Installation
------------

### Composer

Add the following dependency to your project’s composer.json file:

```js
    "require": {
        // ...
        "kachkaev/php-r-bundle": "dev-master"
        // ...
    }
```
Now tell composer to download the bundle by running the command:

```bash
$ php composer.phar update kachkaev/php-r-bundle
```

Composer will install the bundle to `vendor/kachkaev` directory.

### Adding bundle to your application kernel

```php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Kachkaev\PHPRBundle\KachkaevPHPRBundle(),
        // ...
    );
}
```

Configuration
-------------

Here is the default configuration for the bundle:

```yml
kachkaev_phpr:
    default_engine: command_line     # default R engine (command_line is the only one currently implemented)  
    engines:
        command_line:
            path_to_r: /usr/bin/R    # path to R interpreter
```

In most cases custom configuration is not needed, so simply add the following line to your ``app/config/config.yml``:

```yml
kachkaev_phpr: ~
```

Usage
-----

```php
$r = $container->get('kachkaev_phpr.core');
$rResult = $r->run('x = 10
x * x');

// --- or ---

$r = $container->get('kachkaev_phpr.core');
$rProcess = $r->createInteractiveProcess();
$rProcess->write('x = 10');
$rProcess->write('x * x');
$rResult = $rProcess->getAllResult();
```

```$rResult``` contains the following string:
```
> x = 10
> x * x
[1] 100
```

For detailed feature description of R core and R process see documentation to [php-r library](https://github.com/kachkaev/php-r). 

An instance of ```ROutputParser``` is also registered as a service:
```php
$rOutputParser = $container->get('kachkaev_phpr.output_parser');

$rProcess->write('21 + 21');
var_dump($rProcess->getLastWriteOutput());
// string(6) "[1] 42"
var_dump($rOutputParser->singleNumber($rProcess->getLastWriteOutput()));
// int(42)
```


License
-------

MIT. See [LICENSE](LICENSE).
