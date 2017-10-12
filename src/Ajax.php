<?php

namespace MyPluginNamespace;

class Ajax {

    protected $plugin;

    public function __construct( $plugin ) {
        $this->plugin = $plugin;
        $this->init();
    }

    public static function init() {
        \add_action('init', array(__CLASS__, 'define_ajax'), 0);
        \add_action('template_redirect', array(__CLASS__, 'do_wc_ajax'), 0);
        self::add_ajax_events();
    }

    public static function get_endpoint($request = '') {
        return esc_url_raw(add_query_arg('wc-ajax', $request, remove_query_arg(array('remove_item', 'add-to-cart', 'added-to-cart'))));
    }

    public static function define_ajax() {
        if (!empty($_GET['wc-ajax'])) {
            if (!defined('DOING_AJAX')) {
                define('DOING_AJAX', true);
            }
            if (!defined('WC_DOING_AJAX')) {
                define('WC_DOING_AJAX', true);
            }
            // Turn off display_errors during AJAX events to prevent malformed JSON
            if (!WP_DEBUG || (WP_DEBUG && !WP_DEBUG_DISPLAY)) {
                @ini_set('display_errors', 0);
            }
            $GLOBALS['wpdb']->hide_errors();
        }
    }

    private static function wc_ajax_headers() {
        \send_origin_headers();
        @header('Content-Type: text/html; charset=' . get_option('blog_charset'));
        @header('X-Robots-Tag: noindex');
        \send_nosniff_header();
        \nocache_headers();
        \status_header(200);
    }

    public static function do_wc_ajax() {
        global $wp_query;
        if (!empty($_GET['wc-ajax'])) {
            $wp_query->set('wc-ajax', sanitize_text_field($_GET['wc-ajax']));
        }
        if ($action = $wp_query->get('wc-ajax')) {
            self::wc_ajax_headers();
            \do_action('wc_ajax_' . sanitize_text_field($action));
            die();
        }
    }

    public static function add_ajax_events() {
        // woocommerce_EVENT => nopriv
        $ajax_events = array(
            'test_function'                      => false,
        );
        foreach ($ajax_events as $ajax_event => $nopriv) {
            \add_action('wp_ajax_woocommerce_' . $ajax_event, array(__CLASS__, $ajax_event));
            if ($nopriv) {
                \add_action('wp_ajax_nopriv_woocommerce_' . $ajax_event, array(__CLASS__, $ajax_event));
                // WC AJAX can be used for frontend ajax requests
                \add_action('wc_ajax_' . $ajax_event, array(__CLASS__, $ajax_event));
            }
        }
    }

	public static function test_function( ){

		\check_ajax_referer('plugin-security', 'security');
		$order_id = ($_REQUEST['id']) ? \stripslashes($_REQUEST['id']) : "empty";

		wp_send_json_success(["id" => $order_id ]);
		die();
	}






}// End class AJAX