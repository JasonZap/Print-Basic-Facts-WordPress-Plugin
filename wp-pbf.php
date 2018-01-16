<?php

/**
 * This file includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/paranoia1906/wp-pbf
 * @since             1.0.0
 * @package           Wp_Pbf
 *
 * @wordpress-plugin
 * Plugin Name:       Print Basic Facts
 * Plugin URI:        https://github.com/paranoia1906/wp-pbf
 * Description:       Print Basic Facts will save time by displaying important information for a WordPress site. See the contents of wp-config.php and .htaccess control file. Look for defined variables like child themes or forced redirects. Show connection string details as well as file count and size of the WordPress installation. Please send feedback to anthony@ledesma.tech.
 * Version:           1.0.0
 * Author:            Anthony Ledesma
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

define( 'PRINT_BASIC_FACTS_VERSION', '1.0.0' );

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
 * admin-specific site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-pbf.php';

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function run_wp_pbf() {

	$plugin = new Wp_Pbf();
	$plugin->run();

}
run_wp_pbf();
