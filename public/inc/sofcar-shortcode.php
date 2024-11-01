<?php

/**
 * The public-facing functionality of the plugin.
 *
 *
 * @package    Sofcar
 * @subpackage Sofcar/public
 * @author     Sofcar <info@sofcar.com>
 */

function init_shortcodes(){
	
	add_shortcode('sofcar-searcher','short_searcher');	
	
	add_shortcode('sofcar-fleet','short_fleet');
	
	add_shortcode('sofcar-contact','short_contact');
	
	add_shortcode('sofcar-vehicle','short_vehicle');
	
	add_shortcode('sofcar-account','short_account');
}	


add_action('init', 'init_shortcodes'); 


function render_shortcode($atts, $widget){
	
	$sofcar_api = new Sofcar_Api();
	
	if($sofcar_api->validate_token()){ 
		
		extract(shortcode_atts(array(
			'width'				=>'100%',
			'result_width'		=>'100%',
			'include_jquery'	=> '0',
			'view'				=> '1',
			'result_view'		=> 'list',
			'vclass'			=> '',
			'vprice'			=> '0',
			'include_css'		=> '',
			'model'				=> '',
			'featured_items'	=> '5',
			'autoload'			=> '0',
			'autoscroll'		=> '0',
			'layout'			=> 'block',
			'key'				=> ''
		), $atts));
		
		if($widget=="result")return '<div id="irc_result" style="width: '.$result_width.';"></div>';
		
		if(!empty($view))$view = $sofcar_api->get_view();
		
		$wsrc  = $sofcar_api->get_host().'/widget/?include_jquery='.$include_jquery.'&view_id='.$view.'&result_view='.$result_view.'&include_css='.$include_css;
		
		if(!empty($key)){ $wsrc .="&key=".$key; }else{ $wsrc .= "&key=".$sofcar_api->get_widget_key(); }
		
		if(!empty($model)) $wsrc .="&vehicle_id=".$model;
		
		if($autoload)$wsrc .= '&autoload=1';
		
		$wsrc .= '&autoscroll='.$autoscroll;
		
		if($include_css)$wsrc .= '&include_css='.$include_css;
		
		$result_wiget  =  '<div id="irc_'.$widget.'" style="width: '.$width.';"></div>';
		
		if($widget=="modeldata")$result_wiget  =  '<div id="irc_vehicle" style="width: '.$width.';"></div>';
		
		if(($widget=='searcher') && $layout=="block")$result_wiget .= '<div id="irc_result" style="width: '.$result_width.';"></div>';
		
		return '<script async="async" src="'.esc_url($wsrc).'"></script>'.$result_wiget;
		
	}else{  
		
		return esc_html__("Incorrect settings. Check your Sofcar settings." , "sofcar"); 
		
	}
}	

function short_searcher($attrs){ 
	
	return render_shortcode($attrs, "searcher");  
	
}

function short_fleet($attrs){ 
	
	return render_shortcode($attrs, "fleet");  
	
}

function short_contact($attrs){ 
	
	return render_shortcode($attrs, "contact");  
	
}

function short_account($attrs){ 
	
	return render_shortcode($attrs, "account");  
	
}

function short_vehicle($attrs){ 
	
	return render_shortcode($attrs, "vehicle");  
	
}