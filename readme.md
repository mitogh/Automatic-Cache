# On Cache Please

> Because programmers are to lazy to write code repeated code, this
 utility helps to avoid to review a transient before the creation it
 does that automatically.

## Requirements.

As a note this utility it's for use in WordPress development of any
kind, plugins themes or anything (because uses some WP functions). It
helps to avoid the review of transients before save them. 

## Examples

This example only works on version of `PHP 5.3.0`. Because use closures
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

Same example on lower versions of PHP.

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
