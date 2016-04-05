<?php

/* <HEAD> */

// Clean up <head> tags of unnnesesary links
remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed
remove_action( 'wp_head', 'rsd_link' ); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action( 'wp_head', 'wlwmanifest_link' ); // Display the link to the Windows Live Writer manifest file.
//remove_action( 'wp_head', 'index_rel_link' ); // index link
//remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // prev link
//remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // start link
//remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); // Display relational links for the posts adjacent to the current post.
remove_action( 'wp_head', 'wp_generator' ); // Display the XHTML generator that is generated on the wp_head hook, WP version
//remove emoji
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
//replace older version of jQuery enqued by RP

function pweb_order_form_scripts() {
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
			wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js');
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
}    
 
add_action('wp_enqueue_scripts', 'pweb_order_form_scripts', 100);
/* BODY */

//Replace [...] in the_excerpt
add_filter('excerpt_more', 'pweb_excerpt_more');

function pweb_excerpt_more( $more ) {
    return '... <p class="text-center"><a class="read-more btn btn-primary btn-md round" href="'. get_permalink( get_the_ID() ) . '">' . __('Read More', 'properweb') . '</a></p>';
}

//Custom read-more link in the_content
add_filter( 'the_content_more_link', 'pweb_read_more_link' );

function pweb_read_more_link() {
    return '... <p class="text-center"><a class="read-more btn btn-primary btn-md round" href="' . get_permalink() . '">' . __('Read More', 'properweb') . '</a></p>';
}
