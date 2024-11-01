<?php

/**
 *
 *
 * @link              https://www.sofcar.com
 * @since             1.0.0
 * @package           Sofcar
 *
 * @wordpress-plugin
 * Plugin Name:       Sofcar for WP
 * Plugin URI:        https://wordpress.org/plugins/sofcar-for-wp/
 * Description:       Online booking system for rental companies
 * Version:           1.0.1
 * Author:            Sofcar
 * Author URI:        https://www.sofcar.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sofcar
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'SOFCAR_VERSION', '1.0.1' );

/**
 * The code that runs during plugin activation.
 */
function activate_sofcar() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sofcar-activator.php';
	Sofcar_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_sofcar() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sofcar-deactivator.php';
	Sofcar_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_sofcar' );
register_deactivation_hook( __FILE__, 'deactivate_sofcar' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-sofcar.php';

function run_sofcar() {
	$plugin = new Sofcar();
	$plugin->run();
}

run_sofcar();
