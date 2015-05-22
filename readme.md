# Loom
[![Build Status](https://img.shields.io/travis/warrickbayman/Loom.svg?style=flat-square)](https://travis-ci.org/warrickbayman/Loom)
[![Stable](https://img.shields.io/github/release/warrickbayman/loom.svg?style=flat-square&label=stable)](https://github.com/warrickbayman/loom)
[![Unstable](https://img.shields.io/badge/unstable-dev--develop-red.svg?style=flat-square)](https://github.com/warrickbayman/Loom/tree/develop)
[![License](http://img.shields.io/packagist/l/warrickbayman/loom.svg?style=flat-square)](http://opensource.org/licenses/mit)

Loom is a super simple way to work with units of time (hours, minutes, seconds, etc).

## Why?
Because who knows what this means?

```php
$something = someFunctionWithTime(7200);
```

The `7200` is meaningless. Seconds? Hours? Years? So I started Loom to wrap numbers when working with time constants in a way that was readable:

```php
$loom = Loom::make()->fromHours(2);
$something = someFunctionWithTime($loom->getSeconds());
```

Sure, it's longer, but it's so much easier to read. Plus, you get a bit of functionality to convert from one unit of time to another.

Loom is tested on PHP 5.4, 5.5, 5.6 and HHVM 3.4. It has no dependencies except for PHPUnit when testing. It is framework agnostic, but I use it quite a bit on a number of projects mostly using the Laravel framework, so it's well tested there.

Let me know if and how you use it.

## Installation
Install Loom via Composer, by adding to the `requires` section of your `composer.json` file.

```json
{
	"require": {
		"warrickbayman/loom": "~0.2"
	}
}
```

Run `composer update` in your project root to install Loom.

## Use

### Creating a new Loom object

There are three methods to choose from when instantiating Loom.

You create a new instance of the `Loom` object:

```php
$loom = new Loom\Loom(new Loom\Seconds(100));
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

A recommended method is to inject the `LoomFactory` class into your constructor and call the available creation methods from there:

```php
class MyLoomClass
{
	private $loom;
	
	public function __construct(Loom\LoomFactory $loom)
	{
		$this->loom = $loom->fromSeconds(240);
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
$loomFactory->fromMicroseconds($microseconds);
$loomFactory->fromMilliseconds($milliseconds);
$loomFactory->fromSeconds($seconds);
$loomFactory->fromMinutes($minutes);
$loomFactory->fromHours($hours);
$loomFactory->fromDays($days);
$loomFactory->fromWeeks($weeks);
$loomFactory->fromMonths($months);
$loomFactory->fromYears($years);
```

### Using DateTime
**Note: the `fromTime()` method has been deprecated and will be removed in 0.3. Please use `fromDateTime()` instead.**


The `LoomFactory` object also provides a `fromDateTime` method which allows you to create a Loom object from a `DateTime` object.

```php
$loom = $loomFactory->fromDateTime(new \DateTime('2015-01-21');
```

The new loom object will represent the amount of time that has passed since the Epoc (1970-01-01 00:00:00). So, in other words, doing this...

```php
var_dump($loom->getHours());
```

... will get you the number of hours since the 1st of January 1970. However, this becomes a little more useful when you you need to get the difference between two specific dates:

```php
$loom = Loom::make()->fromDateTime(new \DateTime('2015-01-21'));
$result = $loom->diff(Loom::make()->fromDateTime(new \DateTime('2015-01-27'));

var_dump($result->getDays());     // 6
var_dump($result->getHours());    // 144
var_dump($result->getMinutes());  // 8640
```

And since libraries like `nesbot\carbon` simply extend the `DateTime` object, you can do things like this as well...

```php
$loom = Loom::make()->fromTime(\Carbon\Carbon::now());
```


### Getters

Loom provides some simple ways to translate from one unit to another.

```php
$microseconds = $loom->getMicroseconds();
$milliseconds = $loom->getMilliseconds();
$seconds = $loom->getSeconds();
$minutes = $loom->getMinutes();
$hours = $loom->getHours();
$days = $loom->getDays();
$weeks = $loom->getWeeks();
$months = $loom->getMonths();
$years = $loom->getYears();
```

Each of the getters return a float.

### Days per month get averaged!
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

You can use the `diff()` method to get the difference between two Loom objects. The `diff()` method returns a new Loom object.

```php
$loom1 = Loom::make()->fromDays(1);
$loom2 = Loom::make()->fromHours(48);

$diff = $loom1->diff($loom2);

var_dump($diff->getHours());		// Returns 24.
```

It doesn't matter which object you call the `diff()` method on. The result will be the same either way.

There are also two time saving methods available which returns the difference until a specific time, or since a specific
time. The aptly name `until()` and `since()` methods are only really useful if you first create a Loom object from a 
PHP `DateTime` object. Both methods return a new Loom object.

```php
$loomPast = Loom::make()->fromTime(new \DateTime('now - 5 days'));
$loomFuture = Loom::make()->fromTime(new \DateTime('now + 10 days'));

var_dump($loomPast->since()->getHours());       // Returns 120.
var_dump($loomFuture->until()->getHours());     // Returns 240.
```

The `since()` and `until()` methods simply do a `diff()` on the two Loom objects, and since the `diff()` method will
always return a positive number, the `since()` and `until()` methods are actually identical. They exist simply to help
make your code a little more readable.

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

Here it _is_ important which object you call the comparison methods on. The object you call on is always on the left of the equasion.

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
	
	$loom->sub(Loom::make()->fromHours(1));
	var_dump($loom->getMilliseconds);		// 0
```

A `Loom` object can never have a negative value. Subtracting a larger Loom from a smaller one will always result in 0.

The arithmetic methods also accept an instance of `AbstractUnit`, so you don't need to create another `Loom` object. You can just pass the unit into the methods:

```php
	$loom = Loom::make()->fromMinutes(2);
	$loom->add(new Loom\Seconds(60));
	var_dump($loom->getMinutes());		// 180
	
	$loom->sub(new Loom\Minutes(2));
	var_dump($loom->getSeconds());		// 60
```