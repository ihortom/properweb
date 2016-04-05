<?php

//remove_filter('comment_text', 'wpautop');

function pweb_wrap_comment_text($content) {
    return '<span class="glyphicon glyphicon-pushpin"></span>'. $content;
}
add_filter('comment_text', 'pweb_wrap_comment_text');

//custom gbook comment function
function pweb_comments ($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment; ?>
    <li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
        <div id="comment-<?php comment_ID(); ?>" class="comment-container">
            <div class="row">
                <div class="comment-avatar text-center small-centered col-xm-3 col-sm-2">
                    <?php echo get_avatar( $comment->comment_author_email, 50 ); ?>
                </div>
                <div class="comment-author col-xs-8 col-sm-10">
                    <span class="author"><?php printf('<cite>%s</cite>', get_comment_author()) ?></span><br>
                    <time datetime="<?php echo get_comment_date("c")?>" class="comment-date">  
                            <?php 
                                printf('%1$s %2$s', get_comment_date(),  get_comment_time()); 
                            ?>
                            &nbsp;&nbsp;&nbsp;
                            <?php
                                edit_comment_link(__('(Edit)','properweb')); 
                            ?>
                    </time>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-10 col-md-offset-2">
                    <div class="comment-text">
                        <?php if ($comment->comment_approved == '0') : ?>
                                 <em><?php _e('Your comment is awaiting approval.','properweb') ?></em>
                        <?php endif; ?>

                        <?php comment_text() ?>

                    </div>
                </div>
            </div>
        </div>
<?php } ?>
