# The [Airbnb API](https://developer.airbnb.com/reference/overview) SDK for Laravel Framework

## Installation

You can install the package via Composer:

```bash
composer require amarkhai/airbnb-api-php-sdk
```

This is the default content of the config file published at `config/airbnb.php`:

```php
return [
    'api' => [
        'app_name' => env('AIRBNB_API_APP_NAME', 'BnBerry'),
        'client_id' => env('AIRBNB_API_CLIENT_ID'),
        'client_secret' => env('AIRBNB_API_CLIENT_SECRET'),
    ],
];
```
