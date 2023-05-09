<?php
/**
 * Register Menus
 *
 * @package FutureWordPressProjectCore
 */
namespace FUTUREWORDPRESS_PROJECT_CORE\Inc;
use FUTUREWORDPRESS_PROJECT_CORE\Inc\Traits\Singleton;
class Menus {
	use Singleton;
	protected function __construct() {
		// load class.
		$this->setup_hooks();
	}
	protected function setup_hooks() {
		/**
		 * Actions.
		 */
		// add_action( 'init', [ $this, 'register_menus' ] );
		
    add_filter( 'futurewordpress/project/core/settings/general', [ $this, 'general' ], 10, 1 );
    add_filter( 'futurewordpress/project/core/settings/fields', [ $this, 'menus' ], 10, 1 );
		add_action( 'in_admin_header', [ $this, 'in_admin_header' ], 100, 0 );
	}
	public function register_menus() {
		register_nav_menus([
			'aquila-header-menu' => esc_html__( 'Header Menu', 'futurewordpress-project-core-domain' ),
			'aquila-footer-menu' => esc_html__( 'Footer Menu', 'futurewordpress-project-core-domain' ),
		]);
	}
	/**
	 * Get the menu id by menu location.
	 *
	 * @param string $location
	 *
	 * @return integer
	 */
	public function get_menu_id( $location ) {
		// Get all locations
		$locations = get_nav_menu_locations();
		// Get object id by location.
		$menu_id = ! empty($locations[$location]) ? $locations[$location] : '';
		return ! empty( $menu_id ) ? $menu_id : '';
	}
	/**
	 * Get all child menus that has given parent menu id.
	 *
	 * @param array   $menu_array Menu array.
	 * @param integer $parent_id Parent menu id.
	 *
	 * @return array Child menu array.
	 */
	public function get_child_menu_items( $menu_array, $parent_id ) {
		$child_menus = [];
		if ( ! empty( $menu_array ) && is_array( $menu_array ) ) {
			foreach ( $menu_array as $menu ) {
				if ( intval( $menu->menu_item_parent ) === $parent_id ) {
					array_push( $child_menus, $menu );
				}
			}
		}
		return $child_menus;
	}
	public function in_admin_header() {
		if( ! isset( $_GET[ 'page' ] ) || $_GET[ 'page' ] != 'crm_dashboard' ) {return;}
		
		remove_all_actions('admin_notices');
		remove_all_actions('all_admin_notices');
		// add_action('admin_notices', function () {echo 'My notice';});
	}
	/**
	 * Supply necessry tags that could be replace on frontend.
	 * 
	 * @return string
	 * @return array
	 */
	public function commontags( $html = false ) {
		$arg = [];$tags = [
			'username', 'sitename', 
		];
		if( $html === false ) {return $tags;}
		foreach( $tags as $tag ) {
			$arg[] = sprintf( "%s{$tag}%s", '<code>{', '}</code>' );
		}
		return implode( ', ', $arg );
	}
	public function contractTags( $tags ) {
		$arg = [];
		foreach( $tags as $tag ) {
			$arg[] = sprintf( "%s{$tag}%s", '<code>{', '}</code>' );
		}
		return implode( ', ', $arg );
	}

  /**
   * WordPress Option page.
   * 
   * @return array
   */
	public function general( $args ) {
		return [
			'page_title'					=> __( 'Core Configuration.', 'futurewordpress-project-core-domain' ),
			'menu_title'					=> __( 'Configuration', 'futurewordpress-project-core-domain' ),
			'role'								=> 'manage_options',
			'slug'								=> 'futurewordpress-project-core-domain',
			'page_header'					=> __( 'Site Configuration Page.', 'futurewordpress-project-core-domain' ),
			'page_subheader'			=> __( 'Additional site configuration page that could customize and extend from here. Instead of editinf child theme and like these stuff.', 'futurewordpress-project-core-domain' ),
			'no_password'					=> __( 'A password is required.', 'futurewordpress-project-core-domain' ),
		];
	}
	public function menus( $args ) {
    // get_FwpOption( 'key', 'default' ) | apply_filters( 'futurewordpress/project/core/system/getoption', 'key', 'default' )
		// is_FwpActive( 'key' ) | apply_filters( 'futurewordpress/project/core/system/isactive', 'key' )
		$args = [];
		$args['standard'] 		= [
			'title'							=> __( 'Live Chat', 'futurewordpress-project-core-domain' ),
			'description'				=> __( 'Configuration for live chatting should be configured from here.', 'futurewordpress-project-core-domain' ),
			'fields'						=> [
				[
					'id' 						=> 'chat-enable',
					'label'					=> __( 'Enable', 'futurewordpress-project-core-domain' ),
					'description'		=> __( 'Enable chat scripts. That will append your chat scripts after body scripts.', 'futurewordpress-project-core-domain' ),
					'type'					=> 'checkbox',
					// 'default'				=> true
				],
				[
					'id' 						=> 'chat-onlysite',
					'label'					=> __( 'Specific Page', 'futurewordpress-project-core-domain' ),
					'description'		=> __( 'Checking this option will prevent importing chat widget on full site and will be allowed on specific pages, those ID should include below.', 'futurewordpress-project-core-domain' ),
					'type'					=> 'checkbox',
					// 'default'				=> true
				],
				[
					'id' 						=> 'chat-pages',
					'label'					=> __( 'Pages ID', 'futurewordpress-project-core-domain' ),
					'description'		=> __( 'The pages IDs separated by comma only which will contain chat widget.', 'futurewordpress-project-core-domain' ),
					'type'					=> 'text',
					'default'				=> ''
				],
				[
					'id' 						=> 'chat-id',
					'label'					=> __( 'Widget ID', 'futurewordpress-project-core-domain' ),
					'description'		=> __( 'The chat widget ID what will replace for Tawk.to', 'futurewordpress-project-core-domain' ),
					'type'					=> 'text',
					'default'				=> ''
				],
				[
					'id' 						=> 'chat-scripts',
					'label'					=> __( 'Scripts', 'futurewordpress-project-core-domain' ),
					'description'		=> __( 'Javascript code for chat.', 'futurewordpress-project-core-domain' ),
					'type'					=> 'textarea',
					'default'				=> ''
				],
			]
		];
		return $args;
	}
}

/**
 * {{client_name}}, {{client_address}}, {{todays_date}}, {{retainer_amount}}
 */
