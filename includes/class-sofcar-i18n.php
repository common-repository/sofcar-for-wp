<?php

/**
 * Define the internationalization functionality.
 *
 *
 * @since      1.0.0
 * @package    Sofcar
 * @subpackage Sofcar/includes
 * @author     Sofcar <info@sofcar.com>
 */
class Sofcar_i18n {
	
	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain( 'sofcar', false, dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/');

	}

}
