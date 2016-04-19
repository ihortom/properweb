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

// Customize login page
require_once(get_stylesheet_directory().'/functions/login.php'); 
/*
// Register new custom fields in Settings > General
require_once(get_template_directory().'/functions/admin.php'); 

// Register sidebars/widget areas
require_once(get_template_directory().'/functions/sidebars.php'); 

// Add support for meta tags (custom fields)
require_once(get_template_directory().'/functions/meta.php'); 

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
*/

add_shortcode('contact-us', 'pweb_contact_us_shortcode');

//usage [contact-us]
function pweb_contact_us_shortcode() {
    $controller = '/contact.php';
    $contact_form =<<<CONTACT
<div class="pw-panel headline">
<h2>Contact Us</h2>
<div class="row">
    <div class="col-xs-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2"><br>
        <p>Send us a message and we will respond within 24 hours or call our developers in Saskatoon on (306) 491-6539</p>
    </div>
</div>
    <div class="row text-left">
        <div class="panel panel-default pw-contact-form col-xs-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
            <form id="pwcf" action="{$controller}" method="post">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                                <label class="control-label" for="pwcf-name">Your Name:*</label>
                                <div class="input-group">
                                        <span class="glyphicon glyphicon-user input-group-addon"></span>
                                        <input type="text" name="name" id="pwcf-name" class="form-control" placeholder="Your Name">
                                </div>
                        </div>
                        <div class="form-group">
                                <label class="control-label" for="pwcf-company">Company/Organization:</label>
                                <div class="input-group">
                                        <span class="glyphicon glyphicon-map-marker input-group-addon"></span>
                                        <input type="text" name="company" id="pwcf-company" class="form-control" placeholder="Company/Organization">
                                </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="pwcf-email">Contact information:*</label>
                            <a rel="popover" tabindex="0" data-popover-content="#phone-hint" data-trigger="click hover focus" data-original-title="" title=""><span class="glyphicon glyphicon-info-sign alert-info"></span></a>
                            <div id="phone-hint" class="hide">
                                <div class="popover-title">
                                    Phone Number Hint<span class="popover-close"><span class="glyphicon glyphicon-remove"></span></span>
                                </div>
                                <div class="popover-content">123 456-7890</div>
                            </div>
                            <div class="input-group pw-group-item">
                                    <span class="glyphicon glyphicon-envelope input-group-addon"></span>
                                    <input type="email" name="email" id="pwcf-email" class="form-control" placeholder="Email address">
                            </div>
                            <div class="input-group">
                                    <span class="glyphicon glyphicon-earphone input-group-addon"></span>
                                    <input type="tel" name="phone" id="pwcf-phone" class="form-control" placeholder="Phone number: xxx xxx-xxxx">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label" for="pwcf-subject">Subject:*</label>
                            <div class="input-item">
                                <input type="text" name="subject" id="pwcf-subject" class="form-control" placeholder="Topic of the message">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="pwcf-message">Your Message:*</label>
                            <div class="input-item">
                                <textarea name="message" id="pwcf-message" class="form-control" rows="6"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group text-center">
                    <input type="button" id="pwcf-submit" value="Send" class="btn btn-primary btn-lg">
                    <p><sub>* indicates required field</sub></p>
                </div>
                <input type="hidden" name="referer" id="pwcf-referer" value="">
            </form>
        </div>
    </div>
</div>
   
CONTACT;
    return $contact_form;
}

?>