<?php
/**
 * Template Name: Internal page
 */
 /* @package WordPress
 * @subpackage ProperWeb
 * @since ProperWeb 2.0
 */

get_header();
remove_filter ('the_content', 'wpautop');

/* Run the loop to output the posts.
 * If you want to overload this in a child theme then include a file
 * called loop-index.php and that will be used instead.
 */
get_template_part( 'loop', 'index' );

//if (!empty($_POST())) do_shortcode('[rp_domain_tabs]');

get_footer(); 

?>