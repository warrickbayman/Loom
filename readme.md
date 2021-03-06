# Loom
[![Build Status](https://travis-ci.org/warrickbayman/Loom.svg?branch=1.1)](https://travis-ci.org/warrickbayman/Loom)
[![Stable](https://poser.pugx.org/warrickbayman/loom/v/stable.svg)](https://packagist.org/packages/warrickbayman/loom)
[![Latest Unstable Version](https://poser.pugx.org/warrickbayman/loom/v/unstable)](https://packagist.org/packages/warrickbayman/loom)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/warrickbayman/Loom.svg?branch=1.1)](https://scrutinizer-ci.com/g/warrickbayman/Loom/?branch=1.1)
[![License](https://poser.pugx.org/warrickbayman/loom/license)](https://packagist.org/packages/warrickbayman/loom)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/77e1616d-b220-4031-9a74-45dbe9258d1d/small.png)](https://insight.sensiolabs.com/projects/77e1616d-b220-4031-9a74-45dbe9258d1d)

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

Loom is tested on PHP 5.4, 5.5, 5.6, 7.0 and HHVM. It has no dependencies except for PHPUnit when testing. It is framework agnostic, but I use it quite a bit on a number of projects mostly using the Laravel framework, so it's well tested there.

Let me know if and how you use it.

## Installation
Install Loom via Composer, by adding to the `requires` section of your `composer.json` file.

```json
{
	"require": {
		"warrickbayman/loom": "~1.0"
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

There is also a `fromLoom()` method which creates a new instance of the `Loom` object passed as a paramter.

__Note:__ that the `fromLoom()` used to be named `copy()` but was never documented. Just in case, I've deprecated the `copy()` method until the next major release.

### Using DateTime

The `LoomFactory` object also provides a `fromDateTime` method which allows you to create a Loom object from a `DateTime` object.

```php
$loom = $loomFactory->fromDateTime(new \DateTime('2015-01-21');
```

The new loom object will represent the amount of time that has passed since the Epoc (1970-01-01 00:00:00). So, in other words, doing this...

```php
var_dump($loom->getHours());
```

... will get you the number of hours since the 1st of January 1970. This becomes a little more useful when you you need to get the difference between two specific dates:

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
$loomPast = Loom::make()->fromDateTime(new \DateTime('now - 5 days'));
$loomFuture = Loom::make()->fromDateTime(new \DateTime('now + 10 days'));

var_dump($loomPast->since()->getHours());       // Returns 120.
var_dump($loomFuture->until()->getHours());     // Returns 240.
```

The `since()` and `until()` methods simply do a `diff()` on the two Loom objects, and since the `diff()` method will
always return a positive number, the `since()` and `until()` methods are actually identical. They exist simply to help make your code a little more readable.


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
Loom provides a way to check if a unit falls between two other units. The `isBetween` method takes two Loom objects which means you can use any of the creation methods:

```php
$loom = Loom::make()->fromSeconds(100);
if ($loom->isBetween(
	Loom::make()->fromMinutes(1),
	Loom::make()->fromMinutes(2)
)) {
	echo 'Hooray!';
}
```

The `isBetween` method is also accepts a second boolean parameter to specify if the the limits should be inclusive or exclusive. By default, `isBetween` is exclusive of the limits. In otherwords, if the value you are checking is equal to the upper limit, the result will be `false`.

You can get `isBetween` to include the limits in the comparrison by passing a boolean `true` as the third parameter:

```php
$loom = Loom::make()->fromSeconds(120);

// Default is exclusive. Returns false.
var_dump($loom->isBetween(
	Loom::make()->fromMinutes(1),
	Loom::make()->fromMinutes(2)
));	

// Inclusive. Returns true.
var_dump($loom->isBetween(
	Loom::make()->fromMinutes(1),
	Loom::make()->fromMinutes(2),
	true
));

```


### Simple Arithmetic

You can perform some simple arithmetic through the `add()` and `sub()` methods:

```php
	$loom = Loom::make()->fromMinutes(2);
	$loom->add(Loom::make()->fromSeconds(30));
	var_dump($loom->getSeconds())			// 150
	
	$loom->sub(Loom::make()->fromHours(1));
	var_dump($loom->getMilliseconds);		// 0
```

A `Loom` object can never have a negative value. Subtracting a larger Loom from a smaller one will always result in 0.

The arithmetic methods will accept an instance of `AbstractUnit`, so you don't need to create another `Loom` object. You can just pass the unit into the methods:

```php
	$loom = Loom::make()->fromMinutes(2);
	$loom->add(new Loom\Seconds(60));
	var_dump($loom->getSeconds());		// 180
	
	$loom->sub(new Loom\Minutes(2));
	var_dump($loom->getSeconds());		// 60
```


## Loom Collections
A new `LoomCollection` class is currently in development and is available on the `develop` branch. Loom Collections are based on the Laravel `Collection` class, but with some _Loomness_ built in.

The new `LoomCollection` class constructor accepts an array of Loom objects, but you can also create an empty collection:

```php
$collection = new Loom\LoomCollection();
```

Loom Collections can only contain `Loom` objects. You'll get an exception if you try add anything else.

### Push, Pop, Prepend, Shift
Manipulating the contents of a `LoomCollection` is quite simple. Use the `push` method to push a new Loom object onto the end of the collection, the `pop` method to pull the last Loom object, the `prepend` method to insert a Loom object onto the beginning of the collection and `shift` to pull the first objct.

```php
// Add to the end of the collection
$collection->push(new Loom::make()->fromMinutes(4));
// Add to the beginning of the collection
$collection->prepend(new Loom::make()->fromMinutes(10));

// Pull the last object from the collection
$loom = $collection->pop();
// Pull the first object from the collection
$loom = $collection->shift();
```

### Finding
Loom provides a simple way to grab single Loom objects from the collection. You can always get the first Loom object by using the `first()` method. In the same manner, the `last()` method will always return the last object in the collection.

```php
$first = $collection->first();
$last = $collection->last();
```

Unlike `pop()` and `shift()`, these methods do not alter the collection and only return the Loom object.

Sometimes, you might need to get the shortest, or longest Loom object. You can use the `shortest()` and `longest()` methods to do just that. There is also an `earliest()` method, which is just an alias for `shortest`, and a `latest()`, which is an alias for `longest`.

```php
$shortest = $collection->shortest();
$longest = $collection->longest();
```

### Filtering
No collections class would be complete without the ability to filter the contents of a collection. The best place to start is the `filter` method which accepts a closure. The Loom objects are passed as parameters to the closure. If the closure returns a boolean `true` then that object is included in the filtered results:

```php
$filtered = $collection->filter(function(Loom $loom)
{
    return $loom->gt(Loom::make()->fromMinutes(6);
});
```

However, Loom also includes a few extra filter methods that make this process easier. The `after()` method will return all the Loom objects that occure after the specified Loom, and the `before()` method will return lla the objects that occure before the specified Loom.

```php
// After
$newCollection = $collection->after(Loom::make()->fromMinutes(8));

// Before
$newCollection = $collection->before(Loom::make()->fromMinutes(6));
```

There is also a `between()` method that will return objects that occure between the specified start and end Looms.

```php
$newCollection = $collection->between(
    Loom::make()->fromMinutes(5),
    Loom::make()->fromHours(1)
);    
```

### Iterating
The `LoomCollection` class also includes an `each()` method which accepts a closure to which is passed each Loom in the collection.

```php
$newCollection = $collection->each(function(Loom $loom)
{
    echo $loom->getMinutes();
});
```

### Sorting
The collection can also be sorted using the appropriately named `sort()` method. By default `sort()` will sort the collection ascending (smallest Loom first), but you can invert the sort by passing a boolean `true` as parameter.

```php
// Ascending
$sorted = $collection->sort();

// Descending
$sorted = $collection->sort(true);
```

## Ranges
Loom provides an interesting feature which allows you to create a range of Loom objects. Ranges are always returned as Loom Collections. Creating a range is fairly simple. Instead of calling the `make()` static method, there is now a `makeRange()` static method on the `Loom` class. You can pass a single Loom object to the `from()` method, and one to the `to()` method. The `steps()` method takes an integer parameter and returns a new `LoomCollection` instance:

```php
$range = Loom::makeRange()
    ->from(Loom::make()->fromSeconds(1))
    ->to(Loom::make()->fromSeconds(10))
    ->steps(10);
```

This will return a new `LoomCollection` consisting of 10 Loom objects. The first one being 1 seconds, and the last one being 10 seconds.
