<?php
/**
 * Block Patterns
 *
 * @package FutureWordPressProjectCore
 */

namespace FUTUREWORDPRESS_PROJECT_CORE\Inc;
use FUTUREWORDPRESS_PROJECT_CORE\Inc\Traits\Singleton;

class Core {
	use Singleton;
	protected function __construct() {
		// load class.
		$this->setup_hooks();
	}
	protected function setup_hooks() {
		add_action( 'wp_footer', [ $this, 'wp_footer' ], 10, 0 );
		add_action( 'template_redirect', [ $this, 'force_ssl' ], 10, 0 );
	}
	public function wp_footer() {
		if( ! apply_filters( 'futurewordpress/project/core/system/isactive', 'chat-enable' ) ) {return;}
		if( ! ( apply_filters( 'futurewordpress/project/core/system/isactive', 'chat-onlysite' ) && is_singular() && in_array( get_the_ID(), explode( ',', apply_filters( 'futurewordpress/project/core/system/isactive', 'chat-pages' ) ) ) ) ) {return;}
		if( ! empty( apply_filters( 'futurewordpress/project/core/system/getoption', 'chat-scripts', '' ) ) ) {
			echo apply_filters( 'futurewordpress/project/core/system/getoption', 'chat-scripts', '' );
		}
	}
	public function force_ssl() {
		if( ! is_ssl() ) {
			wp_redirect( 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );exit();
		}
	}
}
