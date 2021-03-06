# Kong command line client

[![Build Status](https://img.shields.io/travis/dafiti/kong-cli/master.svg?style=flat-square)](https://travis-ci.org/dafiti/kong-cli)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/dafiti/kong-cli/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/dafiti/kong-cli/?branch=master)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/dafiti/kong-cli/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/dafiti/kong-cli/?branch=master)
[![HHVM](https://img.shields.io/hhvm/dafiti/kong-cli.svg?style=flat-square)](https://travis-ci.org/dafiti/kong-cli)
[![Latest Stable Version](https://img.shields.io/packagist/v/dafiti/kong-cli.svg?style=flat-square)](https://packagist.org/packages/dafiti/kong-cli)
[![Total Downloads](https://img.shields.io/packagist/dt/dafiti/kong-cli.svg?style=flat-square)](https://packagist.org/packages/dafiti/kong-cli)
[![License](https://img.shields.io/packagist/l/dafiti/kong-cli.svg?style=flat-square)](https://packagist.org/packages/dafiti/kong-cli)

A simple wrapper for the Kong API Manager using PHP

## Instalation
The package is available on [Packagist](http://packagist.org/packages/dafiti/kong-cli).
Autoloading is [PSR-4](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md) compatible.

```composer require dafiti/kong-cli```

Or add it directly to you `composer.json` file

```json
{
    "require": {
        "dafiti/kong-cli": "dev-master"
    }
}
```

## Usage

```bash
./kong-cli <COMMAND> [params]
```

### Available commands

* `api-list` :: list all registered apis

## License

MIT License
