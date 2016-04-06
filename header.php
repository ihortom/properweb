<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package WordPress
 * @subpackage Cloud Servers
 * @since ProperWeb 2.0
 */
 $custom_meta = get_post_custom();
global $theme_options;
foreach ($theme_options as $value) {
    if (get_option( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_option( $value['id'] ); }
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
if(empty($custom_meta['rpwp_meta_title'][0])){
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) );
}else{
	echo apply_filters('the_title', strip_tags(do_shortcode($custom_meta['rpwp_meta_title'][0])));
}
	?></title>
<?php if(isset($custom_meta['rpwp_meta_description'][0])){ ?><meta name="description" content="<?php echo apply_filters('the_title', strip_tags(do_shortcode($custom_meta['rpwp_meta_description'][0])));?>" /><?php } ?>
<?php if(isset($custom_meta['rpwp_meta_keywords'][0])){ ?><meta name="keywords" content="<?php echo apply_filters('the_title', strip_tags(do_shortcode($custom_meta['rpwp_meta_keywords'][0])));?>" /><?php } ?>
<?php if(!empty($_GET['color'])) $csscolor = $_GET['color']; elseif(!empty($rpwp_theme_color_scheme) and in_array($rpwp_theme_color_scheme, $GLOBALS['theme_colors'])) $csscolor = $rpwp_theme_color_scheme;  else $csscolor = $GLOBALS['theme_color_default']; ?>

<script type="text/javascript">
var template_directory = "<?php bloginfo('template_directory') ?>";
</script>
<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' );

	wp_head();
?>
<!--[if IE 8]>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/style-ie-8.css" />
<![endif]-->
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/colorbox.css" />
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic" rel="stylesheet" type="text/css">
</head>

<body <?php body_class(); ?>>
<div id="wrapper_fixed">
	<div id="header_top" class="clearfix">
		<div id="phone"><span class="glyphicon glyphicon-earphone"></span></div>
		<div id="hosting_phone">
			 Hosting <span>(ID:<?php echo $GLOBALS['rp_info']['store_id'];?>)</span> <span class="number">+<?php if (function_exists('rp_support_phone')) echo substr(rp_support_phone(), 1); ?> | </span>
		</div>
		<div id="dev_phone">Development 306-491-6539</div>
                
                <div id="login-form-text" class="left-drop has-dropdown not-click">
                    <a id="signin" class="btn btn-md btn-primary"><span class="glyphicon glyphicon-log-in"></span>&nbsp; Sign In</a>
			<ul id="menu-form" class="dropdown" style="display: none;">
				<li id="form-body" class="has-form radius animated fadeInUp">
					<form id="login-to-cp" method="post" action="//supremecenter.com/login/">
						<div class="row sticky">
							<div class="large-4 show-for-large-up columns">
								<label for="user" class="right inline">Username</label>
							</div>
							<div class="large-8 columns">
								<input id="user" type="text" name="username" placeholder="Username">
							</div>
						</div>
						<div class="row sticky">
							<div class="large-4 show-for-large-up columns">
								<label for="password" class="right inline">Password</label>
							</div>
							<div class="large-8 columns">
								<input id="password" name="password" type="password" placeholder="Password">
							</div>
							<input id="returnURL" name="returnURL" type="hidden" value="/">
						</div>
						<div class="row sticky links">
							<div class="large-3 small-4 columns right">
								<input type="submit" value="Login" class="button round sign-in-button">
							</div>
							<div class="large-5 small-4 columns text-center right"><a href="" id="forgot-btn" class="active">Forgot password?</a></div>
							<div class="large-4 small-4 columns text-center right"><a href="" id="webmail-btn" class="active">Webmail Login</a></div>
						</div>
					</form>
					<form id="login-to-webmail" method="post" action="//webmail.supremecluster.com">
						<div class="row sticky">
							<div class="large-4 show-for-large-up columns">
								<label class="right inline">E-mail</label>
							</div>
							<div class="large-8 columns">
								<input type="text" name="_user" placeholder="E-mail">
							</div>
							<div class="large-8 columns">
								<input type="hidden" name="_action" value="login">
							</div>
							<div class="large-8 columns">
								<input type="hidden" name="_token" value="token">
							</div>
						</div>
						<div class="row sticky">
							<div class="large-4 show-for-large-up columns">
								<label for="mail-password" class="right inline">Password</label>
							</div>
							<div class="large-8 columns">
								<input id="mail-password" name="_pass" type="password" placeholder="Password">
							</div>
						</div>
						<div class="row sticky links">
							<div class="large-5 small-8 columns"><a href="" class="back-btn active">« Back to CP Login</a></div>
							<div class="large-3 small-4 columns right">
								<input type="submit" value="Login" class="button round sign-in-button">
							</div>
						</div>
					</form>
					<form id="forgotten-pass" method="post" action="//supremecenter.com/login/lost-password/">
						<div class="row sticky">
							<div class="large-4 show-for-large-up columns">
								<label class="right inline">Username</label>
							</div>
							<div class="large-8 columns">
								<input type="text" name="username" placeholder="Username">
							</div>
						</div>
						<div class="row sticky">
							<div class="large-4 show-for-large-up columns">
								<label for="forgot-mail" class="right inline">E-mail</label>
							</div>
							<div class="large-8 columns">
								<input type="text" id="forgot-mail" name="email" placeholder="E-mail">
							</div>
						</div>
						<div class="row sticky links">
							<div class="large-5 small-8 columns"><a href="" class="back-btn active">« Back to CP Login</a></div>
							<div class="large-3 small-4 columns right">
								<input type="submit" value="Submit" class="button round sign-in-button">
							</div>
						</div>
					</form>
				</li>
			</ul>
		</div>
	</div>
	<div id="header">
		<div id="header_logo" class="clearfix">
			<?php if (get_option('rpwp_logo_url')) : ?>
				<img src="<?php echo get_option('rpwp_logo_url'); ?>" alt="ProperWeb Logo">
			<?php else : ?>
				<img src="/images/logo.png" alt="ProperWeb Logo">
			<?php endif; ?>
			<h1><a href="<?php echo home_url()?>"><?php bloginfo('name')?></a></h1>
			<h2><?php bloginfo('description')?></h2>
		</div>
	</div>
	
	<?php include_once get_stylesheet_directory().'/parts/topbar.php'; ?>
	
	<?php if(function_exists('is_rp_page')){ if(!is_front_page() and is_rp_page($wp_query->post->ID) and function_exists('rp_breadcrumbs')) rp_breadcrumbs($wp_query->post->ID); elseif(function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); } ?>
	<div id="content" class="position">