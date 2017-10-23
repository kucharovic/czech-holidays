# CzechHolidays

Simple and lighweight utility to check if given date is holiday in Czech Republic. If you need more than Czech holidays, I recommend [Yasumi](https://github.com/azuyalabs/yasumi) library.

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

Jednoduchý PHP nástroj na práci s českými svátky (včetně Velikonoc). Pokud potřebujete pracovat se svátky několika zemí (včetně ČR), doporučuji knihovnu [Yasumi](https://github.com/azuyalabs/yasumi).

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
