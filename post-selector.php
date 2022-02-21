<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wwdh.de
 * @since             1.0.0
 * @package           Post_Selector
 *
 * @wordpress-plugin
 * Plugin Name:       Post-Selector Gutenberg-Block-Plugin
 * Plugin URI:        https://www.hummelt-werbeagentur.de/
 * Description:       Selection of articles in the Gutenberg block editor with countless output options.
 * Version:           2.0.0
 * Author:            Jens Wiecker
 * Author URI:        https://wwdh.de
 * License:           GPL3
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Requires PHP:      7.4
 * Requires at least: 5.6
 * Tested up to:      5.9
 * Stable tag:        2.0.0

 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

const POST_SELECTOR_PLUGIN_DB_VERSION = '1.0.1';
const POST_SELECTOR_MIN_PHP_VERSION = '7.4';
const POST_SELECTOR_MIN_WP_VERSION = '5.7';

//PLUGIN ROOT PATH
define('POST_SELECTOR_PLUGIN_DIR', dirname(__FILE__));
//PLUGIN SLUG
define('POST_SELECTOR_SLUG_PATH', plugin_basename(__FILE__));
define('POST_SELECTOR_BASENAME', plugin_basename(__DIR__));

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-post-selector-activator.php
 */
function activate_post_selector() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-post-selector-activator.php';
	Post_Selector_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-post-selector-deactivator.php
 */
function deactivate_post_selector() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-post-selector-deactivator.php';
	Post_Selector_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_post_selector' );
register_deactivation_hook( __FILE__, 'deactivate_post_selector' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-post-selector.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */

global $post_selector_plugin;
$post_selector_plugin = new Post_Selector();
$post_selector_plugin->run();
