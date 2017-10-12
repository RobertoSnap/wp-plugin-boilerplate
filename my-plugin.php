<?php
/**
 * Plugin Name:       My plugin
 * Plugin URI:        https://brewoocommerce.com
 * Description:       A description of my plugin
 * Version:           0.0.1
 * Author:            Robin Pedersen
 * Author URI:        https://brewoocommerce.com
 * Text Domain:       my-plugin
 * Domain Path:       /languages
 *
 *
 */
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in src/Activator.php
 */
\register_activation_hook( __FILE__, '\MyPluginNamespace\Activator::activate' );

/**
 * The code that runs during plugin deactivation.
 * This action is documented in src/Deactivator.php
 */
\register_deactivation_hook( __FILE__, '\MyPluginNamespace\Deactivator::deactivate' );


/**
 * Begins execution of the plugin.
 */
\add_action( 'plugins_loaded', function () {
	//Get information about plugin
	$plugin_file_data = get_file_data( __FILE__, array( 'Plugin Name', 'Version', 'Text Domain' ) );
	$plugin_data = array();
	$plugin_data['plugin_name'] = array_shift( $plugin_file_data );;
	$plugin_data['version'] = array_shift( $plugin_file_data );;
	$plugin_data['slug'] = array_shift( $plugin_file_data );;
	$plugin_data['plugin_dir'] = trailingslashit( plugin_dir_path( __FILE__ ) );
	$plugin_data['plugin_url'] = trailingslashit( plugin_dir_url( __FILE__ ) );
	//Start the plugin
	$plugin = new \MyPluginNamespace\Plugin( $plugin_data );
	$plugin->run();
} );