# On Cache Please 
[![Build Status](https://travis-ci.org/mitogh/On-Cache-Please.svg?branch=master)](https://travis-ci.org/mitogh/On-Cache-Please)

> Because programmers are to lazy to write repeated code, this
 utility automatically storages the data of a callback in a transient to
faster access the next time the data is accessed. 

## Description

This utility can help you to create faster cache storage of hard
external request or hard work into the DB to faster access, you can
define different durations for the cache, see the duration paramater.

## Requirements.

- WordPress   
- PHP 5.3 >=   

## Parameters

- `name` *(string)* - required. THe name of the cache, this can be used to identify
  the cache.
- `callback` *(string|function)* - required. The function or name of the
  function to execute, the function must return the value that needs to
be storaged on cache.
- `duration` *(int)* - optional. 1 hour by default. This value can be any
  integer number and represents the value in seconds to storage the request. 
  There are
  [few already defined](https://codex.wordpress.org/Transients_API#Using_Time_Constants). 

## Example

```php
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
