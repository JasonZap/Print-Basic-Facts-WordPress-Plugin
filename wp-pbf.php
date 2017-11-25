<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/paranoia1906/
 * @since             1.0.0
 * @package           Wp_Pbf
 *
 * @wordpress-plugin
 * Plugin Name:       WordPress - Print Basic Facts
 * Plugin URI:        51d.17f.godaddywp.com
 * Description:       Plugin functionalities include on demand print of current system usage. Soon to include additional features.
 * Version:           1.0.0
 * Author:            Anthony
 * Author URI:        https://github.com/paranoia1906/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-pbf
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-pbf-activator.php
 */
function activate_wp_pbf() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-pbf-activator.php';
	Wp_Pbf_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-pbf-deactivator.php
 */
function deactivate_wp_pbf() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-pbf-deactivator.php';
	Wp_Pbf_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_pbf' );
register_deactivation_hook( __FILE__, 'deactivate_wp_pbf' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-pbf.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_pbf() {

	$plugin = new Wp_Pbf();
	$plugin->run();

}
run_wp_pbf();
