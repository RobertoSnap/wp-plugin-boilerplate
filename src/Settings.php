<?php


namespace MyPluginNamespace;


class Settings {
	protected $plugin;
	protected $setting_name;
	protected $tab_name;
    protected $carrier_products = array();


	public function __construct($plugin) {
		$this->plugin = $plugin;
		//Add underscore for more readable options
		$this->setting_name = \str_replace('-', '_', $this->plugin->get_slug());
		//Replace bindings with space for nice name
		$this->tab_name = $this->plugin->get_name();
		\add_filter('woocommerce_settings_tabs_array', array($this, 'addSettingsTab'), 90);
		\add_action('woocommerce_settings_tabs_'.$this->setting_name.'_tab', array($this, 'settingsTab'));
		\add_action('woocommerce_update_options_'.$this->setting_name.'_tab', array($this, 'updateSettings'));
	}

	public function addSettingsTab($settings_tabs) {
        $tab_name = $this->setting_name.'_tab';
		$settings_tabs[$tab_name] = $this->tab_name;
		return $settings_tabs;
	}

	public function settingsTab() {
		if ( ! current_user_can( 'manage_options' ) ) {
			_e('You dont have permission to manage options. Please contact site administrator','my-plugin');
			return;
		}

        \woocommerce_admin_fields($this->setup_settings());

	}

    public function updateSettings()
    {

        \woocommerce_update_options($this->setup_settings());


    }

    /*Copy this function to add more sections of settings. Then add a reference to it inn settingsTab() and updateSettings()*/
    public function setup_settings(){
    	$setting_prefix = $this->setting_name.'_'.__FUNCTION__.'_';
        $settings = array(
            'section_title' => array(
                'name' => __( 'Setup', 'my-plugin' ),
                'type' => 'title',
                'id'   => $setting_prefix.'section_title'
            ),
            array(
                'name' => __('Text option', 'my-plugin'),
                'id' => $setting_prefix.'text_option',
                'type' => 'text',
                'css' => 'min-width:400px;',
                'desc_tip' => __('Text option description','my-plugin'),
            ),
        );

        $settings['section_end'] = array(
            'type' => 'sectionend',
            'id' => $setting_prefix.'section_end'
        );
        return apply_filters( $setting_prefix, $settings);
    }


}//end class