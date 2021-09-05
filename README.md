# Notice

This is not a final version of SDK. If you have any question or suggestion, please reach out me directly or create issues. Thanks.

# The [Airbnb API](https://developer.airbnb.com/reference/overview) SDK for Laravel Framework

## Installation

You can install the package via Composer:

```bash
composer require amarkhai/airbnb-api-php-sdk
```

## Config

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

You need to add these parameters to your .env

Go to [Airbnb Developer Docs](https://developer.airbnb.com/) -> Partner Portal -> Settings

Set "App name" to AIRBNB_API_APP_NAME, "Client ID" to AIRBNB_API_CLIENT_ID and "Client secret" to AIRBNB_API_CLIENT_SECRET 

## Usage

This library provides you a lot of predefined entities for data structures from Airbnb and services for many API endpoints.
It can be useful to make your API integration more structured.

```php
$token = 'abcdef';
$listingID = 1234567;
$listing = $listingService->getListing($listingID, $token);
$listing->setName('New Super Name');
$listingService->updateListing($listing, $token);
```

