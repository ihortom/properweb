<?php
/* 
 * Paginated gallery
 * 
 * @package ProperWeb
 * @subpackage ProperFramework-BS
 * @since ProperFramework-BS 1.1
 * 
 */

remove_shortcode('gallery', 'gallery_shortcode');

add_shortcode('gallery', 'pweb_gallery_shortcode');

function pweb_gallery_shortcode( $attr ) {
    
    $post = get_post();

    static $instance = 0;
    $instance++;

    if ( ! empty( $attr['ids'] ) ) {
            // 'ids' is explicitly ordered, unless you specify otherwise.
            if ( empty( $attr['orderby'] ) ) {
                    $attr['orderby'] = 'post__in';
            }
            $attr['include'] = $attr['ids'];
    }

    $output = apply_filters( 'post_gallery', '', $attr, $instance );
    if ( $output != '' ) {
            return $output;
    }

    $html5 = current_theme_supports( 'html5', 'gallery' );
    $atts = shortcode_atts( array(
            'order'      => 'ASC',
            'orderby'    => 'menu_order ID',
            'id'         => $post ? $post->ID : 0,
            'itemtag'    => $html5 ? 'figure'     : 'dl',
            'icontag'    => $html5 ? 'div'        : 'dt',
            'captiontag' => $html5 ? 'figcaption' : 'dd',
            'columns'    => 3,
            'rows'       => 5,  //introduced custom attr
            'size'       => 'thumbnail',
            'include'    => '',
            'exclude'    => '',
            'link'       => ''
    ), $attr, 'gallery');

    $id = intval( $atts['id'] );

    if ( ! empty( $atts['include'] ) ) {
            $_attachments = get_posts( array( 'include' => $atts['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );

            $attachments = array();
            foreach ( $_attachments as $key => $val ) {
                    $attachments[$val->ID] = $_attachments[$key];
            }
    } elseif ( ! empty( $atts['exclude'] ) ) {
            $attachments = get_children( array( 'post_parent' => $id, 'exclude' => $atts['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
    } else {
            $attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
    }

    if ( empty( $attachments ) ) {
            return '';
    }

    if ( is_feed() ) {
            $output = "\n";
            foreach ( $attachments as $att_id => $attachment ) {
                    $output .= wp_get_attachment_link( $att_id, $atts['size'], true ) . "\n";
            }
            return $output;
    }

    $itemtag = tag_escape( $atts['itemtag'] );
    $captiontag = tag_escape( $atts['captiontag'] );
    $icontag = tag_escape( $atts['icontag'] );
    $valid_tags = wp_kses_allowed_html( 'post' );
    if ( ! isset( $valid_tags[ $itemtag ] ) ) {
            $itemtag = 'dl';
    }
    if ( ! isset( $valid_tags[ $captiontag ] ) ) {
            $captiontag = 'dd';
    }
    if ( ! isset( $valid_tags[ $icontag ] ) ) {
            $icontag = 'dt';
    }

    $columns = intval( $atts['columns'] );
    $rows = intval( $atts['rows'] );
    $selector = "gallery-{$instance}";

    $gallery_style = '';

    if ( apply_filters( 'use_default_gallery_style', ! $html5 ) ) {
            $gallery_style = "
            <style type='text/css'>
                    #{$selector} {
                            margin: auto;
                    }
                    #{$selector} .gallery-item {
                            float: none;
                            margin: 0;
                            text-align: center;
                            width: auto;
                    }
                    #{$selector} img {
                            border: 2px solid #cfcfcf;
                    }
                    #{$selector} .gallery-caption {
                            margin-left: 0;
                    }
                    /* see gallery_shortcode() in wp-includes/media.php */
            </style>\n\t\t";
    }

    $size_class = sanitize_html_class( $atts['size'] );
    
    //gallery images per page and pages calculations
    $total_imgs = count($attachments);
    $imgs_per_page = $columns * $rows;
    $total_pages = round($total_imgs/$imgs_per_page);
    
    //add gallery-specific attributes
    $gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}' gallery-pages='{$total_pages}' imgs-per-page='{$imgs_per_page}'>";

    $output = apply_filters( 'gallery_style', $gallery_style . $gallery_div );

    $i = 0;
    foreach ( $attachments as $id => $attachment ) {
        $i++;
        $attr = ( trim( $attachment->post_excerpt ) ) ? array( 'aria-describedby' => "$selector-$id" ) : '';
        $attr['class'] = 'thumbnail';   //add bootstrap class
        
        if ( ! empty( $atts['link'] ) && 'file' === $atts['link'] ) {
                $image_output = wp_get_attachment_link( $id, $atts['size'], false, false, false, $attr );
        } elseif ( ! empty( $atts['link'] ) && 'none' === $atts['link'] ) {
                $image_output = wp_get_attachment_image( $id, $atts['size'], false, $attr );
        } else {
                $image_output = wp_get_attachment_link( $id, $atts['size'], true, false, false, $attr );
        }
        $image_meta  = wp_get_attachment_metadata( $id );

        $orientation = '';
        if ( isset( $image_meta['height'], $image_meta['width'] ) ) {
                $orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';
        }
        $output .= "<{$itemtag} class='gallery-item'";
        if ($i > $imgs_per_page) {
            $output .= " style='display: none;'>";
        }
        else {
            $output .= ">";
        }
        $output .= "
                <{$icontag} class='gallery-icon {$orientation}'>
                        $image_output
                </{$icontag}>";
        if ( $captiontag && trim($attachment->post_excerpt) ) {
                $output .= "
                        <{$captiontag} class='wp-caption-text gallery-caption' id='$selector-$id'>
                        " . wptexturize($attachment->post_excerpt) . "
                        </{$captiontag}>";
        }
        $output .= "</{$itemtag}>";
    }
    
    if ($total_imgs > $imgs_per_page) {
        $pagination = '
            <div class="gallery-nav">
                <!--<h2 class="sr-only">Gallery navigation</h2>-->
                <ul class="pagination">'.(($total_pages > 2)?'
                    <li class="gallery-fast-backward" class="disabled"><a href="#"><span class="glyphicon glyphicon-fast-backward"></span></a></li>':'').
                    '<li class="gallery-backward" class="disabled"><a href="#"><span class="glyphicon glyphicon-backward"></span></a></li>
                    <li class="gallery-stats text-right"><span class="gallery_page" class="stats">1</span></li>
                    <li class="gallery-stats"><span class="stats" style="padding-right:0;padding-left:0;">/</span></li>
                    <li class="gallery-stats text-left"><span class="gallery_pages" class="stats">'.$total_pages.'</span></li>
                    <li class="gallery-forward"><a href="#"><span class="glyphicon glyphicon-forward"></span></a></li>'.(($total_pages > 2)?
                    '<li class="gallery-fast-forward"><a href="#"><span class="glyphicon glyphicon-fast-forward"></span></a></li>':'').
                '</ul>
            </div>';
        $output .= $pagination;
    }
    
    $output .= "
            </div>\n";

    return $output;
}

//get summary of all the galleries
add_shortcode('galleries', 'pweb_galleries_shortcode');

//usage [galleries]
function pweb_galleries_shortcode() {
    $args = array(
    	'post_type' => 'post',
        'tax_query' => array(
            array(
                'taxonomy' => 'post_format',
                'field'    => 'slug',
                'terms'    => array( 'post-format-gallery' )
            )
    	),
	'posts_per_page' => -1
    );
    
    
    $html_galleries = '';
    $galleries = new WP_Query( $args );
    
    if($galleries->have_posts()): while($galleries->have_posts()): $galleries->the_post(); ?>
        <?php 
            if ( has_post_thumbnail() ) {
                the_post_thumbnail( 'thumbnail', array( 'class' => 'thumbnail alignleft') );
            }
        ?>
        <h2 class="page-header"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <?php the_excerpt(); ?>
        <p class="text-center"><a class="read-more btn btn-primary btn-md round" href="<?php echo get_permalink( get_the_ID() ) ?>"><?php _e('Go to gallery','properweb'); ?></a></p>

    <?php endwhile; endif;
        
    return $html_galleries;
}