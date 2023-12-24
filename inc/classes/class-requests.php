<?php
/**
 * LoadmorePosts
 *
 * @package GravityformsFlutterwaveAddons
 */
namespace FUTUREWORDPRESS_PROJECT_CORE\Inc;
use FUTUREWORDPRESS_PROJECT_CORE\Inc\Traits\Singleton;
use \WP_Query;
class Requests {
	use Singleton;
	public $api_key = null;
	public $base_url = null;
	public $base_ajax = null;
	protected function __construct() {
		// load class.
		$this->setup_hooks();
	}
	protected function setup_hooks() {
		add_action('wp_ajax_futurewordpress/projects/ajax/corn/token', [$this, 'remote_site_corn_token'], 10, 0);
		add_action('wp_ajax_nopriv_futurewordpress/projects/ajax/corn/token', [$this, 'remote_site_corn_token'], 10, 0);
	}
	public function remote_site_corn_token() {
		$json = ['hooks' => ['corn_token_failed'], 'message' => __('Something went wrong', 'domain')];
		/**
		 * Register Sites those are using our Projects.
		 */
		if(isset($_GET['tosite']) && !empty($_GET['tosite'])) {
			// if(isset($_GET['project']) && !empty($_GET['project'])) {}
			/**
			 * @return response
			 */
			$json['hooks'] = ['corn_token_success'];
			unset($json['message']);
			wp_send_json_success($json);
		}
		wp_send_json_error($json);
	}

}
