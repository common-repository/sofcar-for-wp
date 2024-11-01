<?php

/**
 * The admin-specific functionality of the plugin API.
 * Sidebar, WP and Webservice Functions
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
class Sofcar_Api {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		
		$this->save_token();
		
		$this->check_wp_default_categories();
		
		$this->sync();
		
		$this->wp_pages();
		
		$this->load_sidebar();
		
	}
	
	/**
	 * Sidebar Functions
	 *
	 * @since    1.0.0
	 */
	public function load_sidebar() {
		
		$current_tab = ( ! empty( $_GET['tab'] ) ) ? sanitize_text_field( $_GET['tab'] ) : 'booking';
		
		if(is_admin()){
			if($current_tab=="settings"){ 
				
				add_meta_box('sofcar-sidebar-support', esc_html__("Subscription", 'sofcar'), array($this, 'get_sidebar_settings'), 'post', 'sidebar', 'default');
				add_meta_box('sofcar-sidebar-support', esc_html__("Support", 'sofcar'), array($this, 'get_sidebar_support'), 'post', 'sidebar', 'default');
				
			}else{ 
				
				if($current_tab!="vclass"){
					
					$metboxTit = esc_html__(ucfirst($current_tab), 'sofcar');
					
					if($current_tab=="places")$metboxTit = esc_html__("Locations", 'sofcar');
					
					add_meta_box('sofcar-sidebar-'.$current_tab, esc_html__("About", 'sofcar')." ".$metboxTit, array($this, 'get_sidebar_'.$current_tab), 'post', 'sidebar', 'default');
				
				}
				
			}
			
		}
	}	
	
	public function get_sidebar_places() {
		
		$type  = "sofcar_places";
		echo "<p>
				".esc_html__('According to the Pickup and Drop-off Locations available in your Sofcar platform', 'sofcar')."
				".esc_html__('The system allows the import of all the Locations data: Location, contact information, images and geographical coordinates according to the available data', 'sofcar')."
			  </p>
			  <p style='line-height: 25px;'>".esc_html__('Locations in Sofcar', 'sofcar').": ".
			  "<a href='".esc_url($this->get_host()."/tools/place/index")."' target='_blank'>".esc_html__('Manage', 'sofcar')."</a></p>".
			  "<p style='line-height: 25px;'>".esc_html__('Locations category in Wordpress', 'sofcar').": ".
			  "<a href='".esc_url(get_edit_term_link($this->get_wp_sofcar_category($type), "category"))."' target='_blank'>".esc_html__('Edit', 'sofcar')."</a> <span class='row-actions'>|</span>  
			   <a href='".esc_url(get_category_link($this->get_wp_sofcar_category($type)))."' target='_blank'>".esc_html__('View', 'sofcar')."</a>".
			  "</p>";
	}
	
	public function get_sidebar_models() {
		
		$type  = "sofcar_models";
		echo "<p>
				".esc_html__('According to the Vehicle Classes and available Models in your Sofcar platform.', 'sofcar')."
				".esc_html__('The system will create your active Models as Posts in your WordPress platform and will automatically add them. In case no Vehicle Class exist, it will automatically create a Class as a WordPress category.', 'sofcar')."
			  </p>
			  <p style='line-height: 25px;'>".esc_html__('Models in Sofcar', 'sofcar').": ".
			  "<a href='".esc_url($this->get_host()."/tools/model/index")."' target='_blank'>".esc_html__('Manage', 'sofcar')."</a>".
			  "<p style='line-height: 25px;'>".esc_html__('Fleet category in Wordpress', 'sofcar').": ".
			  "<a href='".esc_url(get_edit_term_link($this->get_wp_sofcar_category($type), "category"))."' target='_blank'>".esc_html__('Edit', 'sofcar')."</a> <span class='row-actions'>|</span>  
			   <a href='".esc_url(get_category_link($this->get_wp_sofcar_category($type)))."' target='_blank'>".esc_html__('View', 'sofcar')."</a>".
			  "</p>";
	}
	
	public function get_sidebar_support() {
		
		echo "<div style='margin: 10px 15px;'>
				<h4>".esc_html__('Do you have any doubt?', 'sofcar')."</h4>
				<a href='".esc_url("https://www.sofcar.com/support")."' target='_blank'>".esc_html__('Support Center', 'sofcar')."</a><br>
				<a href='".esc_url("https://www.sofcar.com/community")."' target='_blank'>".esc_html__('Community', 'sofcar')."</a>
			 </div>";
	}
	
	public function get_sidebar_widget() {
		
		echo "<p>
				".esc_html__('The connection interface of the booking engine embeddable Widget, runs the necessary functions for the online booking, in a transparent way to the user. Runs actions on the booking such as searches or formalization.', 'sofcar')."<br><br>".esc_html__("If you already have a web page, insert your online booking system in a few simple steps with Sofcar's Shortcodes.", 'sofcar')."
			 </p>
			 <p style='line-height: 25px;'>".esc_html__('Manage in Sofcar', 'sofcar').": <a href='".esc_url($this->get_host()."/tools/site/index")."' target='_blank'>".esc_html__('Booking Engine', 'sofcar')."</a></p>
			 <p style='line-height: 25px;'>".esc_html__('Need More?', 'sofcar').": 
			 	<a href='".esc_url($this->get_host()."/tools/widget/index")."' target='_blank' style='padding-right:10px;'>".esc_html__('Embeddable Widget', 'sofcar')."</a>
				<a href='".esc_url($this->get_host()."/tools/apiws/index")."' target='_blank'>".esc_html__('API Webservice', 'sofcar')."</a>
			 </p>";
	}
	
	public function get_sidebar_pages() {
		
		echo "<p>
				".esc_html__('Sofcar allows you to create the main sections of your website in seconds. Select the type of predefined page you want to create and Sofcar will insert its content according to the section automatically. Sofcar provides you with a search engine for availability and booking, a list of your fleet or a contact form without complications.', 'sofcar')."
			 </p>";
	}
	
	public function get_sidebar_settings() {
		
		echo "<p>
				".esc_html__("If you already have a web page, insert your online booking system in a few simple steps with Sofcar's Shortcodes.", 'sofcar')."
			 </p>
			 <p style='line-height: 25px;'>".esc_html__('Need More?', 'sofcar')."  
			 	<a href='".esc_url($this->get_host()."/tools/widget/index")."' target='_blank' style='padding-right:10px;'>".esc_html__('Embeddable Widget', 'sofcar')."</a>
				<a href='".esc_url($this->get_host()."/tools/apiws/index")."' target='_blank'>".esc_html__('API Webservice', 'sofcar')."</a>
			 </p>";
	}
	
	/**
	 * Sofcar Credentials Functions
	 *
	 * @since    1.0.0
	 */
	public function validate_token() {
		
		if($this->get_token() && $this->get_auth()){
			
			$check_session = $this->ws_request("/models/session/check",array("view_id" => $this->get_view()));
			
			if(isset($check_session['ok']))return true;
			
		}
		return false;
		
	}
	
	private function save_token() {
		
		$all_options = wp_load_alloptions();
		
		if(isset($_POST["sofcar_token"])){ 
			
			$sofcarPostToken = sanitize_text_field($_POST["sofcar_token"]);
			
			if(get_option('sofcar_token') || isset($all_options["sofcar_token"])){  
				update_option( "sofcar_token", $sofcarPostToken );  
			}else{  
				add_option( "sofcar_token", $sofcarPostToken ); 
			}
		}
		
		if(isset($_POST["sofcar_auth"])){ 
			
			$sofcarPostAuth = sanitize_text_field($_POST["sofcar_auth"]);
			
			if(get_option('sofcar_auth') || isset($all_options["sofcar_auth"])){	 
				update_option( "sofcar_auth", $sofcarPostAuth );	
			}else{	
				add_option( "sofcar_auth", $sofcarPostAuth ); 
			}
			
		}
		
		if(isset($_POST["sofcar_reset"])){ 
			
			if (file_exists($this->get_token()))
				unlink($this->get_token());
			delete_option("sofcar_token");
			delete_option("sofcar_auth");
			
		}
		
	}
	
	private function get_token_params($param) {
		
		$ctoken = get_option('sofcar_token');
		
		if(function_exists('openssl_encrypt') && function_exists('openssl_decrypt')){
			
			$output  = openssl_decrypt(base64_decode(substr($ctoken, 16)), "AES-256-CBC", hash('sha256', "5Z-&gDJV#YTb7*\S"), 0, substr($ctoken, 0, 16));
			$params  = explode(str_replace('/','-',str_replace('|','','/i|p|a/')),$output);
			if(isset($params[$param]))return $params[$param];
			
		}
		
		return false;
	}
	
	public function get_host() { 	
		
		$currentHost = $this->get_token_params(0);
		if(!empty($currentHost))return $currentHost;
		return false;
	}
	
	public function get_username() { 
		
		return $this->get_token_params(1); 
	
	}
	
	public function get_token() {		
		
		if(get_option('sofcar_token')) 
			return get_option('sofcar_token'); 
		
	}
	
	public function get_auth() {		
		
		if(get_option('sofcar_auth')) return get_option('sofcar_auth'); 
		
	}
	
	
	/**
	 * Sofcar Wordpress Functions
	 *
	 * @since    1.0.0
	 */
	public function get_wp_locale() { 
		
		return get_locale();
	
	}
	
	public function get_wp_posts( $sp=false , $cat=false , $meta=false ) {
		
		global $sitepress;
		
		if(defined('ICL_LANGUAGE_CODE'))
			$sitepress->switch_lang($lang); 
		
		$wpq   = array('post_type' => 'post','orderby' => 'name','posts_per_page' => 200,'order' => 'ASC');
		
		if($sp)
			$wpq["meta_query"]   = array( array( 'key' => $sp["key"], 'value'  => $sp["value"] ));
		
		if($cat)
			$wpq["tax_query"]   = array( array( 'taxonomy' => 'category', 'field' => 'id', 'terms'=> $cat ));
		
		if($meta)
			$wpq["meta_query"] = array( array( 'key' => $meta["key"], 'compare'  => 'EXISTS' ));
		
		$posts = new WP_Query($wpq); 
		
		wp_reset_query();  
		
		return $posts->posts;
	}
	
	public function get_wp_pages( $sp=false, $meta=false ) {
		
		global $sitepress;
		
		if(defined('ICL_LANGUAGE_CODE'))
			$sitepress->switch_lang($lang); 
		
		$wpq   = array('post_type' => 'page','orderby' => 'name','posts_per_page' => 200,'order' => 'ASC');
		
		if($sp)
			$wpq["meta_query"]   = array( array( 'key' => $sp["key"], 'value'  => $sp["value"] ));
		
		if($meta)
			$wpq["meta_query"] = array( array( 'key' => $meta["key"], 'compare'  => 'EXISTS' ));
		
		$posts = new WP_Query($wpq); 
		
		if(!isset($posts->posts))return false;
		
		wp_reset_query();  
		
		return $posts->posts;
	}
	
	public function get_wp_pages_templates(){
		
		return array(
					"sc-page-fleet-widget"		=>  esc_html__('Page with Fleet Widget', 'sofcar'),
					"sc-page-contact-widget"	=>  esc_html__('Page with Contact Form Widget', 'sofcar'),
					"sc-page-about"				=>  esc_html__('Page About your company', 'sofcar'),
					"sc-page-legalterms"		=>  esc_html__('Page with your Legal Terms and Rental Conditions', 'sofcar'),
					"sc-page-legalpolicy"		=>  esc_html__('Page with your Privacy Policy', 'sofcar'),
					"sc-page-account"			=>  esc_html__('Page with Customer Login Account', 'sofcar'),
				   );
		
	}
	
	public function get_wp_categories() {
		
		global $sitepress;
		
		if(defined('ICL_LANGUAGE_CODE'))
			$sitepress->switch_lang($lang); 
		
		return get_categories(array(
									'type'=> 'post',
									'child_of'=> 0,
									'parent'=>'',
									'orderby'=> 'name',
									'order'=> 'ASC',
									'hide_empty'=> 0,
									'hierarchical'=> 1,
									'exclude'=> '',
									//'post_type'=> $post_type,
									'include'=> '',
									'number'=> '',
									//'taxonomy'=> $taxonomy,
									'posts_per_page'=> 100,
									'pad_counts'=> false
								));
	}
	
	private function check_wp_default_categories() {
		
		if(!$this->get_wp_sofcar_category("sofcar_places"))
			$this->create_wp_category(array( "name" => "Offices", "sofcar_param" => "sofcar_places", "sofcar_value" => "1" ));
		
		if(!$this->get_wp_sofcar_category("sofcar_models"))
			$this->create_wp_category(array( "name" => "Fleet",  "sofcar_param" => "sofcar_models", "sofcar_value" => "1" ));
		
	}
								   
	public function get_wp_sofcar_category($type) {	
		
		$wp_categories = $this->get_wp_categories();
		
		if(sizeof($wp_categories)){
			foreach($wp_categories as $wp_cat){
				
				$wp_sofcar_param = get_term_meta($wp_cat->cat_ID,$type,true); 
				if($wp_sofcar_param)return $wp_cat->cat_ID;
				
			}
		}
		
		return false;
	}	
	
	public function create_wp_category($cat) {
		
		$newCatID = wp_insert_category(array(
											'cat_name' 				=> str_replace(' ','-',trim(mb_strtolower($cat['name']))),
											'category_description'  => "",
											'category_nicename' 	=> ucfirst(mb_strtolower($cat['name'])),
											'category_parent' 		=> '',
											'taxonomy' 				=> "category"
										  ));
		
		update_term_meta($newCatID, $cat['sofcar_param'], $cat['sofcar_value']);
		
		return $newCatID;
		
	}	
	
	private function create_wp_posts($p) {
		
		$pdesc = $pexce = "";
		if(isset($p['description']) && !empty($p['description']))$pdesc = $p['description'];
		if(isset($p['excerpt']) && !empty($p['excerpt']))$pexce = $p['excerpt'];
		
		$newPostID = wp_insert_post(array(
									'post_status' 		=> 'publish', 
									'post_type' 		=> 'post',
									'post_author' 		=>  get_current_user_id(),
									'post_name'			=>  sanitize_title(str_replace(' ','-',trim(mb_strtolower($p['name'])))),
									'post_title' 		=>  ucfirst(mb_strtolower($p['name'])),
									'post_content'		=>  $pdesc,
									'post_excerpt'		=>	$pexce,
									'post_date'			=>  date('Y-m-d H:i:s'),
									'comment_status' 	=>  "closed",
									'ping_status' 		=>  'closed',
									'post_category' 	=>  $p['category']
									));
		
		
		
		add_post_meta($newPostID, esc_attr($p['sofcar_param']), sanitize_text_field($p['sofcar_value']));
		
		if(isset($p['image']) && !empty($p['image'])){
			$this->generate_wp_featured_image($p["image"], $newPostID);
		
		}
		return $newPostID;
	}
	
	private function create_wp_page($p) {
		
		$pdesc = $pexce = "";
		if(isset($p['description']) && !empty($p['description']))$pdesc = $p['description'];
		if(isset($p['excerpt']) && !empty($p['excerpt']))$pexce = $p['excerpt'];
		
		$newPageID = wp_insert_post(array(
									'post_status' 		=> 'publish', 
									'post_type' 		=> 'page',
									'post_author' 		=>  get_current_user_id(),
									'post_name'			=>  sanitize_title(str_replace(' ','-',trim(mb_strtolower($p['name'])))),
									'post_title' 		=>  ucfirst(mb_strtolower($p['name'])),
									'post_content'		=>  $pdesc,
									'post_excerpt'		=>	$pexce,
									'post_date'			=>  date('Y-m-d H:i:s'),
									'comment_status' 	=>  "closed",
									'ping_status' 		=>  'closed',
									));
		
		add_post_meta($newPageID, esc_attr($p['sofcar_param']), sanitize_text_field($p['sofcar_value']));
		
		if(isset($p['image']) && !empty($p['image'])){
			$this->generate_wp_featured_image($p["image"], $newPageID);
			
		}
		return $newPageID;
	}
	
	private function format_post_description( $synctype, $item ) {
		
		$description = "";
		
		switch($synctype){
				
			case "places":
				
				/** Add Widget Search*/
				$description  .= "<h4>".esc_html__('Book Now', 'sofcar')."</h4>";
				$description  .= "[sofcar-searcher]";
				$description  .= "<hr />";
				
				/** Add Schedule*/
				$description  .= "<h4>".esc_html__('Customer Service Opening hours', 'sofcar')."</h4>";
				
				if($item['pickup_turn1_end']!=$item['pickup_turn2_start']){
					
					$description  .= esc_html(substr($item['pickup_turn1_start'], 1, -3))."h - ".esc_html(substr($item['pickup_turn1_end'], 1, -3)).'h / ';
					$description  .= esc_html(substr($item['pickup_turn2_start'], 1, -3))."h - ".esc_html(substr($item['pickup_turn2_end'], 1, -3)).'h<br>';
				
				}else{ 
					
					$description  .= esc_html(substr($item['pickup_turn1_start'], 1, -3))."h - ".esc_html(substr($item['pickup_turn2_end'], 1, -3))."h"; 
				
				}
				$description  .= "<hr />";
				
				/** Add Contact*/
				$description  .= "<h4>".esc_html__('Contact', 'sofcar')."</h4>";
				$itemParm = array( esc_html__('Phone','sofcar') => "phone", esc_html__('Email','sofcar') => "email" );
				foreach($itemParm as $tit => $ip){	
					if(isset($item[$ip]) && !empty($item[$ip])){
						$description  .=  esc_html($tit).": ";
						if($ip=="email"){
							$description  .= sanitize_email($item[$ip]).'<br>'; 
						}else{
							$description  .= esc_html(ucfirst(mb_strtolower($item[$ip]))).'<br>'; 
						}
					}
				}
				$description  .= "<hr />";
				
				/** Add Address*/
				$description  .= "<h4>".esc_html__('Address', 'sofcar')."</h4>";
				$itemParm 	   = array( "" => "address", esc_html__('City','sofcar').":" => "city", esc_html__('Zone','sofcar').":" => "zone" );
				foreach($itemParm as $tit => $ip){	
					if(isset($item[$ip]) && !empty($item[$ip]))
						$description  .= esc_html($tit)." ".esc_html(ucfirst(mb_strtolower($item[$ip]))).'<br>'; 
				}
				
				/** Add Map*/
				if((isset($item['address']) && !empty($item['address'])) || (isset($item['city']) && !empty($item['city']))){
					$description  .= "<hr />";
					$description  .= "<h4>".esc_html__('Geographic Location', 'sofcar')."</h4>";
					
					$isrc 		   = "https://maps.google.com/maps?width=100%";
					$isrc  		  .= "&q=".esc_html(ucfirst(mb_strtolower($item['address'])))."+".esc_html(ucfirst(mb_strtolower($item['city'])));
					if(isset($item['latitude']) && !empty($item['latitude']) && isset($item['longitude']) && !empty($item['longitude']))
						$isrc  .= "&coord=".esc_html($item['latitude']).','.esc_html($item['longitude']);
					$isrc  		  .= "&z=12&output=embed";
					
					$description  .= "<iframe width='100%' height='450' frameborder='0' style='border:0' src='".esc_url($isrc)."'";
					$description  .= " allowfullscreen></iframe>";
					$description  .= "<hr />";
				}
				
			break;
				
			case "models":
				
				/** Add Widget Search*/
				$description  .= "<h4>".esc_html__('Book Now', 'sofcar')."</h4>";
				if(isset($item['model_id']))
					$description  .= "[sofcar-searcher model='".esc_attr($item['model_id'])."']";
				$description  .= "<hr />";
				
				/** Add Specs*/
				$description  .= "<h4>".esc_html__('Description', 'sofcar')."</h4>";
				if(isset($item['name']) && !empty($item['name']))
					$description  .= esc_html__("Model",'sofcar').": ".sanitize_text_field(ucfirst(mb_strtolower($item['name'])))."<br>"; 
				if(isset($item['vclass']) && !empty($item['vclass']))
					$description  .= esc_html__("Class",'sofcar').": ".sanitize_text_field(ucfirst(mb_strtolower($item['vclass'])))."<br>"; 
				if(isset($item['group']) && !empty($item['group']))
					$description  .= esc_html__("Group",'sofcar').": ".sanitize_text_field(ucfirst(mb_strtolower($item['group'])))."<br>"; 
				if(isset($item['description']) && !empty($item['description']))
					$description  .= "<p>".wp_kses_post($item["description"])."</p>";
				$description  .= "<hr />";
				
				/** Add Specs*/
				$description  .= "<h4>".esc_html__('Equipment', 'sofcar')."</h4>";
				
				$description  .= esc_html__("Transmission",'sofcar').": ";
				
				if(isset($item['model_automatic_transmission']) && $item['model_automatic_transmission']){ 
					$description .= esc_html__("Automatic",'sofcar')."<br>"; 
				}else{  
					$description .= esc_html__("Manual",'sofcar')."<br>"; 
				}
				
				if(isset($item['model_num_capacity']) && !empty($item['model_num_capacity']))
					$description  .= esc_html__("Capacity",'sofcar').": ".esc_attr($item['model_num_capacity'])." ".esc_html__("people",'sofcar')."<br>";
				
				if(isset($item['model_doors_quantity']) && !empty($item['model_doors_quantity']))
					$description  .= esc_attr($item['model_doors_quantity'])." ".esc_html__("doors",'sofcar')."<br>";
				
				if(isset($item['model_air_conditioning']) && !empty($item['model_air_conditioning']))
					$description  .= esc_html__("Air Conditioning",'sofcar')."<br>";
				
				if(isset($item['model_gps_included']) && !empty($item['model_gps_included']))
					$description  .= esc_html__("GPS included",'sofcar')."<br>";
				
				$description  .= "<hr />";
				
				/** Add Optionals*/
				if(isset($item['optionals_description']) && !empty($item['optionals_description'])){
					$description  .= "<h4>".esc_html__('Optionals', 'sofcar')."</h4>";
					$description  .= "<p>".wp_kses_post($item["optionals_description"])."</p>";
					$description  .= "<hr />";
				}
				
				/** Add Special Conditions*/
				if(isset($item['special_conditions']) && !empty($item['special_conditions'])){
					$description  .= "<h4>".esc_html__('Special booking conditions', 'sofcar')."</h4>";
					$description  .= "<p>".wp_kses_post($item["special_conditions"])."</p>";
					$description  .= "<hr />";
				}
				
			break;
			case "pages":
				
				switch($item){
					case "sc-page-fleet-widget":	
						$description  .= "<h3>".esc_html__('Wide range and availability of vehicles', 'sofcar')."</h3>";
						$description  .= "[sofcar-fleet]";
					break;
					case "sc-page-contact-widget":	
						$description  .= "<h3>".esc_html__('Customer Service', 'sofcar')."</h3>";
						$description  .= "<p>"
										 .esc_html__('If you have any questions, queries or suggestions you can use the form below to contact us.', 'sofcar')."<br />"
										 .esc_html__('We will shortly reply your message.', 'sofcar').
										 "</p>";
						$description  .= "[sofcar-contact]";
					break;
					case "sc-page-about":	
						$terms		   = $this->get_terms();
						if(isset($terms[0]["textabout"]) && !empty($terms[0]["textabout"])){
							$description  .= "<h3>".esc_html__('About Us', 'sofcar')."</h3>";
							$description  .= "<p>".wp_kses_post(nl2br($terms[0]["textabout"]))."</p>";
						}	
					break;
					case "sc-page-legalterms":	
						$terms		   = $this->get_terms();
						if(isset($terms[0]["legalterms"]) && !empty($terms[0]["legalterms"])){
							$description  .= "<h3>".esc_html__('Terms and Conditions', 'sofcar')."</h3>";
							$description  .= "<p>".wp_kses_post(nl2br($terms[0]["legalterms"]))."</p>";
						}	
					break;	
					case "sc-page-legalpolicy":	
						$terms		   = $this->get_terms();
						if(isset($terms[0]["legalpolicy"]) && !empty($terms[0]["legalpolicy"])){
							$description  .= "<h3>".esc_html__('Privacy Policy', 'sofcar')."</h3>";
							$description  .= "<p>".wp_kses_post(nl2br($terms[0]["legalpolicy"]))."</p>";
						}
					break;
					case "sc-page-account":	
						$description  .= "[sofcar-account]";
					break;
				}
				
			break;	
		}
		return $description;
	}
	
	private function format_post_excerpt( $synctype, $item ) {
		
		$excerpt = "";
		
		switch($synctype){
				
			case "places":
				
				/** Add Contact*/
				$itemParm = array( esc_html__('Phone','sofcar') => "phone", esc_html__('Email','sofcar') => "email" );
				foreach($itemParm as $tit => $ip){	
					
					if(isset($item[$ip]) && !empty($item[$ip])){
						
						$excerpt  .= esc_html($tit).": ";
						
						if($ip=="email"){
							$excerpt  .= sanitize_email($item[$ip]).'<br>'; 
						}else{
							$excerpt  .= sanitize_text_field(ucfirst(mb_strtolower($item[$ip]))).'<br>'; 
						}
						
					}
				}
				
				/** Add Address*/
				$itemParm 	   = array("address", "city" );
				foreach($itemParm as $ip){	
					if(isset($item[$ip]) && !empty($item[$ip]))
						$excerpt  .= sanitize_text_field(ucfirst(mb_strtolower($item[$ip]))).'<br>'; 
				}
				
			break;
			case "models":
				
				$excerpt  .= sanitize_text_field(ucfirst(mb_strtolower($item['vclass'])))."<br>"; 
				$excerpt  .= sanitize_text_field(ucfirst(mb_strtolower($item['group'])))."<br><br>"; 
				$excerpt  .= wp_kses_post($item["description"]);
				
			break;
			case "pages":
				
				$excerpt  .= esc_html__('Wide range and availability of vehicles', 'sofcar'); 
				
			break;	
		}
		
		return $excerpt;
		
	}
	
	private function sync() {
		
		if(isset($_REQUEST["sofcar_sync"])){
		
			$sofcarSync 	  = sanitize_text_field($_REQUEST["sofcar_sync"]);
			$wp_sync_category = $this->get_wp_sofcar_category("sofcar_".$sofcarSync);
			
			if(isset($_REQUEST["post_group_action"])){
				$post_group_action 	= sanitize_text_field($_REQUEST["post_group_action"]);
				switch($post_group_action){

					case "import":
						foreach($_REQUEST as $rq => $v){
							
							$v	= sanitize_text_field($v);
							
							if((strpos($rq, "chk_item")) !== false){

								if($sofcarSync=="classes"){

									if(!$this->get_wp_sofcar_category("sofcar_vclass_".$v)){

										$sofcarItem = $this->get_vclass($v);

										if(isset($sofcarItem["name"]) && !empty($sofcarItem["name"])){
											$this->create_wp_category(array( 
																			"name" => ucfirst(mb_strtolower($sofcarItem["name"])), 
																			"sofcar_param" => "sofcar_vclass_".$v, 
																			"sofcar_value" => $v 
																		));
										}
									}

								}else{

									$wp_posts   = $this->get_wp_posts(array( "key" => "sofcar_".$sofcarSync, "value" => $v));

									if(sizeof($wp_posts) && isset($wp_posts[0]->ID))$this->delete_wp_post($wp_posts[0]->ID);
									$call 		= "get_".$sofcarSync;
									$sofcarItem = $this->$call($v);
									$postCats	= array($wp_sync_category);

									if(isset($sofcarItem["vclass_id"])){

										if($vclassCat = $this->get_wp_sofcar_category("sofcar_vclass_".$sofcarItem["vclass_id"])){

											$postCats[] = $vclassCat;

										}else{ 
											$postCats[] = $this->create_wp_category(array( 
																			"name" => ucfirst(mb_strtolower($sofcarItem["vclass"])), 
																			"sofcar_param" => "sofcar_vclass_".$sofcarItem["vclass_id"], 
																			"sofcar_value" => $sofcarItem["vclass_id"] 
																		));
										}
									}

									$newPost 	= $this->create_wp_posts(array(
																		"name" 			=> esc_html($sofcarItem["name"]), 
																		"description" 	=> $this->format_post_description($sofcarSync,$sofcarItem),
																		"excerpt"		=> $this->format_post_excerpt($sofcarSync,$sofcarItem),
																		"category" 		=> $postCats, 
																		"image"			=> $sofcarItem["image"], 
																		"sofcar_param" 	=> "sofcar_".$sofcarSync, 
																		"sofcar_value" 	=> $v
																		));		
								}

							}
						}
						break;

					case "delete":
						foreach($_REQUEST as $rq => $v){
							if((strpos($rq, "chk_item")) !== false){
								
								$v	= sanitize_text_field($v);
								
								if($sofcarSync=="classes"){ 
									
									wp_delete_category($this->get_wp_sofcar_category("sofcar_vclass_".$v)); 
									
								}else{
									
									$wp_posts  = $this->get_wp_posts(array( "key" => "sofcar_".$sofcarSync, "value" => $v));
									if(sizeof($wp_posts))$this->delete_wp_post($wp_posts[0]->ID); 
								}
							}
						}
						break;
				}
			}
		}
	}
	
	private function wp_pages() {
		
		
		if(isset($_REQUEST["sofcar_pages"])){
		
			if(isset($_REQUEST["post_group_action"])){
				
				$post_group_action 	= sanitize_text_field($_REQUEST["post_group_action"]);
				
				switch($post_group_action){
					case "sc-page-fleet-widget":     $page_title = esc_html__("Fleet","sofcar");    break;
					case "sc-page-contact-widget":   $page_title = esc_html__("Contact","sofcar");  break;
					case "sc-page-about":   		 $page_title = esc_html__("About Us","sofcar");  break;	
					case "sc-page-legalterms":   	 $page_title = esc_html__("Terms and Conditions","sofcar");  break;	
					case "sc-page-legalpolicy":   	 $page_title = esc_html__("Privacy Policy","sofcar");  break;	
					case "sc-page-account":		   	 $page_title = esc_html__("Your account","sofcar");  break;		
				}

				if(!$this->get_wp_pages(array("key"=> "sofcar_pages" , "value" => $post_group_action ), false)){
					
					$newPage = $this->create_wp_page(array(
														"name" 			=> $page_title, 
														"description" 	=> $this->format_post_description("pages",  $post_group_action),
														"excerpt"		=> $this->format_post_excerpt("pages",  $post_group_action),
														"sofcar_param" 	=> "sofcar_pages", 
														"sofcar_value" 	=> $post_group_action
													));	
				}
			}
			
		}
	}
	
	private function delete_wp_post($postID) {
		
		$this->delete_wp_attachment($postID);
		wp_delete_post($postID);
		
	}
	
	private function delete_wp_attachment($postID){
		
		$postAttachment  = get_attached_media('image',$postID);
		if(sizeof($postAttachment)){
			foreach($postAttachment as $attach){ 
				wp_delete_attachment($attach->ID, true);
			}
		}
	}
	
	private function generate_wp_featured_image($image_url, $postID){
		
		if((strpos($image_url, $this->get_host())) !== false){ }else{ $image_url = $this->get_host()."/".$image_url; }
		$upload_dir = wp_upload_dir();
		$image_data = file_get_contents($image_url);
		$filename   = basename($image_url);
		
		if(wp_mkdir_p($upload_dir['path']))     $file = $upload_dir['path'] . '/' . $filename;
		else                                    $file = $upload_dir['basedir'] . '/' . $filename;
		file_put_contents($file, $image_data);
		
		$wp_filetype = wp_check_filetype($filename, null );
		$attachment  = array('post_mime_type' => $wp_filetype['type'],'post_title' 	 => sanitize_file_name($filename),'post_content' => '','post_status' => 'inherit');
		$attach_id 	 = wp_insert_attachment($attachment,$file,$postID);
		
		require_once(ABSPATH . 'wp-admin' . '/includes/image.php');
		$attach_data = wp_generate_attachment_metadata($attach_id, $file);
		$res1		 = wp_update_attachment_metadata( $attach_id, $attach_data);
		$res2		 = set_post_thumbnail($postID, $attach_id);
		
		add_post_meta($postID, '_thumbnail_id', $attach_id, true);
	}
	
	public function get_wp_shortcode($params) {	
		
		$shortcode = "searcher";
		if(isset($params["widget_type"]))$shortcode = $params["widget_type"];
		
		foreach($params as $rq => $v){
			
			$v = esc_attr($v);
			
			if((strpos($rq, "widget_")) !== false){
				
				if($rq=="widget_width")
					$shortcode .= " width='".$v."'";	
				
				if($rq=="widget_model" && (isset($params["widget_type"]) && $params["widget_type"]=="vehicle"))
					$shortcode .= " model='".$v."'";	
				
				if($rq=="widget_view")
					$shortcode  .= " view='".$v."'";
				
				if($rq=="widget_scroll")
					$shortcode  .= " autoscroll='".$v."'";
				
				if($rq=="widget_result_width" && (isset($params["widget_type"]) && $params["widget_type"]=="searcher"))
					$shortcode .= " result_width='".$v."'";	
				
			}
			
		}
		return "[sofcar-".$shortcode."]";
	}
	
	/**
	 * Sofcar Webservice Functions
	 *
	 * @since    1.0.0
	 */
	public function get_view() { 
		
		$locale 	= "en_US"; 
		if($this->get_wp_locale())
			$locale = $this->get_wp_locale();
		
		if(get_option('sofcar_locale') && get_option('sofcar_view_id')){ 
			if(get_option('sofcar_locale')==$locale)return get_option('sofcar_view_id'); 
		}
		
		$language 	= $this->get_languages($locale);
		
		if(isset($language["lang_id"])){ 
			
			$langview = $this->get_views(false, $language["lang_id"]); 
			
			if(isset($langview["view_id"])){ 
			
				if(get_option('sofcar_locale')){ update_option( "sofcar_locale", $locale ); }else{ add_option( "sofcar_locale", $locale ); }
				if(get_option('sofcar_view_id')){ update_option( "sofcar_view_id", $langview["view_id"] ); }else{ add_option( "sofcar_view_id", $langview["view_id"] ); }
				
				return $langview["view_id"]; 
			
			}
		}
		
		return 2; //default english
	}
	
	public function get_terms() {
		
		$host_items = $this->ws_request("/models/company/terms",array("view_id" => $this->get_view()));
		return $host_items["items"];
		
	}
	
	public function get_views( $view = false, $lang_id = false ) {
		
		$host_items = $this->ws_request("/models/view/visibleRecords",array("view_id" => 0));
		
		if($view && sizeof($host_items["items"]))
			foreach($host_items["items"] as $key => $i){ 
				if(isset($i["view_id"]) && $i["view_id"]==$view){ 
					$host_items["items"] = $i; break; 
				} 
			}
		
		if($lang_id && sizeof($host_items["items"]))
			foreach($host_items["items"] as $key => $i){ 
				if(isset($i["view_id"]) && isset($i["lang_id"]) && $i["lang_id"]==$lang_id && $i["view_id"]){ 
					$host_items["items"] = $i; break; 
				} 
			}
		
		return $host_items["items"];
	}
	
	public function get_languages( $locale = false ) {
		
		$host_items = $this->ws_request("/models/lang/visibleRecords",array("view_id" => 0));
		
		if($locale && sizeof($host_items["items"]))foreach($host_items["items"] as $key => $i){ if($i["locale"]==$locale){ $host_items["items"] = $i; break; } }
		
		return $host_items["items"];
		
	}
	
	public function get_widget_layouts() {
		
		return array( 
					  "searcher" => esc_html__("Search Engine", 'sofcar'),
					  "contact"  => esc_html__("Contact Form", 'sofcar'),
					  "fleet" 	 => esc_html__("Fleet", 'sofcar'),
					  "vehicle"  => esc_html__("Model", 'sofcar'),
					  "account"  => esc_html__("Customer Area", 'sofcar'),
					);
		
	}
	
	public function get_company_images() {
		
		$host_items = $this->ws_request("/models/company/images",array("view_id" => $this->get_view()));
		
		return $host_items["items"];
	}
	
	public function get_models( $m = false ) {
		
		$host_items = $this->ws_request("/models/model/visibleRecords",array("view_id" => $this->get_view()));
		
		if($m && isset($host_items["items"]) && sizeof($host_items["items"]))
			foreach($host_items["items"] as $key => $i){ if($i["model_id"]==$m){ $host_items["items"] = $i; break; } }
		
		return $host_items["items"];
	}
	
	public function get_vclass( $c = false ) {
		
		$host_items = $this->ws_request("/models/vclass/visibleRecords",array("view_id" => $this->get_view()));
		
		if($c && isset($host_items["items"]) && sizeof($host_items["items"]))
			foreach($host_items["items"] as $key => $i){ if($i["vclass_id"]==$c){ $host_items["items"] = $i; break; } }
		
		return wp_list_sort( $host_items["items"], 'name', 'ASC', true );
	}
	
	public function get_places( $p = false ) {
		
		$host_items = $this->ws_request("/models/place/available/",array("view_id" => $this->get_view()));
		
		if($p && isset($host_items["items"]) && sizeof($host_items["items"]))
			foreach($host_items["items"] as $key => $i){ if($i["place_id"]==$p){ $host_items["items"] = $i; break; } }
		
		return wp_list_sort( $host_items["items"], 'name', 'ASC', true );
	}
	
	public function get_widget_key() {
		
		if($this->validate_token())return 5;
		
	}
	
	public function get_last_bookings( $b = false ) {
		
		$host_items = $this->ws_request("/models/booking/records/last/1/limit/15/",array("view_id" => $this->get_view()));
		
		return wp_list_sort( $host_items["items"], 'booking_id', 'DESC', true );
	}
	
	private function ws_request($uri, $params = null) {
		
		$chost		 = $this->get_host();
				
		$wsprams  	 = array('url' => $chost, 'username'  => $this->get_username(), 'auth'  => $this->get_auth());
		
		$token_cache = $this->get_token();
		
		if (file_exists($token_cache))
			$params["token"] = file_get_contents($token_cache);
		else $params["token"] = $this->auth_request($wsprams);
		
		if($token_cache)file_put_contents($token_cache, $params["token"]);
		
		$response = $this->http_request($uri, $params,$wsprams);
		if (empty($response["error"]))return $response;
		elseif ($response["error"]["error_id"] == 1001) {
			
			$params["token"] = $this->auth_request($wsprams);
			file_put_contents($token_cache, $params["token"]);
			return $this->http_request($uri, $params,$wsprams);
			
		}
		
	}
	
	private function auth_request($wsprams) {
		
		$response = $this->http_request("/models/session/auth", array("username" => $wsprams['username'], "password" => $wsprams['auth']),$wsprams);
		
		if (empty($response["error"]))return $response["token"];
		
		elseif ($response["error"]["error_id"] == 1002)return $response["error"]; 
		
	}
	
	private function http_request($uri, $params, $wsprams) {
		
		$response = wp_remote_post( $wsprams['url'].$uri, array(
			'method'      => 'POST',
			'timeout'     => 45,
			'redirection' => 5,
			'httpversion' => '1.0',
			'blocking'    => true,
			'headers'     => array('Content-type: application/json', 'Content-Length: ' . strlen(json_encode($params)) ),
			'body'        => json_encode($params),
			'cookies'     => array()
			)
		);

		if (is_wp_error($response)) {
			
			$error_message = $response->get_error_message(); 
			
		}else{
		
			return json_decode(wp_remote_retrieve_body($response),1);
		
		}
		
	}
	
}
