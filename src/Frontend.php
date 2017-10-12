<?php

/**
 * The public-facing functionality of the plugin.
 */

namespace MyPluginNamespace;

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 */
class Frontend {

	/**
	 * The plugin's instance.
	 */
	private $plugin;

	/**
	 * Initialize the class and set its properties.
	 */
	public function __construct( Plugin $plugin ) {
		$this->plugin = $plugin;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 */
	public function enqueue_styles() {
		\wp_register_style( $this->plugin->get_name(), \plugin_dir_url( dirname( __FILE__ ) ) . 'assets/css/style.css', array(), $this->plugin->get_version() );
		\wp_enqueue_style( $this->plugin->get_name() );
	}

	public function enqueue_scripts() {

		\wp_register_script(
			$this->plugin->get_name(),
			\plugin_dir_url( dirname( __FILE__ ) ) . 'assets/js/plugin.min.js',
			array('jquery'),
			$this->plugin->get_version(),
			false);
		\wp_localize_script(
			$this->plugin->get_name(),
			__NAMESPACE__.'Params',
			array(
				'wc_ajax_url' => WC()->ajax_url(),
				'security' => wp_create_nonce("plugin-security")
			)
		);
		\wp_enqueue_script(
			$this->plugin->get_name()
		);


	}

}
