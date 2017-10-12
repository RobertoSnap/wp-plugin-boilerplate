<?php

/**
 * The dashboard-specific functionality of the plugin.
 */

namespace MyPluginNamespace;

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 */
class Admin {

	/**
	 * The plugin's instance.
	 */
	protected $plugin;

	/**
	 * Initialize the class and set its properties.
	 */
	public function __construct( Plugin $plugin ) {
		$this->plugin = $plugin;

	}


	/**
	 * Register the stylesheets for the Dashboard.
	 */
	public function enqueue_styles() {
		\wp_register_style( $this->plugin->get_name() . '-admin', \plugin_dir_url( dirname( __FILE__ ) ) . 'assets/css/style-admin.css', array(), $this->plugin->get_version() );
		\wp_enqueue_style( $this->plugin->get_name() . '-admin' );

	}

	/**
	 * Register the JavaScript for the dashboard.
	 */
	public function enqueue_scripts() {

		\wp_register_script(
			$this->plugin->get_name() . '-admin',
			\plugin_dir_url( dirname( __FILE__ ) ) . 'assets/js/plugin-admin.min.js',
			array( 'jquery' ),
			$this->plugin->get_version(),
			false );
		\wp_localize_script(
			$this->plugin->get_name() . '-admin',
			__NAMESPACE__.'ParamsAdmin',
			array(
				'wc_ajax_url'           => WC()->ajax_url(),
				'security'              => wp_create_nonce( "plugin-security" ),
			)
		);
		\wp_enqueue_script(
			$this->plugin->get_name() . '-admin'
		);
	}


}
