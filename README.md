# Laravel Google Ads REST

This Laravel package provides a convenient and user-friendly way to utilize the Google Ads API through a REST protocol. With this package, users can easily integrate their Laravel application with the Google Ads API, without the need for extensive coding or technical expertise. This package simplifies the process of accessing and manipulating data from Google Ads campaigns, making it easier for developers to build powerful applications that leverage the full capabilities of the Google Ads API.

![GitHub release (latest by date)](https://img.shields.io/github/v/release/lucasgiovanny/laravel-google-ads-rest?label=last%20version)
![GitHub](https://img.shields.io/github/license/lucasgiovanny/laravel-google-ads-rest)

## Documentation

Laravel Google Ads Rest is a package created by [Lucas Giovanny](https://github.com/lucasgiovanny) that provides a simple and easy-to-use interface for interacting with the Google Ads API using Laravel.

### Installation

To install the package, you can use Composer by running the following command:

```bash
composer require lucasgiovanny/laravel-google-ads-rest
```

### Configuration

To use the package, you must configure your credentials on your `.env` file.

```bash
GOOGLEADS_CLIENT_ID=
GOOGLEADS_CLIENT_SECRET=
GOOGLEADS_DEVELOPER_TOKEN=
GOOGLEADS_REFRESH_TOKEN=
GOOGLEADS_DEFAULT_ACCOUNT=
```

### Usage

You can use the package by calling the `GoogleAds` facade.

```php
use LucasGiovanny\LaravelGoogleAds\Facades\GoogleAds;

GoogleAds::account('ACCOUNT_ID')
    ->from('ad_group_ad')
    ->select(['metrics.cost_micros', 'segments.date'])
    ->where('segments.date', 'BETWEEN', '2023-01-01 AND 2023-01-31')
    ->get()
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [Lucas Giovanny](https://github.com/lucasgiovanny)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
