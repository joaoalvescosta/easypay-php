# Easypay-PHP

[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/gordalina/easypay-php/badges/quality-score.png?s=b160bd0c381c891e46f8afc603dc00ff9b60c5e7)](https://scrutinizer-ci.com/g/gordalina/easypay-php/)
[![Code Coverage](https://scrutinizer-ci.com/g/gordalina/easypay-php/badges/coverage.png?s=8661545b6e1ea5f183803dad32aa50889fbe1ab4)](https://scrutinizer-ci.com/g/gordalina/easypay-php/)

This library provides a simple API to communicate with [Easypay](http://easypay.pt/)

# Installing via Composer

The recommended way to install is through [Composer](http://composer.org).

```sh
# Install Composer
$ curl -sS https://getcomposer.org/installer | php

# Add easypay-php as a dependency
$ php composer.phar require gordalina/easypay-php:~0.0
```

After installing, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php';
```

# Testing

This library uses [PHPUnit](https://github.com/sebastianbergmann/phpunit).
In order to run the unit tests, you'll first need to install the development
dependencies of the project using Composer:

```
$ php composer.phar install --dev
```

You can then run the tests using phpunit

```
$ bin/phpunit
```

If you want to run integration tests you have to copy `phpunit.xml.dist` to
`phpunit.xml` then insert your credentials and set `EASYPAY_RUN_INTEGRATION_TESTS`
to true.

Then run phpunit

```
$ bin/phpunit --exclude-group none
```

# License

This library is under the MIT License, see the complete license [here](LICENSE)
