[![Build Status](https://travis-ci.org/inetprocess/transformation.svg?branch=master)](https://travis-ci.org/inetprocess/transformation)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/inetprocess/transformation/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/inetprocess/transformation/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/inetprocess/transformation/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/inetprocess/transformation/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/inetprocess/transformation/badges/build.png?b=master)](https://scrutinizer-ci.com/g/inetprocess/transformation/build-status/master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/c04e15ab-fff2-4aad-9c8e-7d3d4eba7a04/mini.png)](https://insight.sensiolabs.com/projects/c04e15ab-fff2-4aad-9c8e-7d3d4eba7a04)

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

## Callback(string $functionName, [$param1, $param2, ...])
Call any php function on input. The input will be passed as the last argument of the function.
```php
T::Callback('sprintf', "REF%'06d")->transform(1234); // REF001234
```

## Concat(string $before, [string $after])
Append and prepend string to input.
```php
T::Concat('REF')->transform('1234'); // REF1234
T::Concat('REF', 'AB')->transform('1234'); // REF1234AB
```

## Date(string $inputFormat, string $outputFormat)
Transforms a date from a format to another.

_See example above_

## Explode(string $delimiter)
Explode a string to an array using a delimiter. Uses `explode` function from PHP.
It returns an array.
```php
T::Explode(',')->transform('foo,bar,baz'); // array('foo', 'bar', 'baz');
T::Explode(',')->Implode('|')->transform('foo,bar,baz'); // foo|bar|baz
```

## Implode(string $delimiter)
Join an array elements to a string. Uses `implode` function from PHP.
```php
T::Implode('@')->transform(array('foo', 'bar')); // foo@bar
```

## Map(array $mapping)
Try to replace the input with the value in the mapping.
It can also work with an array as input.
Values not found in mapping are return without tranformations

```php
$mapping = array(
    '1' => 'key1',
    '10' => 'key10',
);
T::Map($mapping)->transform('1'); // key1
T::Map($mapping)->transform(array('10', '1')); // array('key10', 'key1')
T::Map($mapping)->transform('unknown key'); // unknown key
```

## NormalizeURL(string $protocol)
Prepend a default protocol if not present to any url.
```php
T::NormalizeURL('http')->transform('https://www.google.com'); // https://www.google.com
T::NormalizeURL('http')->transform('www.google.com'); // http://www.google.com
T::NormalizeURL('http')->transform('ssh://github.com'); // ssh://github.com
T::NormalizeURL('ssh')->transform('github.com'); // ssh://github.com
```

## Replace(string $search, string $replace)
Replace a string by another (does the same than str_replace).
```php
T::Replace('a', 'b')->transform('ababa'); // bbbbb
```


## ReplaceRegexp(string $pattern, string $replacement)
Replace a pattern by a replacement (does the same than preg_replace).
```php
T::ReplaceRegexp('/^fox/', 'rabbit')->transform('fox and foxes'); // rabbit and foxes
```

## Slugify()
Uses [Cocur\Slugify](https://github.com/cocur/slugify) to Slugify a string.
```php
T::Slugify()->transform('Bonjour tôôut le monde !'); // bonjour-toout-le-monde
```

## SugarCRMMapMultiEnum(array $mapping, [array $options])
Map multiple values from a string or an array
and return a string encoded for database storage of SugarCRM multi enum field.
String are exploded first with the default separator `|`.
You can set the following options
* `separator`: Separator to use to explode input string. Default: `|`
* `from_multi_enum`: If true parse the input string as a SugarCRM multi enum field. Default: `false`
```php
$mapping = array(
    '1' => 'key1',
    '10' => 'key10',
);
T::SugarCRMMapMultiEnum($mapping)->transform('1|10'); // ^key1^,^key10^
T::SugarCRMMapMultiEnum($mapping)->transform(array('1', '10'); // ^key1^,^key10^
T::SugarCRMMapMultiEnum($mapping)->transform('^1^,^23^', array('from_multi_enum' => true)); // ^key1^,^23^
```

## Timezone(string $inputFormat, string $targetTimezone, [string $currentTimezone])
Change the Timezone of a Date by providing the format, the target Timezone and optionnaly the timezone for the current date.

_See example above_
