# Simple key-value storage for Nette Framework

-----

[![Build Status](https://travis-ci.org/surda/key-value-storage.svg?branch=master)](https://travis-ci.org/surda/key-value-storage)
[![Licence](https://img.shields.io/packagist/l/surda/key-value-storage.svg?style=flat-square)](https://packagist.org/packages/surda/key-value-storage)
[![Latest stable](https://img.shields.io/packagist/v/surda/key-value-storage.svg?style=flat-square)](https://packagist.org/packages/surda/key-value-storage)
[![PHPStan](https://img.shields.io/badge/PHPStan-enabled-brightgreen.svg?style=flat)](https://github.com/phpstan/phpstan)


## Installation

The recommended way to is via Composer:

```
composer require surda/key-value-storage
```

After that you have to register services in config.neon:

```yaml
services:
    cookieStorage: Surda\KeyValueStorage\CookieStorage
    sessionStorage: Surda\KeyValueStorage\SessionStorage('section-name')
    arrayStorage: Surda\KeyValueStorage\ArrayStorage
```
