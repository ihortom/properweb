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

// Add support for promo-flash on pages
require_once(get_stylesheet_directory().'/functions/meta.php');

/*
// Register new custom fields in Settings > General
require_once(get_template_directory().'/functions/admin.php'); 

// Register sidebars/widget areas
require_once(get_template_directory().'/functions/sidebars.php'); 

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
    register_sidebar( array(
        'name' => 'Footer Sidebar',
        'id' => 'footer-sidebar',
        'description' => 'Widget to display contacts',
        'before_widget' => '',
	'after_widget'  => '',
	'before_title'  => '<h3><img src="/images/logo24.png" alt="Logo" style="padding-right:10px;vertical-align: middle;">',
	'after_title'   => '</h3>',
    ) );
}

add_action( 'widgets_init', 'pweb_theme_footer_widget' );

//Hookup contact_form POST request to admin_post.php
add_action( 'admin_post_nopriv_contact_form', 'pweb_send_contact_form' );
add_action( 'admin_post_contact_form', 'pweb_send_contact_form' );

function pweb_send_contact_form() {
    
    if (!(empty($_POST) && empty($_GET))) {
        // get posted data into local variables
        $email_to = get_bloginfo('admin_email');
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $email_from = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL); 
        $subject = "[ProperWeb]: " . filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING); 
        $subject = "=?utf-8?b?" . base64_encode($subject) . "?=";
        $company = filter_input(INPUT_POST, 'company', FILTER_SANITIZE_STRING); 
        $phone = filter_input(INPUT_POST, 'phone'); 
        $referer = filter_input(INPUT_POST, 'referer', FILTER_VALIDATE_URL);
        $userip = ($_SERVER['X_FORWARDED_FOR']) ? $_SERVER['X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
        date_default_timezone_set('America/Regina');
        $message = '<html><head><title>'.$subject.'</title></head><body style="font-family:Arial,Geneva,sans-serif">'.
            '<p><b>Name</b>: '.$name.'</p>'.
            '<p><b>Email</b>: '.$email_from.'</p>'.
            '<p><b>Company</b>: '.$company.'</p>'.
            '<p><b>Contact number</b>: '.$phone.'</p>'.
            '<h3>Message:</h3><div>'.nl2br(filter_input(INPUT_POST, 'message'),false).'</div><br><hr>'.
            '<p style="font-family:monospace;font-size: 12px"><b>Referrer URL</b>: '.$referer.'<br>'.
            '<b>IP address</b>: '. $userip.'<br>'.
            '<b>Date/Time</b>: '.date('Y-m-d H:i').'<br>'.
            '<b>User agent</b>: '.$_SERVER['HTTP_USER_AGENT'].'</p></body></html>';
       
        $headers  = 'MIME-Version: 1.0' . "\r\n"; 
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";  

        //$success = false;
        
        // send email  
        $success = mail($email_to, $subject, $message, $headers
                                . "From: =?utf-8?b?" . base64_encode($name) . "?= <" . $email_from . ">\r\n"
              . "X-Mailer: PHP/" . phpversion() . "\r\n"
              . "X-From-IP: " . $userip);
        
        if ($success) {
            header("Location: {$referer}?message=sent#contact-us");
        }
        else {
            header("Location: {$referer}?message=error#contact-us");
        }
    }
}
    

add_shortcode('pw-contact-us', 'pweb_contact_us_shortcode');

//usage [pw-contact-us]
function pweb_contact_us_shortcode() {
    $controller = esc_url( admin_url('admin-post.php') );
    $state = '';
    if ($_GET['message']=='sent') { $message = '<div class="alert alert-success" role="alert">
    <span class="glyphicon glyphicon-ok gl-pad-right"></span> Your message has been sent successfully.
    </div>'; 
    $state = ' hidden';
    }
    elseif ($_GET['message']=='error') { $message = '<div class="alert alert-warning" role="alert">
    <span class="glyphicon glyphicon-warning-sign gl-pad-right"></span> Your  message has not been sent. Please, try again later.
    </div>'; 
    $state = ' hidden';
    }
    $contact_form =<<<CONTACT
<div class="pw-panel headline" id="contact-us">
    <h2>Contact Us</h2>
    <div class="row">
        <div class="col-xs-12 col-md-10 col-md-offset-1"><br>
            <p>Send us a message and we will respond within 24 hours or call our developers in Saskatoon on (306) 491-6539</p>
        </div>
    </div>
    <div class="row no-gutters">
        <div class="col-xs-12 col-md-10 col-md-offset-1">
            {$message}
        </div>
    </div>
    <div class="row text-left{$state}">
        <div class="panel panel-default pw-contact-form col-xs-12 col-md-10 col-md-offset-1">
            <form id="pwcf" action="{$controller}" method="post">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label" for="pwcf-name">Your name:*</label>
                            <div class="input-group">
                                <span class="glyphicon glyphicon-user input-group-addon"></span>
                                <input type="text" name="name" id="pwcf-name" class="form-control" placeholder="Your name">
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
                            <label class="control-label" for="pwcf-message">Your message:*</label>
                            <div class="input-item">
                                <textarea name="message" id="pwcf-message" class="form-control" rows="6"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group text-center">
                    <div class="row">
                        <div class="progress invisible col-sm-6 col-sm-offset-3">
                            <div class="progress-bar progress-bar-striped active" role="progressbar" style="width:10%"></div>
                        </div>
                    </div>
                    <input type="button" id="pwcf-submit" value="Send" class="btn btn-primary btn-lg">
                    <p><sub>* indicates required field</sub></p>
                </div>
                <input type="hidden" name="referer" id="pwcf-referer" value="">
                <input type="hidden" name="action" value="contact_form">
            </form>
        </div>
    </div>
</div>
   
CONTACT;
    return $contact_form;
}

//Create shortcode for promotions to use the featured image as a background image
//and to highlight the promo's startand end date
add_shortcode('promo', 'pweb_promo');

//usage [promo start="mm/dd/yy" end="mm/dd/yy" height="px" bgsize="%" line=""]
function pweb_promo( $atts, $content = null  ) {
    global $featured_image_url;
    $regex = "/^[0-1][0-9]\/[0-3][0-9]\/[1-2][0-9]$/";	//american format
    $dated = true;
    
    $atts = shortcode_atts(
        array(
            'start' => false,
            'end'   => false,
            'height'=> 'auto',
            'bgsize'=> '100',
            'line'  => '1'
        ), $atts, 'promo' );
    
    $start = preg_match($regex, trim($atts['start']), $start_date);
    $end = preg_match($regex, trim($atts['end']), $end_date);
    try {
        if ( $start && $end ) {
                $start = new DateTime($start_date[0]);
                $end = new DateTime($end_date[0]);
        }
        elseif ( $start ) {
                $start = new DateTime($start_date[0]);
        }
        elseif ( $end ) {
                $end = new DateTime($end_date[0]);
        }
        else $dated = false;
    }
    catch (Exception $e) { $dated = false; }

    if ( $dated ) { 
        if ( $start && $end ) {
                $range = date_format($start, get_option( 'date_format' )) . ' – '. date_format($end, get_option( 'date_format' ));
        }
        elseif ( $start ) $range = date_format($start, get_option( 'date_format' ));
        else $range = 'ends <em>' . date_format($end, get_option( 'date_format' )).'</em>';
        $period = 
            '<div class="row meta-data">'
            . '<p class="col-sm-12 promo-date"><span class="glyphicon glyphicon-calendar gl-pad-right"></span> ' . $range . '</p>'
            . '<div class="clearfix"></div>';
    }
    else $period = '';
    return ($period . '<div class="promo" style="height:'.$atts['height'].'px;background-size:'.$atts['bgsize'].'%; background-image: url('.$featured_image_url.'); line-height:'.$atts['line'].'">'. $content . '</div>');
}

//create shortcode to make a separator of the new article within the page
add_shortcode('promo_flash', 'pweb_promo_flash');

//usage [promo_flash id="#"] where id is the relevant promo post ID
function pweb_promo_flash( $atts ) {
    
    $atts = shortcode_atts(
        array(
                'id' => 0,
        ), $atts, 'promo_flash' );
    
    $promo_post = get_posts( array( 
        'include' => array($atts['id']), 
        'post_type' => 'post',
        'post_status' => 'publish') 
    );
    
    return '
        <div class="alert alert-info alert-promo alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <p class="flashref">
                <span class="glyphicon glyphicon-gift gl-pad-right"></span> 
                <a href="#flash" class="alert-link" data-toggle="modal">CURRENT PROMOTIONS</a>
            </p>
        </div>
        <div id="flash" class="text-center modal fade" tabindex="-1" role="dialog" aria-labelledby="flashTitle">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <span class="glyphicon glyphicon-remove"></span>
                        </button>
                        <h2 id="flashTitle" class="page-header title modal-title">'.strip_tags($promo_post[0]->post_title).'</h2>                   
                    </div>
                    <div class="modal-body">'.
                        wpautop( do_shortcode($promo_post[0]->post_content) ) .
                    '</div>
                </div>
            </div>
        </div>';
}

?>