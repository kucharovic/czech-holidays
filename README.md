# CzechHolidays

Utility to check if given date is holiday in Czech Republic.

## Installation with [Composer](https://getcomposer.org/)

```sh
php composer require kucharovic/czech-holidays
```

## Usage

```php
<?php
require __DIR__.'/vendor/autoload.php';

use JK\Utils\CzechHolidays;
use DateTimeImmutable;

$day = DateTimeImmutable::createFromFormat('Y-m-d', '2018-01-01');

var_dump(CzechHolidays::isHoliday($day)); // bool(true)
echo CzechHolidays::getHolidayName($day) // Nový rok
```

---

# CzechHolidays

Jednoduchý nástroj na práci s českými svátky (včetně Velikonoc).

## Instalace pomocí nástroje [Composer](https://getcomposer.org/)

```sh
php composer require kucharovic/czech-holidays
```
## Použití

```php
<?php
require __DIR__.'/vendor/autoload.php';

use JK\Utils\CzechHolidays;
use DateTimeImmutable;

$day = DateTimeImmutable::createFromFormat('Y-m-d', '2018-01-01');

var_dump(CzechHolidays::isHoliday($day)); // bool(true)
echo CzechHolidays::getHolidayName($day) // Nový rok
```