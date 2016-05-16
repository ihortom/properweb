<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  Calls sidebar-footer.php for bottom widgets.
 *
 * @package WordPress
 * @subpackage ProperWeb
 * @since ProperWeb 2.0
 */
?>
        </div>
        <div id="footer" class="container-fluid">
            <div class="row">
                <div class="col-sm-6 col-md-7">
                    <div class="row no-gutters">
                <div class="footer_menu col-md-7">
                <?php if(is_active_nav_menu('footer1')){?>
                        <h3><?=wp_nav_menu_title('footer1');?></h3>
                        <?php wp_nav_menu( array( 'container' =>'' ,'link_before' => ' ', 'fallback_cb' => '' , 'theme_location' => 'footer1' , 'depth' =>1) );?>
                <?php }else{?>
                        <h3>About Us</h3>
                        <ul class="menu">
                            <li class="menu-item"><a href="<?php echo get_permalink(get_option('rp_about_us'));?>">About Us</a></li>
                            <li class="menu-item"><a href="<?php echo rp_default_page_link(array('key'=>"whyus"))?>">Why Us</a></li>
                            <li class="menu-item"><a href="<?php echo get_permalink(get_option('rp_contact_us'));?>">Contact Us</a></li>
                            <li class="menu-item"><a href="<?php echo get_permalink(get_option('rp_customer_support'));?>">Customer Support</a></li>
                            <li class="menu-item"><a href="<?php echo get_permalink(get_option('rp_videos'));?>">Videos</a></li>
                            <li class="menu-item"><a href="<?php echo get_permalink(get_option('rp_main_terms'));?>">Terms and Conditions</a></li>
                        </ul>
                <?php }?>
                </div>
                <div id="footer-follow-us" class="footer_menu col-sm-6 col-md-5">
                <?php if(is_active_nav_menu('footer3')){?>
                        <h3><?=wp_nav_menu_title('footer3');?></h3>
                        <?php wp_nav_menu( array( 'container' =>'' ,'link_before' => ' ', 'fallback_cb' => '' , 'theme_location' => 'footer3' , 'depth' =>1) );?>
                <?php }else{?>
                        <h3>Follow Us</h3>
                        <ul class="menu">
                            <li class="menu-item"><a href="https://www.facebook.com/ProperWeb"><span class="glyphicon icon-facebook2 gl-pad-right"></span>Facebook</a></li>
                            <li class="menu-item"><a href="https://twitter.com/proper_web"><span class="glyphicon icon-twitter gl-pad-right"></span>Twitter</a></li>
                        </ul>
                <?php }?>
                </div>
                </div><!-- nested row -->
                </div>
                <div id="footer-contacts" class="footer_menu col-sm-6 col-md-5">
                    <?php if (is_active_nav_menu('footer4')) {?>
                    <h3><?=wp_nav_menu_title('footer4');?></h3>
                    <?php wp_nav_menu( array( 'container' =>'' ,'link_before' => ' ', 'fallback_cb' => '' , 'theme_location' => 'footer4' , 'depth' =>1) );?>
                    <?php } else if ( is_active_sidebar('footer-sidebar') ) { dynamic_sidebar( 'footer-sidebar' ); } else { ?>
                    <h3><img src="/images/logo24.png" alt="Logo" style="padding-right:10px;vertical-align: middle;">PROPERWEB</h3>
                    <div class="textwidget">
                        <ul id="footer-contacts-sidebar" class="menu">
                            <li class="menu-item" style="font-weight:bold">Website Development</li>
                            <li class="menu-item">Canada Phone: +1-306-491-6539</li>
                            <li class="menu-item">&nbsp;</li>
                            <li class="menu-item" style="font-weight:bold">Hosting Support</li>
                            <?php global $rp_info;?>
                            <li class="menu-item">Our ID: <?php echo $GLOBALS['rp_info']['store_id'];?></li>
                            <li class="menu-item">CA/US Toll Free: <?php echo @$rp_info['company']['us_phones'][0]?></li>
                            <li class="menu-item">US Phone: <?php echo @$rp_info['company']['us_phones'][1]?></li>
                            <li class="menu-item">UK Phone: <?php echo @$rp_info['company']['uk_phones'][0]?></li>
                            <li class="menu-item">AU Phone: <?php echo @$rp_info['company']['au_phones'][0]?></li>
                        </ul>
                    </div>
                </div>
                    <?php } ?>
                </div>
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
    </body>
</html>