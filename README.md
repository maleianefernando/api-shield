# Laravel API-SHIELD

A laravel library designed to add security layers for APIs to ensure data integrity, authenticity and prevent other security issues such as DoS and DDoS, Replay attack and flood attack.

## Features

- **🚀 Modern PHP 8.0+ Support**: Built with modern PHP features including typed properties, named arguments, and enums
- **📦 Integrated Middleware**: There is a native middleware that works as a shield
- **🔐 HMAC Signature Validation**: A hash that is based on a secret and uses the request data as a payload to ensure the data integrity
- **✅ Request Timestamp validation**: Each request has its own timestamp for the server to track the timeliness of the request
- **🔑 Request Identifier Validation**: Each request has its own unique identifier to track replay of that request
- **🔐 Request Logs for Auditing**: Every request that passes through this library is registered on logs
- **🔄 Laravel Integration**: Native integration with Laravel to act as a middleware with configuration publishing

## Installation

You can install the package via composer by following these instructions:
1. Add the repository to the `composer.json` file:
```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/maleianefernando/api-shield.git"
    }
],
```

2. Run the composer command to install the library
```bash
composer require maleianefernando/api-shield:main-dev
```

## Usage

### Basic usage

```php
Route::get('/profile', function () {
    // Your logic
})->middleware('api-shield');
```

Or:

```php
Route::middleware(['api-shield'])->group(function () {
    Route::get('/profile', function () { ... });
    Route::get('/profile/edit', function () { ... });
});
```

### Response Objects

When the request is recognized by the library as genuine, there is no a return, but, when the library detects some issue, will return some errors:

All error responses now has this structure:

```json
{
    "status": "Error",
    "message": "Invalid request timestamp."
}
```


#### Replay attack detected
1. When the request is sent with a know or cached nonce, the `api-shield` detect it and return:

```json
{
    "status": "Error",
    "message": "Possible replay attack detected."
}
```


#### Uploaded file security compromised
1. If there is an uploaded file and it was changed or damaged during the request, it will be detected: 
```json
{
    "status": "Error",
    "message": "Uploaded file integrity compromised."
}
```

#### Data manipulation attack
1. When a HMAC sent form the client is not coinciding with the server calculated HMAC, the `api-shield` will interpret this phenomenon as a possible replay attack:

```json
{
    "status": "Error",
    "message": "Possible data manipulation attack detected."
}
```

#### Flood attack
1. When the client reaches the defined limits both soft and hard, the client is blocked and the `api-shield` returns:

```json
{
    "status": "Error",
    "message": "Too many requests."
}
```

## Project Structure
```
src/
├── database/
│   └── 2026_05_20_170626_create_api_shield_audit_logs_table.php
├── Facades/
│   ├── Audit.php
|   ├── Hmac.php
|   ├── Nonce.php
|   ├── RateLimit.php
|   ├── ShieldUtils.php
│   └── Timestamp.php
├── Middleware/
│   └── ApiShieldMiddleware.php
├── Models/
│   └── ApiShieldAuditLog.php
├── Providers/
│   └── ApiShieldServiceProvider.php
├── Services/
│   ├── AuditService.php
|   ├── HmacService.php
|   ├── NonceService.php
|   ├── RateLimitService.php
│   └── TimestampService.php
└── Utilities/
    └── UtilitiesService.php
```

## API Reference

## Laravel Integration

### Installation in Laravel

Add the following environment variables to your `.env` file:

```env
AS_SECRET='z@LZdMeyJbcDQxauD-4+qRMWMGa8Aqgx' #Secret to generate HMAC
AS_NONCE_TTL=900                            # The time that a nonce will be stored on the server
# AS_NONCE_PREFIX                           # The prefix for the nonce value (optional)
AS_TIMESTAMP_LIMIT=900                      # The time inteval in wich a nonce will be valid
AS_SOFT_RATE_LIMIT=60                       # The first limit for a client to make requests
AS_HARD_RATE_LIMIT=120                      # The second limit in wich there is a throtle and after this limit the client is blocked
AS_DECAY_RATE_SECONDS=120                   # A client ttl when saved on the cache for rate limit mapping
AS_REQUEST_BLOCK_PERIOD=900                 # The period of client blocking after a reaching the request limit
```

## Testing

```bash
# Run specific test suite
./vendor/bin/phpunit tests/Test/HmacTest.php
./vendor/bin/phpunit tests/Test/HmacTest.php
```

### Running Tests

```bash
composer install

# Run tests
./vendor/bin/phpunit

# Run with verbose output
./vendor/bin/phpunit --verbose

# Run specific test
.-vendor/bin/phpunit tests/Test/HmacTest.php
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Fernando Maleiane](https://github.com/maleianefernando)
- [All Contributors](../../contributors)

<!-- ## License -->

<!-- The MIT License (MIT). Please see [License File](LICENSE.md) for more information. -->

<!-- ## PHP Package Boilerplate -->

<!-- This package was generated using the [PHP Package Boilerplate](https://laravelpackageboilerplate.com). -->