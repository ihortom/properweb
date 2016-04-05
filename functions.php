<?php

if ( ! isset( $content_width ) ) {
	$content_width = 1200;
}

// Removing all the junk from wordpress head we don't need.
require_once(get_stylesheet_directory().'/functions/cleanup.php'); 

// Add relevant stylesheets and scripts within <head> tags (register scripts and stylesheets)
require_once(get_stylesheet_directory().'/functions/enqueue-scripts.php'); 

// Add menu compatible with 'bootstrap' framework
require_once(get_stylesheet_directory().'/functions/menu.php');
require_once(get_stylesheet_directory().'/functions/menu-walkers.php'); 
/*
// Register new custom fields in Settings > General
require_once(get_template_directory().'/functions/admin.php'); 

// Register sidebars/widget areas
require_once(get_template_directory().'/functions/sidebars.php'); 

// Add support for meta tags (custom fields)
require_once(get_template_directory().'/functions/meta.php'); 

// Customize login page
require_once(get_template_directory().'/functions/login.php'); 

// Theme support (featured image)
require_once(get_template_directory().'/functions/theme-support.php'); 

// Pagination compatible with 'foundation' markup
require_once(get_template_directory().'/functions/pagination.php'); 

// Custom comments list
require_once(get_template_directory().'/functions/comments.php');

// Custom search form
require_once(get_template_directory().'/functions/search-form.php');

// Custom paginated gallery
require_once(get_template_directory().'/functions/gallery.php');

function pweb_theme_enqueue_styles() {

    $parent_style = 'rp-style';

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'pweb-style', get_stylesheet_directory_uri() . '/style.css', array( $parent_style ));
    wp_enqueue_script( 'pweb-signin', get_stylesheet_directory_uri() . '/js/signin.js', array('jquery'));
}
add_action( 'wp_enqueue_scripts', 'pweb_theme_enqueue_styles' );
*/
function pweb_theme_footer_widget() {
    if ( is_active_sidebar( 'sidebar-1' ) ) { unregister_sidebar('sidebar-1'); }
    register_sidebar( array(
        'name' => 'Footer Sidebar',
        'id' => 'footer-sidebar',
        'description' => 'Widget to display contacts',
        'before_widget' => '',
	'after_widget'  => '',
	'before_title'  => '<h3><img src="/images/logo24_framed.png" alt="Logo" style="padding-right:10px;vertical-align: middle;">',
	'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'pweb_theme_footer_widget' );
?>
<?php
function pweb_login_logo() { ?>
    <style type="text/css">
        .login h1 a {
            background-image: url('/images/logo.png') !important;
            padding-bottom: 5px;
        }
    </style>
<?php } 
add_action( 'login_enqueue_scripts', 'pweb_login_logo' );
?>