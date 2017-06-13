# MoneyToWords

Utility to convert a number to a CZK currency word representation.

## Installation with [Composer](https://getcomposer.org/)

```sh
php composer require kucharovic/czech-money-to-words
```

## Usage

```php
<?php
require __DIR__.'/vendor/autoload.php';

use JK\Utils\MoneyToWords;

$formatter = new MoneyToWords();

echo $formatter->spellout(123); // jednostodvacettři korun českých
echo $formatter->spellout(21.5, MoneyToWords::PRESERVE_SPACES); // dvacet jedna korun českých padesát haléřů

```