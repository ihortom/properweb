<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  Calls sidebar-footer.php for bottom widgets.
 *
 * @package WordPress
 * @subpackage Cloud Servers
 * @since Cloud Servers 1.0
 */
global $theme_options;
foreach ($theme_options as $value) {
    if (get_option( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_option( $value['id'] ); }
}
?>
	</div>

	<div id="footer-full-width">
		<div id="footer">
				<div id="footer_menu">
				<?php if(is_active_nav_menu('footer1')){?>
					<h3><?=wp_nav_menu_title('footer1');?></h3>
					<?php wp_nav_menu( array( 'container' =>'' ,'link_before' => ' ', 'fallback_cb' => '' , 'theme_location' => 'footer1' , 'depth' =>1) );?>
				<?php }else{?>
					<h3>About Us</h3>
					<ul class="menu">
							<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo get_permalink(get_option('rp_about_us'));?>">About Us</a></li>
							<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo rp_default_page_link(array('key'=>"whyus"))?>">Why Us</a></li>
							<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo get_permalink(get_option('rp_contact_us'));?>">Contact Us</a></li>
							<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo get_permalink(get_option('rp_customer_support'));?>">Customer Support</a></li>
							<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo get_permalink(get_option('rp_videos'));?>">Videos</a></li>
							<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo get_permalink(get_option('rp_main_terms'));?>">Terms and Conditions</a></li>
					</ul>
				<?php }?>
				</div>
				<div id="footer_menu">
				<?php if(is_active_nav_menu('footer2')){?>
					<h3><?=wp_nav_menu_title('footer2');?></h3>
					<?php wp_nav_menu( array( 'container' =>'' ,'link_before' => ' ', 'fallback_cb' => '' , 'theme_location' => 'footer2' , 'depth' =>1) );?>
				<?php }else{?>
					<h3>Our Control Panel</h3>
					<ul class="menu">
							<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo get_permalink(get_option('rp_hepsia_cp'));?>">Hepsia CP</a></li>
							<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo get_permalink(get_option('rp_hepsia_vs_cpanel'));?>">Hepsia v. cPanel</a></li>
							<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo get_permalink(get_option('rp_domain_manager'));?>">Domain Manager</a></li>
							<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo get_permalink(get_option('rp_file_manager'));?>">File Manager</a></li>
							<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo get_permalink(get_option('rp_email_manager'));?>">E-mail Manager</a></li>
							<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo get_permalink(get_option('rp_web_accelerators'));?>">Web Accelerators</a></li>
					</ul>
				<?php }?>
				</div>
				<div id="footer_menu">
				<?php if(is_active_nav_menu('footer3')){?>
					<h3><?=wp_nav_menu_title('footer3');?></h3>
					<?php wp_nav_menu( array( 'container' =>'' ,'link_before' => ' ', 'fallback_cb' => '' , 'theme_location' => 'footer3' , 'depth' =>1) );?>
				<?php }else{?>
					<h3>Hosting Articles</h3>
					<ul class="menu">
							<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo get_permalink(get_option('rp_articles_main'));?>">Web Hosting Articles</a></li>
					<?php if(is_array($GLOBALS['rp_settings']['footer_article_links'])){ ?>
						<?php foreach($GLOBALS['rp_settings']['footer_article_links'] as $value){ $cmeta = get_post_custom(get_option(rp_default_page_id(array('key'=>'article_'.$value)))); ?><li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo rp_default_page_link(array('key'=>'article_'.$value))?>"><?php echo $cmeta['rpwp_menu_title'][0]; ?></a></li><?php }?>
					<?php }else{ ?>
							<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo rp_default_page_link(array('key'=>"article_rp_article_vps_hosting"))?>">VPS Hosting Explained</a></li>
							<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo rp_default_page_link(array('key'=>"article_rp_article_dedicated_hosting"))?>">Dedicated Hosting</a></li>
							<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo rp_default_page_link(array('key'=>"article_rp_article_web_hosting_hosting"))?>">Web Hosting Definition</a></li>
							<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo rp_default_page_link(array('key'=>"article_rp_article_semi_dedicated_hosting"))?>">Semi-Dedicated Hosting</a></li>
							<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo rp_default_page_link(array('key'=>"article_rp_article_domain_names"))?>">Domain Names</a></li>
							<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo rp_default_page_link(array('key'=>"article_rp_article_what_is_cloud_hosting"))?>">What is Cloud Hosting</a></li>
					<?php } ?>
					</ul>
				<?php }?>
				</div>
			<div id="footer_menu">
				<?php if(is_active_nav_menu('footer4')){?>
				<h3><?=wp_nav_menu_title('footer4');?></h3>
				<?php wp_nav_menu( array( 'container' =>'' ,'link_before' => ' ', 'fallback_cb' => '' , 'theme_location' => 'footer4' , 'depth' =>1) );?>
				<?php }else{?>
				<h3>Application Hosting</h3>
				<ul class="menu">
					<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo get_permalink(get_option('rp_wordpress_hosting'));?>">WordPress Hosting</a></li>
					<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo get_permalink(get_option('rp_prestashop_hosting'));?>">PrestaShop Hosting</a></li>
					<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo get_permalink(get_option('rp_opencart_hosting'));?>">OpenCart Hosting</a></li>
					<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo get_permalink(get_option('rp_joomla_hosting'));?>">Joomla Hosting</a></li>
					<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo get_permalink(get_option('rp_drupal_hosting'));?>">Drupal Hosting</a></li>
					<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo get_permalink(get_option('rp_moodle_hosting'));?>">Moodle Hosting</a></li>
				</ul>
				<?php }?>
			</div>
<!--
			<div class="clear"></div>
			<div id="footer_contacts">
				<span><?php global $rp_info;?> US Toll Free Phone: <?php echo @$rp_info['company']['us_phones'][0]?></span>
				<span> UK Phone: <?php echo @$rp_info['company']['uk_phones'][0]?></span>
				<span> AU Phone: <?php echo @$rp_info['company']['au_phones'][0]?></span>
			</div>
-->
			<div id="copyright">
				<?php if(!empty($rpwp_copyright_text)) echo stripslashes($rpwp_copyright_text); else{?> Copyright &copy; <?php echo $GLOBALS['rp_info']['store_title']?> 2014 - <?php echo date('Y')?> | Tomilenko Company | All Rights Reserved<?php }?>
			</div>
		</div>
	</div>
</div><!-- wrapper_fixed -->
<?php
	if(function_exists('rp_footer')) rp_footer();
	wp_footer();
	// Google Analytics Code here
	if(!empty($rpwp_analytics_code)) echo stripslashes($rpwp_analytics_code);
?>
</body></html>