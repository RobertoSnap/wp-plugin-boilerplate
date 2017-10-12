<?php

namespace MyPluginNamespace;

final class Plugin {

	protected $loader;
	protected $name;
	protected $version;
	protected $slug;
	protected $dir_path;
	protected $url_path;


	/**
	 * Define the core functionality of the plugin.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 */
	public function __construct($plugin_data) {
		$this->loader 	= new Loader();
		$this->set_plugin_data($plugin_data);

	}
	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 */
	private function set_locale() {
		$plugin_i18n = new I18n();
		$plugin_i18n->set_domain( $this->get_name() );
		$plugin_i18n->load_plugin_textdomain();
	}
	/**
	 * Register all of the hooks related to the dashboard functionality
	 * of the plugin.
	 */
	private function define_admin_hooks() {
		$plugin_admin = new Admin( $this );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
	}
	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 */
	private function define_frontend_hooks() {
		$plugin_frontend = new Frontend( $this );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_frontend, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_frontend, 'enqueue_scripts' );
	}
	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * Load the dependencies, define the locale, and set the hooks for the Dashboard and
	 * the public-facing side of the site.
	 */
	public function run() {
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_frontend_hooks();
		$this->loader->run();
		//Start adding plugin files here
		new \MyPluginNamespace\Ajax( $this );
		new \MyPluginNamespace\Settings( $this );
		new \MyPluginNamespace\Tools( $this );
	}
	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 */
	public function get_name() {
		return $this->name;
	}
	/**
	 * Retrieve the version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Retrieve the version number of the plugin.
	 */
	public function get_slug() {
		return $this->slug;
	}
	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 */
	public function get_path() {
		//return plugin_dir_path( __DIR__ );
		return $this->dir_path;
	}
	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	private function set_plugin_data($plugin_data) {
		$this->name = $plugin_data['plugin_name'];
		$this->version = $plugin_data['version'];
		$this->slug = $plugin_data['slug'];
		$this->dir_path = $plugin_data['plugin_dir'];
		$this->url_path = $plugin_data['plugin_url'];
	}
}