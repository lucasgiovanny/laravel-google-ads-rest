<img src="art/logo.png" width="500" alt="Laravel Google Ads RES">

Laravel Google Ads Rest is a package created by [Lucas Giovanny](https://github.com/lucasgiovanny) that provides a convenient and user-friendly way to utilize the Google Ads API through a REST protocol. With this package, users can easily integrate their Laravel application with the Google Ads API, without the need for extensive coding or technical expertise. This package simplifies the process of accessing and manipulating data from Google Ads campaigns, making it easier for developers to build powerful applications that leverage the full capabilities of the Google Ads API.

![GitHub release (latest by date)](https://img.shields.io/github/v/release/lucasgiovanny/laravel-google-ads-rest?label=last%20version)
![GitHub](https://img.shields.io/github/license/lucasgiovanny/laravel-google-ads-rest)

## Documentation

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

Example:

```php
use LucasGiovanny\LaravelGoogleAds\Facades\GoogleAds;

GoogleAds::account('ACCOUNT_ID')
    ->from('ad_group_ad')
    ->select(['metrics.cost_micros', 'segments.date'])
    ->where('segments.date', 'BETWEEN', '2023-01-01 AND 2023-01-31')
    ->get()
```

#### Method: `account($accountId)`

The `account()` method sets the Google Ads account ID to be used for the query. It takes in a string parameter `$accountId` which is the Google Ads account ID.

#### Method: `from($resource)`

The `from()` method specifies the **resource** to be queried. It takes in a string parameter `$resource` which is the name of the resource in the Google Ads API.

#### Method: `select($fields)`

The `select()` method specifies the **fields** to be retrieved from the specified resource. It takes in an array parameter `$fields` which is a list of the field names as strings.

#### Method: `where($field, $operator, $value)`

The `where()` method specifies a filter to apply to the query. It takes in three parameters: `$field` which is the name of the field to filter on, `$operator` which is the filter operator (e.g. BETWEEN, EQUALS, etc.), and `$value` which is the value to filter on.

#### Method: `get()`

The `get()` method executes the query and returns the result as an array of objects.

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
