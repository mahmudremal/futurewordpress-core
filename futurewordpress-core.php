<?php
/**
 * This Plugin ordered by a client and done by Remal Mahmud (fiverr.com/mahmud_remal). Authority dedicated to that cient.
 *
 * @wordpress-plugin
 * Plugin Name:       FutureWordPress Core Project
 * Plugin URI:        https://github.com/mahmudremal/futurewordpress-project-core/
 * Description:       Plugin build for futurewordpress.com. Working for only this site for supporting additional functionalities and stuffs.
 * Version:           1.0.2
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Remal Mahmud
 * Author URI:        https://github.com/mahmudremal/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       futurewordpress-project-core-domain
 * Domain Path:       /languages
 * 
 * @package FutureWordPressScratchProject
 * @author  Remal Mahmud (https://github.com/mahmudremal)
 * @version 1.0.2
 * @link https://github.com/mahmudremal/futurewordpress-project-core/
 * @category	WooComerce Plugin
 * @copyright	Copyright (c) 2023-25
 * 
 */

/**
 * Bootstrap the plugin.
 */



defined( 'FUTUREWORDPRESS_PROJECT_CORE__FILE__' ) || define( 'FUTUREWORDPRESS_PROJECT_CORE__FILE__', untrailingslashit( __FILE__ ) );
defined( 'FUTUREWORDPRESS_PROJECT_CORE_DIR_PATH' ) || define( 'FUTUREWORDPRESS_PROJECT_CORE_DIR_PATH', untrailingslashit( plugin_dir_path( FUTUREWORDPRESS_PROJECT_CORE__FILE__ ) ) );
defined( 'FUTUREWORDPRESS_PROJECT_CORE_DIR_URI' ) || define( 'FUTUREWORDPRESS_PROJECT_CORE_DIR_URI', untrailingslashit( plugin_dir_url( FUTUREWORDPRESS_PROJECT_CORE__FILE__ ) ) );
defined( 'FUTUREWORDPRESS_PROJECT_CORE_BUILD_URI' ) || define( 'FUTUREWORDPRESS_PROJECT_CORE_BUILD_URI', untrailingslashit( FUTUREWORDPRESS_PROJECT_CORE_DIR_URI ) . '/assets/build' );
defined( 'FUTUREWORDPRESS_PROJECT_CORE_BUILD_PATH' ) || define( 'FUTUREWORDPRESS_PROJECT_CORE_BUILD_PATH', untrailingslashit( FUTUREWORDPRESS_PROJECT_CORE_DIR_PATH ) . '/assets/build' );
defined( 'FUTUREWORDPRESS_PROJECT_CORE_BUILD_JS_URI' ) || define( 'FUTUREWORDPRESS_PROJECT_CORE_BUILD_JS_URI', untrailingslashit( FUTUREWORDPRESS_PROJECT_CORE_DIR_URI ) . '/assets/build/js' );
defined( 'FUTUREWORDPRESS_PROJECT_CORE_BUILD_JS_DIR_PATH' ) || define( 'FUTUREWORDPRESS_PROJECT_CORE_BUILD_JS_DIR_PATH', untrailingslashit( FUTUREWORDPRESS_PROJECT_CORE_DIR_PATH ) . '/assets/build/js' );
defined( 'FUTUREWORDPRESS_PROJECT_CORE_BUILD_IMG_URI' ) || define( 'FUTUREWORDPRESS_PROJECT_CORE_BUILD_IMG_URI', untrailingslashit( FUTUREWORDPRESS_PROJECT_CORE_DIR_URI ) . '/assets/build/src/img' );
defined( 'FUTUREWORDPRESS_PROJECT_CORE_BUILD_CSS_URI' ) || define( 'FUTUREWORDPRESS_PROJECT_CORE_BUILD_CSS_URI', untrailingslashit( FUTUREWORDPRESS_PROJECT_CORE_DIR_URI ) . '/assets/build/css' );
defined( 'FUTUREWORDPRESS_PROJECT_CORE_BUILD_CSS_DIR_PATH' ) || define( 'FUTUREWORDPRESS_PROJECT_CORE_BUILD_CSS_DIR_PATH', untrailingslashit( FUTUREWORDPRESS_PROJECT_CORE_DIR_PATH ) . '/assets/build/css' );
defined( 'FUTUREWORDPRESS_PROJECT_CORE_BUILD_LIB_URI' ) || define( 'FUTUREWORDPRESS_PROJECT_CORE_BUILD_LIB_URI', untrailingslashit( FUTUREWORDPRESS_PROJECT_CORE_DIR_URI ) . '/assets/build/library' );
defined( 'FUTUREWORDPRESS_PROJECT_CORE_ARCHIVE_POST_PER_PAGE' ) || define( 'FUTUREWORDPRESS_PROJECT_CORE_ARCHIVE_POST_PER_PAGE', 9 );
defined( 'FUTUREWORDPRESS_PROJECT_CORE_SEARCH_RESULTS_POST_PER_PAGE' ) || define( 'FUTUREWORDPRESS_PROJECT_CORE_SEARCH_RESULTS_POST_PER_PAGE', 9 );
defined( 'FUTUREWORDPRESS_PROJECT_OPTIONS' ) || define( 'FUTUREWORDPRESS_PROJECT_OPTIONS', get_option( 'futurewordpress-project-core-domain' ) );

require_once FUTUREWORDPRESS_PROJECT_CORE_DIR_PATH . '/inc/helpers/autoloader.php';
// require_once FUTUREWORDPRESS_PROJECT_CORE_DIR_PATH . '/inc/helpers/template-tags.php';

if( ! function_exists( 'futurewordpressprojectcore_get_plugin_instance' ) ) {
	function futurewordpressprojectcore_get_plugin_instance() {\FUTUREWORDPRESS_PROJECT_CORE\Inc\Project::get_instance();}
}
futurewordpressprojectcore_get_plugin_instance();



