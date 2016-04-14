<?php
/* 
 * Link to the required javascript files and stylesheets in the controlled manner
 */
 
 //replace older version of jQuery enqued by RP

add_action( 'wp_enqueue_scripts', 'pweb_scripts_and_styles' );

function pweb_scripts_and_styles() {
/*    
    // Removes WP version of jQuery
    wp_deregister_script('jquery');
    wp_enqueue_script( 
        'jquery', 
        get_stylesheet_directory_uri() . '/js/vendor/jquery.min.js',
        array(), '2.1.4', true 
    );
*/    
	// js files
	$arrOrders = array();
	if(get_option('rp_order_form')) $arrOrders[] = get_option('rp_order_form');
	if(get_option('rp_shared_order_form')) $arrOrders[] = get_option('rp_shared_order_form');
	if(get_option('rp_vps_virtuozzo_order_form')) $arrOrders[] = get_option('rp_vps_virtuozzo_order_form');
	if(get_option('rp_vps_openvz_order_form')) $arrOrders[] = get_option('rp_vps_openvz_order_form');
	if(get_option('rp_vps_kvm_order_form')) $arrOrders[] = get_option('rp_vps_kvm_order_form');
	if(get_option('rp_semi_dedicated_order_form')) $arrOrders[] = get_option('rp_semi_dedicated_order_form');
	if(get_option('rp_dedicated_order_form')) $arrOrders[] = get_option('rp_dedicated_order_form');
	if(in_array($GLOBALS['wp_query']->post->ID,$arrOrders)){
		if(version_compare(get_bloginfo('version'), '3.5', '>=')){
			wp_deregister_script('jquery');
			wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js', array(), '1.10.2');
			wp_deregister_script('jquery-ui-core');
			wp_register_script('jquery-ui-core', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js');
			
			wp_enqueue_script('jquery');

		}
		else{
			wp_enqueue_script("jquery-1.7.2", 'https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js');
			wp_enqueue_script("jquery-ui-1.8.21",'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/jquery-ui.min.js'); 
		}
		wp_enqueue_script("order-form-msg", get_permalink(get_option('rp_order_form')).'js/ui.achtung-min.js');
		wp_enqueue_script("order-form-common", get_permalink(get_option('rp_order_form')).'js/common.js');
		wp_enqueue_style("order-form", get_permalink(get_option('rp_order_form')).'css/style.css');
		wp_enqueue_style("order-form-achtung", get_permalink(get_option('rp_order_form')).'css/ui.achtung.css');
	}
	wp_enqueue_script("jquery-ui-accordion");
	wp_enqueue_script("jquery-effects-core");
	wp_enqueue_script("jquery-effects-blind");
	wp_enqueue_script("jquery-ui-effects-bounce");
	wp_enqueue_script("jquery-ui-core"); 
	wp_enqueue_script("jquery-tools", get_bloginfo('template_url').'/js/jquery.tools.min.js', array('jquery','jquery-migrate'), '1.2.7');
	wp_enqueue_script("quovolver", get_bloginfo('template_url').'/js/jquery.quovolver.js');
	wp_enqueue_script("flowplayer", get_bloginfo('template_url').'/js/flowplayer-3.2.6.min.js', array(), '3.2.6');  
	wp_enqueue_script('colorbox', get_bloginfo('template_url').'/js/jquery.colorbox-min.js', array('jquery','jquery-migrate'));
	wp_enqueue_script('modernizr', get_bloginfo('template_url').'/js/modernizr-1.7.min.js', array(), '1.7');
	wp_enqueue_script('st-tabs', get_bloginfo('template_url').'/js/init.js');
	wp_enqueue_script('wrap-table', get_bloginfo('template_url').'/js/wrap-table.js');  

	// css files
	wp_enqueue_style("jquery-ui-theme", get_bloginfo('template_url').'/css/style.jquery-ui.css');
		
	wp_enqueue_script( 
			'bootstrap', 
			get_stylesheet_directory_uri() . '/js/bootstrap.min.js', 
			array( 'jquery' ), '3.3.6', true 
	);
	wp_enqueue_script( 
			'site-js', 
			get_stylesheet_directory_uri() . '/js/app.js',
			array( 'jquery' ), '', true 
	);/*
	wp_enqueue_style(
			'bootstrap', 
			get_stylesheet_directory_uri().'/css/bootstrap.min.css',
			array(), '3.3.6'
	);*/
/*
    wp_enqueue_style(
        'site', 
        get_stylesheet_directory_uri().'/style.css'
    );*/	
		$parent_style = 'rpcs-style';
		wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css', array(), '1.1.4' );    
                wp_enqueue_style( 'pweb-style', get_stylesheet_directory_uri() . '/style.css', array( $parent_style ), '2.0');    
                /*
                wp_enqueue_script( 'pweb-signin', 
		
		//move this to app.js
		get_stylesheet_directory_uri() . '/js/signin.js', array('jquery'));*/
}
?>
