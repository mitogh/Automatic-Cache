<?php
if ( ! function_exists( 'on_cache_please' ) ){
	/**
	 * Function to storage the cache on automatic.
	 * @since 1.0.0
	 * @param
	 */
	function on_cache_please( array $args = array() ) {
		$args = is_array( $args ) ? $args : array();
		$args = wp_parse_args( $args, array(
			'name' => '',
			'callback' => false,
			'duration' => HOUR_IN_SECONDS,
		));

		$data = get_transient( $args['name'] );
		if( $data === false ){
			if ( is_callable( $args['callback'] ) ) {
				$data = call_user_func( $args['callback'] );
				set_transient( $args['name'], $data, $args['duration'] );
			}
		}
		return $data;
	}
}
