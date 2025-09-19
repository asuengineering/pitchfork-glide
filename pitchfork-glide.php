<?php
/**
 * Plugin Name:     Pitchfork Glide
 * Plugin URI:      https://github.com/asuengineering/pitchfork-glide
 * Description:     A block set for WP incorporating Glide.js and elements from the UDS system.
 * Author:          ASU Engineering
 * Author URI:      https://github.com/asuengineering
 * Version:         0.0.1
 *
 * @package         pitchfork-glide
 * Text Domain:     pitchfork-glide
 *
 * GitHub Plugin URI: https://github.com/asuengineering/pitchfork-glide
 *
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Variable for root directory of this plugin.
define( 'PITCHFORK_GLIDE', plugin_dir_path( __FILE__ ) );

// Function: Activate.
// Function: Deactivate.
// Function: Execute plugin.

// Enqueue scripts.
require_once PITCHFORK_GLIDE . '/inc/enqueue-scripts.php';

// ACF configurations.
require_once PITCHFORK_GLIDE . '/inc/acf-config.php';
require_once PITCHFORK_GLIDE . '/inc/acf-register-blocks.php';
