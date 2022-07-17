# Property Jobs Laravel ReactJs App

> Laravel framework v8 and Php7.3.33

## Quick Start

``` bash
# Install Dependencies
composer install

# Run Migrations
php artisan migrate

# Add virtual host if using Apache else localhost with port 8000 is default server

Database Name: "freelance_users"
Please check the "freelance_users.sql" coplete databse at root directory.
Individual tables given for initial import are "currencies.sql" and "exchange_rates.sql" at root directory.


For Backend - Laravel : 
in Terminal: 
php artisan serve
path: http://localhost:8000

```

## Endpoint

### Third-party service driver for currency conversion provided by https://exchangeratesapi.io 
``` bash
GET https://api.apilayer.com/currency_data/convert?from=gbp&to=eur&amount=1234

```


```

## App Info

### Author

Sanjay Sorathiya
steel1985@gmail.com

### Version

1.0.0

### License

This project is licensed under the MIT License