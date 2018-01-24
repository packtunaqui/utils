# Utils

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what
PSRs you support to avoid any confusion with users and contributors.

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
$ composer require tunaqui/utils --prefer-dist
```

## Usage

``` php
$array = [
    'item1' => [ 'a' => 'Hola Mundo Cruel!', 'b' => 'Hola Mundo!' ],
    'item2' => 123456,
];
$selectable = new Tunaqui\Utils\ArraySelectable($array);
echo $selectable->find('item1.a');
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/Tunaqui/Utils.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/Tunaqui/Utils/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/Tunaqui/Utils.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/Tunaqui/Utils.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/Tunaqui/Utils.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/Tunaqui/Utils
[link-travis]: https://travis-ci.org/Tunaqui/Utils
[link-scrutinizer]: https://scrutinizer-ci.com/g/Tunaqui/Utils/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/Tunaqui/Utils
[link-downloads]: https://packagist.org/packages/Tunaqui/Utils
[link-author]: https://github.com/EstevanTn
[link-contributors]: ../../contributors
