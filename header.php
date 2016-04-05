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