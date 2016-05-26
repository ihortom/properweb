<?php
/**
 * Registering meta boxes. "Meta box" plug-in has to be activated (https://wordpress.org/plugins/meta-box/).
 *
 * You also should read the changelog to know what has been changed before updating.
 *
 * For more information, please visit:
 * @link http://metabox.io/docs/registering-meta-boxes/
 */
wp_insert_term(
  'Promo', // the term 
  'category', // the taxonomy
  array(
    'description'=> 'Current and upcoming promotions',
    'slug' => 'promo'
  )
);

add_filter( 'rwmb_meta_boxes', 'pweb_register_meta_boxes' );

function pweb_register_meta_boxes( $meta_boxes )
{
    /**
     * prefix of meta keys (optional)
     * Use underscore (_) at the beginning to make keys hidden
     * Alt.: You also can make prefix empty to disable it
     */
    // Better has an underscore as last sign
    $prefix = 'pweb_';
    
    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'category',
                'field' => 'slug',
                'terms' => 'promo'
            )
        )
    );
    $the_query = new WP_Query( $args );
    $promo_posts = array();
    while ( $the_query->have_posts() ) : $the_query->the_post();
        $post_id = get_the_ID();
        $post_title = get_the_title();
        $promo_posts += array($post_id => $post_title);
    endwhile;
    
    // Meta box for promo flash
    $meta_boxes[] = array(
        // Meta box id, UNIQUE per meta box. Optional since 4.1.5
        'id'         => 'flash',

        // Meta box title - Will appear at the drag and drop handle bar. Required.
        'title'      => __( 'Promo', 'properweb' ),

        // Post types, accept custom post types as well - DEFAULT is 'post'. Can be array (multiple post types) or string (1 post type). Optional.
        'post_types' => array( 'page' ),

        // Where the meta box appear: normal (default), advanced, side. Optional.
        'context'    => 'normal',

        // Order of meta box: high (default), low. Optional.
        'priority'   => 'high',

        // Auto save: true, false (default). Optional.
        'autosave'   => false,

        // List of meta fields
        'fields'     => array(
            // SELECT
            array(
                'name' => __( 'Promo flash', 'properweb' ),
                'desc' => __( 'Flash promo you would like to appear on the page.', 'properweb' ),
                'id'   => "{$prefix}flash",
                'type' => 'select',
                // Array of 'value' => 'Label' pairs for select box
                'options'     => $promo_posts,
                // Default selected value
                'std'         => 0,
                // Placeholder
                'placeholder' => __( '--Select promo--', 'properweb' )
            )
        )
    );               
    return $meta_boxes;
}
?>