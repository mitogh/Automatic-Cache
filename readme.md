# On Cache Please

> Because programmers are to lazy to write code repeated code, this
 utility helps to avoid to review a transient before the creation it
 does that automatically.

## Description

This utility can help you to create faster cache storage of hard
external request or hard work into the DB to faster access, you can
define different durations for the cache, see the duration paramater.

## Requirements.

As a note this utility it's for use in WordPress development of any
kind, plugins themes or anything (because uses some WP functions). It
helps to avoid the review of transients before save them. 

## Parameters

- name *(string)* - required. THe name of the cache, this can be used to identify
  the cache.
- callback *(string|function)* - required. The function or name of the
  function to execute, the function must return the value that needs to
be storaged on cache.
- duration *(int)* - optional. 1 hour by default. This value can be any
  integer number and represents the value in seconds to storage the
request. There are [few already defined](https://codex.wordpress.org/Transients_API#Using_Time_Constants). Use 0 
to never delete the cache.

## Examples

This example only works on version of `PHP` `5.3.0`. Because use closures
as the callback.

```php
$jobs = on_cache_please( array(
	'name' => 'CODEPEN_JOBS_LIST',
	'callback' => function(){
		$url = 'http://codepen.io/jobs.json';
		return wp_remote_retrieve_body( wp_remote_get( $url ) );
	},
    'duration' => WEEK_IN_SECONDS,
));
```

Same example on lower versions of `PHP`.

```php
function request_jobs(){
    $url = 'http://codepen.io/jobs.json';
    return wp_remote_retrieve_body( wp_remote_get( $url ) );
}
$jobs = on_cache_please( array(
	'name' => 'CODEPEN_JOBS_LIST',
	'callback' => 'request_jobs',
    'duration' => WEEK_IN_SECONDS,
));
```

