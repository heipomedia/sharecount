<?php
/**
 * Plugin Name: ShareCount
 * Plugin URI: https://heipomedia.de
 * Description: A simple plugin for displaying sharing buttons with their share numbers (Facebook, Twitter, Mail)
 * Version: 1.0.0
 * Author: Marc Heiduk
 * Author URI: https://heipomedia.de
 * License: MIT
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Define plugin path
define( 'SHARECOUNT_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Enqueues Scripts
 */
function ajax_sharecount_enqueue_scripts()
{

    // Enqueue scripts only if we are on a single page
    if (is_single()) {

        // Enqueue style and script
        wp_enqueue_style('sharecount', plugins_url('/css/sharecount.css', __FILE__));
        wp_enqueue_script('sharecount', plugins_url('/js/sharecount.js', __FILE__), array(), '1.0', true);

        // Localize the scripts and set security nonces against abuse

        // Facebook
        wp_localize_script('sharecount', 'get_fb_sharecount', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'fb_sharecount_nonce' => wp_create_nonce( 'fb_sharecount_nonce' ),
        ));

        // Twitter
        wp_localize_script('sharecount', 'get_tw_sharecount', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'tw_sharecount_nonce' => wp_create_nonce( 'tw_sharecount_nonce' ),
        ));

        // Mail
        wp_localize_script('sharecount', 'get_mail_sharecount', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'mail_sharecount_nonce' => wp_create_nonce( 'mail_sharecount_nonce' ),
        ));
    }
}
add_action('wp_enqueue_scripts', 'ajax_sharecount_enqueue_scripts');

/**
 * Require Facebook shares
 */
require_once SHARECOUNT_PLUGIN_PATH . 'inc/facebook-shares.php';

/**
 * Require Twitter shares
 */
require_once SHARECOUNT_PLUGIN_PATH . 'inc/twitter-shares.php';

/**
 * Require Mail shares
 */
require_once SHARECOUNT_PLUGIN_PATH . 'inc/mail-shares.php';

/**
 * ShareCount buttons
 */
require_once SHARECOUNT_PLUGIN_PATH . 'inc/display-sharecount.php';

/**
 * BBCodes
 */
require_once SHARECOUNT_PLUGIN_PATH . 'inc/bbcodes.php';
