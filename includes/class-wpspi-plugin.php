<?php
/**
 * This file contains Wpspi_Plugin class
 *
 * @package wpspi
 */

/**
 * Plugin base class
 */
class Wpspi_Plugin {

	// Plugin properties.

	/**
	 * Plugin system name
	 *
	 * @var string
	 */
	protected $plugin_name;
	/**
	 * Plugin version
	 *
	 * @var string
	 */
	protected $version;

	/**
	 * Path to frontend CSS asset
	 *
	 * @var string
	 */
	protected $css_filepath;

	/**
	 * Path to frontend JS asset
	 *
	 * @var string
	 */
	protected $js_filepath;


	/**** Plugin Constructor and Initializer(Run) ****/

	/**
	 * The constructor off the class.
	 * Initializing all the basic components of the plugin.
	 *
	 * @return void
	 */
	public function __construct() {
		// Initialize all the basics components of the plugin.
		$this->plugin_name = 'wpspi';
		$this->version     = '1.0.0';

		$this->css_filepath = 'public/css/style.css';
		$this->js_filepath  = 'public/js/script.js';
	}

	/**
	 * The run method starts the execution of the plugin.
	 *
	 * @return void
	 */
	public function run() {
		$this->add_actions();
		$this->add_filters();
	}

	// Plugin methods.

	/**
	 * A method to add actions
	 *
	 * @return void
	 */
	private function add_actions() {
		// put actions here.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		// Ajax actions for both authorized and anonymous users.
		add_action( 'wp_ajax_wpspi_get_posts', array( $this, 'get_oldest_posts' ) );
		add_action( 'wp_ajax_nopriv_wpspi_get_posts', array( $this, 'get_oldest_posts' ) );
	}

	/**
	 * A method to add filters
	 *
	 * @return void
	 */
	private function add_filters() {
		// put your filters here.
	}

	/**** Hooks methods ****/


	/**
	 * Enqueue plugin scripts
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		if ( is_page() ) {
			// Styles.
			wp_enqueue_style( $this->plugin_name, WPSPI_PLUGIN_URL . $this->css_filepath, false, $this->version );
			// Scripts.
			wp_enqueue_script( $this->plugin_name, WPSPI_PLUGIN_URL . $this->js_filepath, array( 'jquery' ), $this->version, true );
			// Dynamic admin-ajax url.
			wp_localize_script(
				$this->plugin_name,
				'wpspiAjax',
				array(
					'url' => admin_url( 'admin-ajax.php' ),
				)
			);
		}
	}

	/**
	 * Enqueue plugin scripts
	 *
	 * @return void
	 */
	public function get_oldest_posts() {
		// Getting oldest 3 posts.
		$args = array(
			'posts_per_page' => 3,
			'orderby'        => 'date',
			'order'          => 'ASC',
		);

		$query = new WP_Query( $args );

		$data = array();

		// Post loop.
		while ( $query->have_posts() ) {
			$query->the_post();
			// Process gutenberg blocks and add the content to our data array.
			$data[] = do_blocks( get_the_content() );
		}

		// Reset to the Main Query. Reseting the $post.
		wp_reset_postdata();
		wp_send_json_success( $data, 200 );
	}
}
