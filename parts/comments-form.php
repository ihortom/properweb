<form action="<?php echo site_url(); ?>/wp-comments-post.php" method="post" id="commentform">
    <div class="row">
        <?php if ( is_user_logged_in() ) : ?>
            <?php $current_user = wp_get_current_user(); ?>
        <br>
        <div class="col-sm-6"><?php _e('Logged in as','properweb'); printf(' <a href="%1$s">%2$s</a>.', get_edit_user_link(), $current_user->display_name); ?></div>
        <div class="col-sm-6 text-right">
            <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php esc_attr_e('Log out of this account'); ?>"><?php _e('Log out'); ?>
            <span class="glyphicon glyphicon-log-out"></span></a> 
        </div><br>
        <?php else : ?>

        <p class="text-center secondary"><small><?php _e('Your e-mail will not be shared. All the fields are mandatory.','properweb'); ?> *</small></p>
        <div class="col-sm-6 contacts">
            <div id="contacts" class="row no-gutters">
                <div id="name" class="col-md-12 col-lg-6">
                    <div class="row no-gutters">
                        <div class="col-md-12">
                            <label for="author"><?php _e('Name:','properweb'); ?> <?php if ($req) echo '*'; ?></label>
                        </div>
                        <div class="col-md-12">
                            <input type="text" name="author" id="author" value="<?php echo @esc_attr($comment_author); ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
                        </div>
                    </div>
                </div>

                <div id="email" class="col-md-12 col-lg-6">
                    <div class="row no-gutters">
                        <div class="col-md-12">
                            <label for="email"><?php _e('Email:','properweb'); ?> <?php if ($req) echo '*'; ?></label>
                        </div>
                        <div class="col-md-12">
                            <input type="text" name="email" id="email" value="<?php echo @esc_attr($comment_author_email); ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
        <div class="<?php if ( is_user_logged_in() ) : ?>col-sm-12<?php else : ?>col-sm-6<?php endif; ?> message">
            <div id="message" class="row no-gutters">
                <div class="col-md-12">
                    <label for="comment"><?php _e('Message:','properweb'); ?> *
                        <a href="#" rel="popover" tabindex="0" data-popover-content="#msg_tags" data-trigger="click hover focus">
                           <span class="glyphicon glyphicon-info-sign alert-info"></span></a>
                    </label>
                </div>
                <div id="msg_tags" class="hide">
                    <div class="popover-title">
                        <?php _e('Allowed HTML tags','properweb'); ?>
                        <span class="popover-close"><span class="glyphicon glyphicon-remove"></span></span>
                    </div>
                    <?php printf('<div class="popover-content"><small><code>%s</code></small></div>', allowed_tags()); ?>
                </div>
                <div class="col-md-12">
                    <textarea name="comment" id="comment" cols="40" rows="6" tabindex="4"></textarea>
                </div>
            </div>
        </div>
        <div class="clearfix text-center with-pads">
            <input name="submit" type="submit" id="submit" class="btn btn-primary btn-md round" tabindex="5" value="<?php _e('Submit','properweb'); ?>" />
            <?php comment_id_fields(); ?>
        </div>
    </div>
    <?php
        /** This filter is documented in wp-includes/comment-template.php */
        //@do_action( 'comment_form', $post->ID );
    ?>
    
</form>