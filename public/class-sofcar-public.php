<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.sofcar.com
 * @since      1.0.0
 *
 * @package    Sofcar
 * @subpackage Sofcar/public
 */

class Sofcar_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $sofcar    The ID of this plugin.
	 */
	private $sofcar;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $sofcar     The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $sofcar, $version ) {

		$this->sofcar = $sofcar;
		$this->version = $version;
	}
	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->sofcar, plugin_dir_url( __FILE__ ) . 'css/sofcar-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->sofcar, plugin_dir_url( __FILE__ ) . 'js/sofcar-public.js', array( 'jquery' ), $this->version, false );

	}

}


