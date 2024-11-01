<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.sofcar.com
 * @since      1.0.0
 *
 * @package    Sofcar
 * @subpackage Sofcar/admin
 */

/**
 * @package    Sofcar
 * @subpackage Sofcar/admin
 * @author     Sofcar <info@sofcar.com>
 */
class Sofcar_Admin {

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
	 * @param      string    $sofcar       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $sofcar, $version ) {

		$this->sofcar   = $sofcar;
		$this->version 	= $version;
		$this->load_dependencies();
		
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->sofcar, plugin_dir_url( __FILE__ ) . 'css/sofcar-admin.css', array(), $this->version, 'all' );
	}
	
	private function load_dependencies() {
		
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		
		wp_enqueue_script( $this->sofcar, plugin_dir_url( __FILE__ ) . 'js/sofcar-admin.js', array( 'jquery' ), $this->version, false );
		
	}
	
	public function create_menu() {
		
		$sofcar_api  = new Sofcar_Api();
		
		add_menu_page( __('Sofcar Plugin', 'sofcar'), __('Sofcar', 'sofcar'), "manage_options", "sofcar", "Sofcar_Admin::build_sofcar_dashboard" , 
					  plugins_url( 'sofcar-for-wp/images/icon/sofcar_icon_16x16.png'), 3);
		
		if($sofcar_api->validate_token()){
			add_submenu_page('sofcar',__('Bookings', 'sofcar'),__('Bookings', 'sofcar'),'manage_options',esc_url(admin_url('admin.php?page=sofcar&tab=booking')));
			add_submenu_page('sofcar',__('Locations', 'sofcar'),__('Locations', 'sofcar'),'manage_options',esc_url(admin_url('admin.php?page=sofcar&tab=places')));
			add_submenu_page('sofcar',__('Classes', 'sofcar'),__('Classes', 'sofcar'),'manage_options',esc_url(admin_url('admin.php?page=sofcar&tab=vclass')));
			add_submenu_page('sofcar',__('Models', 'sofcar'),__('Models', 'sofcar'),'manage_options',esc_url(admin_url('admin.php?page=sofcar&tab=models')));
			add_submenu_page('sofcar',__('Shortcodes', 'sofcar'),__('Shortcodes', 'sofcar'),'manage_options',esc_url(admin_url('admin.php?page=sofcar&tab=widget')));
			add_submenu_page('sofcar',__('Page', 'sofcar'),__('Pages', 'sofcar'),'manage_options',esc_url(admin_url('admin.php?page=sofcar&tab=pages')));
		}
		
		add_submenu_page('sofcar',__('Settings', 'sofcar'),__('Settings', 'sofcar'),'manage_options',esc_url(admin_url('admin.php?page=sofcar&tab=settings')));
		
		if(!$sofcar_api->validate_token())
			add_submenu_page('sofcar',__('Get started', 'sofcar'),__('Get started', 'sofcar'),'manage_options',esc_url(admin_url('admin.php?page=sofcar&tab=started')));
			
		remove_submenu_page(  "sofcar",  "sofcar" );
	}
	
    public static function build_sofcar_dashboard() {
		
		$sofcar_api  	= new Sofcar_Api();
		$rqParams		= $_REQUEST;
		$current_tab 	= ( ! empty( $_GET['tab'] ) ) ? sanitize_text_field( $_GET['tab'] ) : 'booking';
		$filter_type 	= ( ! empty( $_GET['type'] ) ) ? sanitize_text_field( $_GET['type'] ) : 'sofcar';
		require_once plugin_dir_path( __FILE__ ) . 'partials/sofcar-dashboard.php';
		
    }
		 
	public function top_menu(WP_Admin_Bar $admin_bar) {
		
		  if(!current_user_can( 'manage_options'))return;
		
		  global $wp_admin_bar;
		
		  $sofcar_api  = new Sofcar_Api();
		
		  $wp_admin_bar->add_menu( array(
										'id'    => 'sofcar_top_bar_menu',
										'title' => '<span class=""><img src="'. esc_url(plugins_url( 'sofcar-for-wp/images/icon/sofcar_top_bar.png')). '"></span>',
										'href'  => esc_url(admin_url('admin.php?page=sofcar')),
										'meta'  => array(
											'class' => 'sofcar-top-bar-menu-item',
										)
									) );
		
		 if($sofcar_api->validate_token())
			 $wp_admin_bar->add_menu( array(
					'id'     => 'sofcar_top_bar_menu-get_started',
					'title'  => '<span>' . __( 'My panel', 'sofcar' ) . '</span>',
					'href'   => esc_url($sofcar_api->get_host()),
			  		'meta' 	 => array('target' => '_blank'),
					'parent' => 'sofcar_top_bar_menu'
				) );
		
	}
	
}
