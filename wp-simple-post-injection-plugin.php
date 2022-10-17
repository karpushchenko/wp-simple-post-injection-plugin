<?php
/**
Plugin Name: WordPress Simple Post Injection
Plugin URI:  https://github.com/karpushchenko/wp-simple-post-injection-plugin
Description: Show your 3 oldest posts on any page
Version:     1.0.0
Author:      Ivan Karpushchenko
Author URI:  mailto:theblackkarps@gmail.com

@package wpspi
 */

// define constants of the plugin_name.
define( 'WPSPI_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'WPSPI_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// add the required class file.
require 'includes/class-wpspi-plugin.php';

/**
 * Plugin initialization
 *
 * @return void
 */
function wpspi_plugin_init() {
	// instantiate the plugin class.
	$plugin = new Wpspi_Plugin();

	// start the execution of the plugin class-base-project.
	$plugin->run();
}

wpspi_plugin_init();
