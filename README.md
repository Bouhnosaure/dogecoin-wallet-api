# dogecoin-wallet-api

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

## Disclaimer

This is an experimental library, in early stage of development. use it at you own risks.
Also, i, from now, can't be responsible for your possible loss or failures.
You always should test this library in a testnet environement before using it on production stage (if the library become stable)
Anyway have fun and remember 1Doge = 1Doge 



## Structure

If any of the following are applicable to your project, then the directory structure should follow industry best practices by being named the following.

```
bin/        
config/
src/
tests/
vendor/
```


## Install

Via Composer

``` bash
$ composer require bouhnosaure/dogecoin-wallet-api
```

## Usage

``` php
$skeleton = new Bouhnosaure\DogeWallet();
echo $skeleton->echoPhrase('Hello, League!');
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email dev.citrex@gmail.com instead of using the issue tracker.

## Credits

- [ci_trex][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/bouhnosaure/dogecoin-wallet-api.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/bouhnosaure/dogecoin-wallet-api/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/bouhnosaure/dogecoin-wallet-api.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/bouhnosaure/dogecoin-wallet-api.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/bouhnosaure/dogecoin-wallet-api.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/bouhnosaure/dogecoin-wallet-api
[link-travis]: https://travis-ci.org/bouhnosaure/dogecoin-wallet-api
[link-scrutinizer]: https://scrutinizer-ci.com/g/bouhnosaure/dogecoin-wallet-api/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/bouhnosaure/dogecoin-wallet-api
[link-downloads]: https://packagist.org/packages/bouhnosaure/dogecoin-wallet-api
[link-author]: https://github.com/bouhnosaure
[link-contributors]: ../../contributors
