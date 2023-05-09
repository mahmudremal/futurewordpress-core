<?php
/**
 * Enqueue theme assets
 *
 * @package FutureWordPressProjectCore
 */

namespace FUTUREWORDPRESS_PROJECT_CORE\Inc;
use FUTUREWORDPRESS_PROJECT_CORE\Inc\Traits\Singleton;
class Assets {
	use Singleton;
	protected function __construct() {
		// load class.
		$this->setup_hooks();
	}
	protected function setup_hooks() {
		/**
		 * Actions.
		 */
		add_action( 'wp_enqueue_scripts', [ $this, 'register_styles' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'register_scripts' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'wp_denqueue_scripts' ], 99 );
		/**
		 * The 'enqueue_block_assets' hook includes styles and scripts both in editor and frontend,
		 * except when is_admin() is used to include them conditionally
		 */
		// add_action( 'enqueue_block_assets', [ $this, 'enqueue_editor_assets' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ], 10, 1 );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_denqueue_scripts' ], 99 );
		add_filter( 'futurewordpress/project/core/javascript/siteconfig', [ $this, 'siteConfig' ], 1, 1 );
	}
	public function register_styles() {
		// Register styles.
		wp_register_style( 'FutureWordPressProjectCore', FUTUREWORDPRESS_PROJECT_CORE_BUILD_CSS_URI . '/public.css', [], $this->filemtime( FUTUREWORDPRESS_PROJECT_CORE_BUILD_CSS_DIR_PATH . '/public.css' ), 'all' );
		wp_enqueue_style( 'FutureWordPressProjectCore' );
	}
	public function register_scripts() {
		// Register scripts.
		wp_register_script( 'FutureWordPressProjectCore', FUTUREWORDPRESS_PROJECT_CORE_BUILD_JS_URI . '/public.js?v=' . $this->filemtime( FUTUREWORDPRESS_PROJECT_CORE_BUILD_JS_DIR_PATH . '/public.js' ), ['jquery'], $this->filemtime( FUTUREWORDPRESS_PROJECT_CORE_BUILD_JS_DIR_PATH . '/public.js' ), true );
		wp_enqueue_script( 'FutureWordPressProjectCore' );
		wp_localize_script( 'FutureWordPressProjectCore', 'fwpSiteConfig', apply_filters( 'futurewordpress/project/core/javascript/siteconfig', [
		] ) );
	}
	private function allow_enqueue() {
		return true; // ( function_exists( 'is_checkout' ) && ( is_checkout() || is_order_received_page() || is_wc_endpoint_url( 'order-received' ) ) );
	}
	/**
	 * Enqueue editor scripts and styles.
	 */
	public function enqueue_editor_assets() {
		$asset_config_file = sprintf( '%s/assets.php', FUTUREWORDPRESS_PROJECT_CORE_BUILD_PATH );
		if ( ! file_exists( $asset_config_file ) ) {
			return;
		}
		$asset_config = require_once $asset_config_file;
		if ( empty( $asset_config['js/editor.js'] ) ) {
			return;
		}
		$editor_asset    = $asset_config['js/editor.js'];
		$js_dependencies = ( ! empty( $editor_asset['dependencies'] ) ) ? $editor_asset['dependencies'] : [];
		$version         = ( ! empty( $editor_asset['version'] ) ) ? $editor_asset['version'] : $this->filemtime( $asset_config_file );
		// Theme Gutenberg blocks JS.
		if ( is_admin() ) {
			wp_enqueue_script(
				'aquila-blocks-js',
				FUTUREWORDPRESS_PROJECT_CORE_BUILD_JS_URI . '/blocks.js',
				$js_dependencies,
				$version,
				true
			);
		}
		// Theme Gutenberg blocks CSS.
		$css_dependencies = [
			'wp-block-library-theme',
			'wp-block-library',
		];
		wp_enqueue_style(
			'aquila-blocks-css',
			FUTUREWORDPRESS_PROJECT_CORE_BUILD_CSS_URI . '/blocks.css',
			$css_dependencies,
			$this->filemtime( FUTUREWORDPRESS_PROJECT_CORE_BUILD_CSS_DIR_PATH . '/blocks.css' ),
			'all'
		);
	}
	public function admin_enqueue_scripts( $curr_page ) {
		global $post;
		// if( ! in_array( $curr_page, [ 'edit.php', 'post.php' ] ) || 'shop_order' !== $post->post_type ) {return;}
		wp_register_style( 'FutureWordPressProjectCoreBackend', FUTUREWORDPRESS_PROJECT_CORE_BUILD_CSS_URI . '/admin.css', [], $this->filemtime( FUTUREWORDPRESS_PROJECT_CORE_BUILD_CSS_DIR_PATH . '/admin.css' ), 'all' );
		wp_register_script( 'FutureWordPressProjectCoreBackend', FUTUREWORDPRESS_PROJECT_CORE_BUILD_JS_URI . '/admin.js', [ 'jquery' ], $this->filemtime( FUTUREWORDPRESS_PROJECT_CORE_BUILD_JS_DIR_PATH . '/admin.js' ), true );
		wp_enqueue_style( 'FutureWordPressProjectCoreBackend' );
		wp_enqueue_script( 'FutureWordPressProjectCoreBackend' );
		if( isset( $_GET[ 'page' ] ) && in_array( $_GET[ 'page' ], apply_filters( 'futurewordpress/project/core/admin/allowedpage', [] ) ) ) {
			wp_enqueue_style( 'FutureWordPressProjectCoreBackend' );wp_enqueue_script( 'FutureWordPressProjectCoreBackend' );
		}
		wp_localize_script( 'FutureWordPressProjectCoreBackend', 'fwpSiteConfig', apply_filters( 'futurewordpress/project/core/javascript/siteconfig', [] ) );
	}
	private function filemtime( $file ) {
		return apply_filters( 'futurewordpress/project/core/filesystem/filemtime', false, $file );
	}
	public function siteConfig( $args ) {
		$tawkalw = (
			apply_filters( 'futurewordpress/project/core/system/isactive', 'chat-enable' ) &&
			! apply_filters( 'futurewordpress/project/core/system/isactive', 'chat-onlysite' ) ||
			(
				is_singular() && in_array( get_the_ID(), explode( ',', apply_filters( 'futurewordpress/project/core/system/getoption', 'chat-pages', '' ) ) )
			)
		);
		return wp_parse_args( [
			'ajaxUrl'    		=> admin_url( 'admin-ajax.php' ),
			'ajax_nonce' 		=> wp_create_nonce( 'futurewordpress/project/core/verify/nonce' ),
			'is_admin' 			=> is_admin(),
			'buildPath'  		=> FUTUREWORDPRESS_PROJECT_CORE_BUILD_URI,
			'tawkid'				=> apply_filters( 'futurewordpress/project/core/system/getoption', 'chat-id', '' ),
			'tawkalw'				=> $tawkalw,
			'i18n'					=> [
			],
		], (array) $args );
	}
	public function wp_denqueue_scripts() {}
	public function admin_denqueue_scripts() {
		if( ! isset( $_GET[ 'page' ] ) ||  $_GET[ 'page' ] !='crm_dashboard' ) {return;}
		wp_dequeue_script( 'qode-tax-js' );
	}
}
