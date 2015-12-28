# On Cache Please [![Build Status](https://travis-ci.org/mitogh/On-Cache-Please.svg?branch=master)](https://travis-ci.org/mitogh/On-Cache-Please)

> Because programmers are to lazy to write repeated code, this
 utility automatically storages the data of a callback in a transient to
faster access the next time the data is accessed.  

## Description

This utility can help you to create faster cache storage of expensive
external request or hard work into the DB to faster access the next
time, to retrive the value from a cache rather than the function, this
library make uses of [transient api](https://codex.wordpress.org/Transients_API) to save the
data from the requests into the DB.

## Requirements.

- WordPress   
- PHP 5.3 >=   

## Installation. 

The easiest way to install this library is using composer, in order to
add this library as a dependency for your composer file you only need to
run in your terminal:

```php
composer require mitogh/on-cache-please
```

To retrive the library from [packagist](https://packagist.org/packages/mitogh/on-cache-please). This will
add the on-cache-please library as a dependency in your `composer.json`
file.

## Methods and Properties

Here are listed only the public methods that are available to be used
from the outside of the library.

### OnCache::please

This static method is the public way to storaged the data from a
function in a transient by a determined amount of time in order to
decrease the number of request and download time.

**Parameters**  

You can pass an `array` of arguments to the method `please` in order to
update some default values and some required params as well.

- `name` *(string)* - required. This is a required param since we need a value to
identify the transient, where the data is going to be stored.
- `callback` *(string|function)* - required. The function or name of the
  function to execute, in this function you can do expensive things like
an http external request or a instagram API call, just make sure to
return the data you want to save on the cache, the returned value will
be storead in the transient.
- `duration` *(int)* - optional. 1 hour by default. This value can be any
  integer number and represents the life of the transient in seconds
before execute the `callback` again and update the transient, there are
few [few already defined](https://codex.wordpress.org/Transients_API#Using_Time_Constants).
constants that migh help you.

### Example

```php
// This line is only useful if you installed the library with composer.
include './vendor/autoload.php';
$args = array(
    'name' => 'codepen_jobs',
	'callback' => function(){
		$url = 'http://codepen.io/jobs.json';
		return wp_remote_retrieve_body( wp_remote_get( $url ) );
	},
);
$jobs = mitogh\OnCache::please( $args );
```
