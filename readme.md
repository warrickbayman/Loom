# Loom
[![Build Status](https://img.shields.io/travis/warrickbayman/Loom.svg?style=flat-square)](https://travis-ci.org/warrickbayman/Loom)
[![Stable](https://img.shields.io/github/release/warrickbayman/loom.svg?style=flat-square&label=stable)](https://github.com/warrickbayman/loom)
[![Unstable](https://img.shields.io/badge/unstable-dev--develop-blue.svg?style=flat-square)](https://github.com/warrickbayman/Loom/tree/develop)
[![License](http://img.shields.io/packagist/l/warrickbayman/loom.svg?style=flat-square)](http://opensource.org/licenses/mit)

Loom is a super simple way to work with units of time (hours, minutes, seconds, etc).

## Installation
Install Loom via Composer, by adding to the `requires` section of your `composer.json` file.

```json
{
	"require": {
		"warrickbayman/loom": "~0.1"
	}
}
```

Run `composer update` in your project route to install Loom.

Loom is tested on PHP 5.4, 5.5, 5.6 and HHVM 3.4. It has no dependencies except for PHPUnit when testing. It is framework agnostic, but I use it quite a bit on a number of projects mostly using the Laravel framework, so it's well tested there.

I would love to know if and how you use it.

## Use

### Creating a new Loom object

There are three methods to choose from when instantiating Loom.

You create a new instance of the `Loom` object:

```php
$fabric = new Loom\Loom(new Loom\Seconds(100));
```

To avoid having to use the `Loom` namespace each time, you could add it to your `use` clause:

```php
use Loom\Loom;
use Loom\Seconds;

class MyLoomClass
{
	public function translate()
	{
		$loom = new Loom(new Seconds(100));
	}
}
```

You could inject the `LoomFactory` class into your constructor and call the available creation methods from there:

```php
class MyLoomClass
{
	private $loom;
	
	public function __construct(Loom\LoomFactory $factory)
	{
		$this->loom = $factory->fromSeconds(240);
	}
	
	public function translate()
	{
		return $this->loom->getMinutes();        // 4
	}
}
```

Lastly, the simplest by far, is to call the static `make()` method on the `Loom` object, which returns a new instance of `LoomFactory`. Since the creation methods on `LoomFactory` returns a new `Loom` object, you can chain the translator methods onto the factory creation, and use Loom in a single line:

```php
$minutes = Loom::make()->fromHours(2)->getMinutes();    // 120
```

The creation methods on `LoomFactory`:

```php
$loomFactory->fromMilliseconds($milliseconds);
$loomFactory->fromSeconds($seconds);
$loomFactory->fromMinutes($minutes);
$loomFactory->fromHours($hours);
$loomFactory->fromDays($days);
$loomFactory->fromWeeks($weeks);
$loomFactory->fromMonths($months);
$loomFactory->fromYears($years);
```

### Getters

Loom provides some simple ways to translate from one unit to another.

```php
$milliseconds = $loom->getMilliseconds();
$seconds = $loom->getSeconds();
$minutes = $loom->getMinutes();
$hours = $loom->getHours();
$days = $loom->getDays();
$weeks = $loom->getWeeks();
$months = $loom->getMonths();
$years = $loom->getYears();
```

Each of the translaters return a float.

### Days per month gets averaged!
By default, Loom will average the number of days per month. This means results can be unexpected when working with months:

```php
$loom = Loom::make()->fromDays(30);
var_dump($loom->getMonths());		// Returns 0.98630136986301


$loom = Loom::make()->fromMonths(1);
var_dump($loom->getDays());			// Returns 30.416666666667
```

To prevent this from happening, the `getMonths()` method will accept an integer for the number of days in a month, so you could do:

```php
$loom = Loom::make()->fromDays(60);
var_dump($loom->getMonths(30));     // 2
```

You can do the same when creating a new `Loom` object from Months:

```php
$loom = Loom::make()->fromMonths(12, 31);
var_dump($loom->getDays());		// 372
```

### Solar Year
A year is not exactly 365 days long. Instead, it is ever so slightly longer than that. The current mean solar year is 365 days, 5 hours, 48 minutes and 45.19 seconds. Loom can use the solar year length of 365.2421897 days instead of simply 365 days by passing a boolean `true` as the second parameter when using the year methods. By default, Loom uses a flat 365 days to represent a year:

```php
$loom = Loom::make()->fromYears(1, true);
var_dump($loom->getDays());		// 365.2421897


$loom = Loom:make()->fromMonths(12);
var_dump($loom->getYears(true));	// 0.99933690656
```


### Difference

You can use the `diff()` method to get the difference between to Loom objects. The `diff()` method returns a third Loom object.

```php
$loom1 = Loom::make()->fromDays(1);
$loom2 = Loom::make()->fromHours(48);

$diff = $loom1->diff($loom2);

var_dump($diff->getHours());		// Returns 24.
```

It doesn't matter which object use call the `diff()` method on. The result will be the same either way.

### Comparisons

A number of comparison methods also exist:

```php
$loom1 = Loom::make()->fromDays(1);
$loom2 = Loom::make()->fromHours(48);

// Equal to
$loom1->eq($loom2);			// false

// Not equal to
$loom1->neq($loom2);		// true

// Greater than
$loom1->gt($loom2);			// false

// Greater than or equal to
$loom1->gte($loom2);		// false

// Less than
$loom1->lt($loom2);			// true

// Less than or equal to
$loom1->lte($loom2);		// true
```

It is important which object you call the comparison methods on. The object you call on is always on the left of theequasion.

### Between
Loom also provides a way to check if a unit falls between two other units. The `isBetween` method takes two Loom objects which means you can use any of the creation methods:

```php
$loom = Loom::make()->fromSeconds(120);
if ($loom->isBetween(
	Loom::make()->fromMinutes(1),
	Loom::make()->fromMinutes(2)
)) {
	echo 'Hooray!';
}
```

### Simple Arithmetic

You can also perform some simple arithmetic through the `add()` and `sub()` methods:

```php
	$loom = Loom::make()->fromMinutes(2);
	$loom->add(Loom::make()->fromSeconds(30));
	var_dump($loom->getSeconds())			// 150
	
	$loom->sub(Loom::make()->fromHours(1);
	var_dump($loom->getMilliseconds);		// 0
```

A `Loom` object can never have a negative value. Subtracting a larger Loom from a smaller one will always result in 0.


## Tests

Oh yes. Loom is 100% covered! You can run the tests from the `warrickbayman/loom` directory once installed:

`vendor/phpunit/phpunit/phpunit -c phpunit.xml`