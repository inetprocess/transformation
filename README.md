# inetprocess/transformation
Inspired by [Respect/Validation](https://github.com/Respect/Validation), that library transforms an input string (or float / int / bool) to an output string, after applying rules.

The benefit using it is that it a generic wrapper for any kind of transformation. Also it throws Exceptions and allows to chain the transformations.

# Usage
It's pretty simple to use. suppose you need to transform a date "31-12-2012" to another format such as "2012-12-31". Just do:
```php
<?php
require_once __DIR__ . '/vendor/autoload.php';
use Inet\Transformation\Transform as T;

$dateEntered = '31-12-2012';
$output = T::Date('d-m-Y', 'Y-m-d')->transform($dateEntered);
echo $output;
```

Now if you need to change the format then the Timezone:
```php
<?php
require_once __DIR__ . '/vendor/autoload.php';
use Inet\Transformation\Transform as T;

$dateEntered = '31-12-2012 23:21:58';
$output = T::Date('d-m-Y H:i:s', 'Y-m-d H:i:s')->Timezone('Y-m-d H:i:s', 'Asia/Calcutta')->transform($dateEntered);
// Displays: 2013-01-01 03:51:58
echo $output;
```

# Transformation Rules
For now there is only a few rules. I'll add more later, and don't hesitate if you want to contribute.

## Date(string $inputFormat, string $outputFormat)
Transforms a date from a format to another.

_See example above_

## Replace(string $search, string $replace)
Replace a string by another (does the same than str_replace).
```php
<?php
require_once __DIR__ . '/vendor/autoload.php';
use Inet\Transformation\Transform as T;

$str = 'abababababab';
$output = T::Replace('a', 'b')->transform($str);
echo $output;
```


## ReplaceRegexp(string $pattern, string $replacement)
Replace a pattern by a replacement (does the same than preg_replace).
```php
<?php
require_once __DIR__ . '/vendor/autoload.php';
use Inet\Transformation\Transform as T;

$str = 'abababababab';
$output = T::ReplaceRegexp('/a/', 'b')->transform('abababababab');
echo $output;
```

## Slugify()
Uses [Cocur\Slugify](https://github.com/cocur/slugify) to Slugify a string.
```php
<?php
require_once __DIR__ . '/vendor/autoload.php';
use Inet\Transformation\Transform as T;

$str = 'abababababab';
$output = T::Slugify()->transform('Bonjour tôôut le monde !');
// Displays: bonjour-toout-le-monde
echo $output;
```

## Timezone(string $inputFormat, string $targetTimezone, [string $currentTimezone])
Change the Timezone of a Date by providing the format, the target Timezone and optionnaly the timezone for the current date.

_See example above_
