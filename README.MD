# PHP library for Jinance.com.au public API
With the PHP library, you can easily trade at Jinance.com.au

## Getting Start
First you need to sign up for the [Jinance](https://jinance.com.au) API. You will need to pass KYC, otherwise some APIs are not supported.

## Installation
To install in your project

```json
composer require jinance/jinance-php
```
### Usage

```php

<?php
require_once 'vendor/autoload.php';

use Jinance\Jinance;

$jinance = new Jinance();

// get ticker of default symbol "BTC/AUD"
$res = $jinance->ticker();

$api_key = "";
$api_secrect = "";

$jinance = new Jinance($api_key, $api_secrect);

// get account balance
$res = $jinance->balance();

```
see more examples and all supported endpoints in example.php

## LICENSE
MIT
