# IconModule

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]

Icons list.

## Installation

Via Composer

``` bash
$ composer require zdrojowa/icon-module
```

## NPM required:

``` bash
"axios": "^0.19",
"bootstrap": "^4.5.3",
"bootstrap-vue": "2.16.0",
"vue": "^2.6.10",
"vue-router": "^3.4.9",
```

## Usage

- Add in webpack.mix.js

``` bash
mix.module('IconModule', 'vendor/zdrojowa/icon-module');
```

- Add module IconModule in config/selene.php

``` bash
'modules' => [
    IconModule::class,
],

'menu-order' => [
    'IconModule',
],
```

- run npm

``` bash
npm install
npm run prod
```

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email author email instead of using the issue tracker.

## Credits

- [author name][link-author]
- [All Contributors][link-contributors]

## License

license. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/zdrojowa/icon-module.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/zdrojowa/icon-module.svg?style=flat-square
[link-packagist]: https://packagist.org/packages/zdrojowa/icon-module
[link-downloads]: https://packagist.org/packages/zdrojowa/icon-module
[link-author]: https://github.com/zdrojowa
[link-contributors]: ../../contributors
