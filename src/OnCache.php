<?php namespace mitogh;

class OnCache {

	/**
	 * List of the default arguments.
	 *
	 * @since 1.0.0
	 * @access private
	 * @var array $defaults.
	 */
	private static $defaults = array(
		'name' => '',
		'callback' => false,
		'duration' => HOUR_IN_SECONDS,
	);

	/**
	 * Public interface to access to the class, it saves the result of the callback
	 * in a transient after the execution.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args {
	 *		The list of arguments that the user can pass to the function
	 *
	 *		@type string	name		The name of the transient. Default empty string.
	 *		@type function	callback	The callback to be called. Default false.
	 *		@type integer	duration	The duration in seconds to storge the transient. Default: 3600.
	 * }
	 * @return mixed	Returns WP_Error if the arguments are incorrect or the data from the
	 *					execution of the function if success, after the next calls returns the velue from
	 *					the transient.
	 */
	public static function please( array $args = array() ) {
		$args = self::parse_args( $args );
		if ( ! self::has_valid_( $args ) ) {
			return new \WP_Error( 'broke', 'The arguments are not valid, please verify.' );
		}

		$data = get_transient( $args['name'] );
		if ( false === $data ) {
			$data = call_user_func( $args['callback'] );
			set_transient( $args['name'], $data, $args['duration'] );
		}
		return $data;
	}

	/**
	 * Makes sures that user passes an array as the list of arguments, then
	 * merges both using wp_parse_args and returns the result.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args The list of arguments from the function call.
	 * @return array The merged array with the defaults and the user arguments.
	 */
	private static function parse_args( array $args = array() ) {
		$args = is_array( $args ) ? $args : array();
		return wp_parse_args( $args, self::$defaults );
	}

	/**
	 * Function that runs all of the functions that test if all the list of
	 * arguments are valid, basically the callback and the name for the transient.
	 *
	 * @param array $args The list of arguments as an array.
	 * @return bool true if callback and name are valid.
	 */
	private static function has_valid_( $args ) {
		return self::valid_callback( $args ) && self::valid_name( $args );
	}

	/**
	 * Verify if the callback value exists in the arguments list and if is
	 * callable.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args The list of arguments as an array.
	 * @return bool true if the callback exists ans if is callable.
	 */
	private static function valid_callback( $args ) {
		return isset( $args['callback'] ) && is_callable( $args['callback'] );
	}

	/**
	 * Validate if the name exists and has the required length, this name is
	 * going to be used to identify the transient.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args The list of arguments as an array.
	 * @return bool true if the name exists in $args and beteween 1 and 45 chars.
	 */
	private static function valid_name( $args ) {
		$valid = false;
		if ( isset( $args['name'] ) ) {
			$length = strlen( $args['name'] );
			/**
			 * Should be 45 characters or less in length as WordPress will
			 * prefix your name with "_transient_" or "_transient_timeout_"
			 * in the options table (depending on whether it expires or not).
			 * Longer key names will silently fail.
			 *
			 * @link  http://core.trac.wordpress.org/ticket/15058
			 */
			$valid = $length > 0 && $length <= 45;
		}
		return $valid;
	}
}
