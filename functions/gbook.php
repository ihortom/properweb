<?php if ( comments_open() ) : ?>
    <div id="gbook">
	<div id="respond" class="panel panel-default">
            <h3><?php comment_form_title( __('LEAVE A MESSAGE IN THE GUEST BOOK', 'properweb') ); ?></h3>

            <div id="cancel-comment-reply">
                    <small><?php cancel_comment_reply_link() ?></small>
            </div>

            <?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
                    <p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.'), wp_login_url( get_permalink() )); ?></p>
            <?php else : ?>

            <?php 
                $req = get_option('require_name_email');
                include_once dirname(dirname(__FILE__)).'/parts/comments-form.php'; 
            ?>

            <?php endif; // If registration required and not logged in ?>
        </div>
	
<!-- COMMENTS -->
<?php if ( !is_user_logged_in() ) : ?>
    <?php if ( have_comments() ) : ?>
        <div id="comments">	
                <h3 class="gbook-stats"><span class="glyphicon glyphicon-comment"></span> 
                    <?php
                        printf( _n( '%1$s message in %2$s', '%1$s messages in %2$s', get_comments(array('post_id' => $post->ID, 'count' => true )),
                            'properweb' ), number_format_i18n( get_comments(array('post_id' => $post->ID, 'count' => true )) ), 
                            '&#8220;' . __('Guest Book','properweb') . '&#8221;' ); 
                    ?>
                </h3>

                <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
                <div class="gbook-navigation nav-top">
                        <div class="alignright"><?php previous_comments_link(' <span class="glyphicon glyphicon-forward"></span> ') ?></div>
                        <div class="alignright"><?php next_comments_link(' <span class="glyphicon glyphicon-backward"></span> ') ?></div>
                </div>
                <div class="clearfix"></div>
                <?php endif; // check for comment navigation ?>

                <ul class="comment-list">
                        <?php wp_list_comments('type=comment&callback=pweb_comments'); //use custom comment list in functions.php ?>
                </ul>

                <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
                <div class="gbook-navigation nav-bottom">
                        <div class="alignright"><?php previous_comments_link(' <span class="glyphicon glyphicon-forward"></span> ') ?></div>
                        <div class="alignright"><?php next_comments_link(' <span class="glyphicon glyphicon-backward"></span> ') ?></div>
                </div>
                <div class="clearfix"></div>
                <?php endif; // check for comment navigation ?>

         <?php else : // this is displayed if there are no comments so far ?>

            <div class="alert alert-info text-center">
                <span class="glyphicon glyphicon-info-sign"></span>
                <?php 
                    if ( comments_open() ) {
                        _e('There are no messages yet. Be the first to leave a message.','properweb');
                    }
                    else {
                        _e('Comments are closed.');
                    }
                ?>
            </div>
        </div><!-- #comments -->
        <?php endif; endif; ?>
    </div><!-- #gbook -->
<?php else : ?>
    <div class="alert alert-info text-center">
        <span class="glyphicon glyphicon-comment"></span>
        <?php _e('Comments are not enabled.','properweb'); ?>
    </div>
<?php endif; ?>
<?php if ( !is_user_logged_in() ) : ?></div><?php endif; ?>