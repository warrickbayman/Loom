# Loom

[![image](http://img.shields.io/travis/warrickbayman/Loom.svg?style=flat)](https://travis-ci.org/warrickbayman/Incus)
[![image](http://img.shields.io/badge/license-MIT-blue.svg?style=flat)](http://opensource.org/licenses/mit)

Loom is a super simple way to work with units of time (hours, minutes, seconds, etc).

## Installation
Install Loom via Composer, but adding to the `requires` section of your `composer.json` file.

```json
{
	"require": {
		"warrickbayman/loom": "dev-master"
	}
}
```

Run `composer update` in your project route to install Loom into your project.

## Use

### Creating a new Loom object

Start by creating a new Loom object:

```php
$fabric = new Loom\Loom(new Loom\Seconds(100));
```

To avoid having to use the `Loom` namespace each time, you could add it to your `use` clause:

```php
use Loom\Loom;
use Loom\Seconds;

class MyFabricClass
{
	public function translate()
	{
		$fabric = new Loom(new Seconds(100));
	}
}
```

### Translations

Firstly, Loom provides some simple ways to translate from one unit to another.

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

Each of the getters returns a float.

__NOTE__: The `getMonths()` method averages the number of days per month in a year, so results can be unexpected:

```php
$loom = new Loom(new Days(30));
var_dump($loom->getMonths());		// Returns 0.98630136986301
```	

The reverse will also perform the same averaging:

```php
$loom = new Loom(new Months(1));
var_dump($loom->getDays());			// Returns 30.416666666667
```


### Difference

You can use the `diff()` method to get the difference between to Loom objects. The `diff()` method returns a third Loom object.

```php
$loom1 = new Loom(new Days(1));
$loom2 = new Loom(new Hours(48));

$diff = $loom1->diff($loom2);

var_dump($diff->getHours());		// Returns 24.
```

It doesn't matter which object use call the `diff()` method on. The result will be the same either way.

### Comparisons

A number of comparison methods also exist:

```php
$loom1 = new Loom(new Days(1));
$loom2 = new Loom(new Hours(48));

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