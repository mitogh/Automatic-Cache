<?php
class Automatic_Cache {

	protected $default = array(
		'name' => '',
		'callback' => false,
		'duration' => HOUR_IN_SECONDS,
	);

	protected $args = array();

	public $data = false;

	public function __construct( array $args = array() ){
		$this->args = wp_parse_args( $args, $this->default );
	}

	public function run(){
		$this->retrieve_cache();
		if( $this->data === false ){
			$this->do_user_action();
			$this->update_cache();
		}
		return $this->data;
	}

	protected function retrieve_cache(){
		$this->data = get_transient( $this->args['name'] );
	}

	protected function update_cache(){
		set_transient( $this->args['name'], $this->data, $this->args['duration'] );
	}

	protected function do_user_action(){
		if ( is_callable( $this->args['callback'] ) ) {
			$this->data = call_user_func( $this->args['callback'] );
		}
	}

	public function flush(){
		delete_transient( $this->args['name'] );
	}
}
