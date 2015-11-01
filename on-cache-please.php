<?php
/**
 * Saves in cache using transient function of wordpress a request using callbacks
 * similar as wordpress does. Works only for WP.
 *
 * @package on-cache-please
 * @since 1.0.0
 */

if ( ! function_exists( 'on_cache_please' ) ) {
	/**
	 * Function to storage the cache on automatic.
	 *
	 * @since 1.0.0
	 * @param array $args {
	 *		An array of arguments.
	 *		@type string $key name. The name of the transient of the request.
	 *		@type string $key callback. The name of the function or the function
	 *									to execute that returns the data.
	 *		@type int    $key duration. The duration of the cache.
	 * }
	 */
	function on_cache_please( array $args = array() ) {
		$args = is_array( $args ) ? $args : array();
		$args = wp_parse_args( $args, array(
			'name' => '',
			'callback' => false,
			'duration' => HOUR_IN_SECONDS,
		));

		$data = get_transient( $args['name'] );
		if ( false === $data ) {
			if ( is_callable( $args['callback'] ) ) {
				$data = call_user_func( $args['callback'] );
				set_transient( $args['name'], $data, $args['duration'] );
			}
		}
		return $data;
	}
}
