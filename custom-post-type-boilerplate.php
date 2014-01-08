<?php
/*
    Plugin Name: Custom Post Type (Description)
    Plugin URI: http://adamwalter.com
    Description: A custom post type for _____
    Version: 1.0
    Author: Adam Walter
    Author URI: http://adamwalter.com
    License: GPL2
*/


/*  --------------------------------------------------
     REGISTER
    -------------------------------------------------- */

function widget_register() {
    register_post_type( 'widget', array(
        'hierarchical'      => false,
        'public'            => true,
        'show_in_nav_menus' => true,
        'show_ui'           => true,
        'menu_icon'         => 'dashicons-star-filled', // Dashicons CSS class name - http://melchoyce.github.io/dashicons/
        'menu_position'     => 10,
        'supports'          => array( 'title', 'editor' ),
        'has_archive'       => true,
        'query_var'         => true,
        'rewrite'           => true,
        'labels'            => array(
            'name'                => __( 'Widgets', 'YOUR-TEXTDOMAIN' ),
            'singular_name'       => __( 'Widget', 'YOUR-TEXTDOMAIN' ),
            'add_new'             => __( 'Add new Widget', 'YOUR-TEXTDOMAIN' ),
            'all_items'           => __( 'Widgets', 'YOUR-TEXTDOMAIN' ),
            'add_new_item'        => __( 'Add new Widget', 'YOUR-TEXTDOMAIN' ),
            'edit_item'           => __( 'Edit Widget', 'YOUR-TEXTDOMAIN' ),
            'new_item'            => __( 'New Widget', 'YOUR-TEXTDOMAIN' ),
            'view_item'           => __( 'View Widget', 'YOUR-TEXTDOMAIN' ),
            'search_items'        => __( 'Search Widgets', 'YOUR-TEXTDOMAIN' ),
            'not_found'           => __( 'No Widgets found', 'YOUR-TEXTDOMAIN' ),
            'not_found_in_trash'  => __( 'No Widgets found in trash', 'YOUR-TEXTDOMAIN' ),
            'parent_item_colon'   => __( 'Parent Widget', 'YOUR-TEXTDOMAIN' ),
            'menu_name'           => __( 'Widgets', 'YOUR-TEXTDOMAIN' ),
        ),
    ) );
}
add_action( 'init', 'widget_register' );


/*  --------------------------------------------------
     INTERACTION MESSAGES
    -------------------------------------------------- */

function widget_updated_messages( $messages ) {
    global $post;

    $permalink = get_permalink( $post );

    $messages['widget'] = array(
        0 => '', // Unused. Messages start at index 1.
        1 => sprintf( __('Widget updated. <a target="_blank" href="%s">View Widget</a>', 'YOUR-TEXTDOMAIN'), esc_url( $permalink ) ),
        2 => __('Custom field updated.', 'YOUR-TEXTDOMAIN'),
        3 => __('Custom field deleted.', 'YOUR-TEXTDOMAIN'),
        4 => __('Widget updated.', 'YOUR-TEXTDOMAIN'),
        /* translators: %s: date and time of the revision */
        5 => isset($_GET['revision']) ? sprintf( __('Widget restored to revision from %s', 'YOUR-TEXTDOMAIN'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
        6 => sprintf( __('Widget published. <a href="%s">View Widget</a>', 'YOUR-TEXTDOMAIN'), esc_url( $permalink ) ),
        7 => __('Widget saved.', 'YOUR-TEXTDOMAIN'),
        8 => sprintf( __('Widget submitted. <a target="_blank" href="%s">Preview Widget</a>', 'YOUR-TEXTDOMAIN'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
        9 => sprintf( __('Widget scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Widget</a>', 'YOUR-TEXTDOMAIN'),
        // translators: Publish box date format, see http://php.net/date
        date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
        10 => sprintf( __('Widget draft updated. <a target="_blank" href="%s">Preview Widget</a>', 'YOUR-TEXTDOMAIN'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
    );

    return $messages;
}
add_filter( 'post_updated_messages', 'widget_updated_messages' );


/*  --------------------------------------------------
     TAXONOMY
    -------------------------------------------------- */

function types_init() {
    register_taxonomy( 'types', array( 'widget' ), array(
        'hierarchical'      => false,
        'public'            => true,
        'show_in_nav_menus' => true,
        'show_ui'           => true,
        'show_admin_column' => false,
        'query_var'         => true,
        'rewrite'           => true,
        'capabilities'      => array(
            'manage_terms'  => 'edit_posts',
            'edit_terms'    => 'edit_posts',
            'delete_terms'  => 'edit_posts',
            'assign_terms'  => 'edit_posts'
        ),
        'labels'            => array(
            'name'                       => __( 'Types', 'YOUR-TEXTDOMAIN' ),
            'singular_name'              => _x( 'Types', 'taxonomy general name', 'YOUR-TEXTDOMAIN' ),
            'search_items'               => __( 'Search Types', 'YOUR-TEXTDOMAIN' ),
            'popular_items'              => __( 'Popular Types', 'YOUR-TEXTDOMAIN' ),
            'all_items'                  => __( 'All Types', 'YOUR-TEXTDOMAIN' ),
            'parent_item'                => __( 'Parent Types', 'YOUR-TEXTDOMAIN' ),
            'parent_item_colon'          => __( 'Parent Types:', 'YOUR-TEXTDOMAIN' ),
            'edit_item'                  => __( 'Edit Types', 'YOUR-TEXTDOMAIN' ),
            'update_item'                => __( 'Update Types', 'YOUR-TEXTDOMAIN' ),
            'add_new_item'               => __( 'New Types', 'YOUR-TEXTDOMAIN' ),
            'new_item_name'              => __( 'New Types', 'YOUR-TEXTDOMAIN' ),
            'separate_items_with_commas' => __( 'Types separated by comma', 'YOUR-TEXTDOMAIN' ),
            'add_or_remove_items'        => __( 'Add or remove Types', 'YOUR-TEXTDOMAIN' ),
            'choose_from_most_used'      => __( 'Choose from the most used Types', 'YOUR-TEXTDOMAIN' ),
            'menu_name'                  => __( 'Types', 'YOUR-TEXTDOMAIN' ),
        ),
    ) );

}
add_action( 'init', 'types_init' );


/*  --------------------------------------------------
     ADMIN MENU ICON
    -------------------------------------------------- */

function widget_icon() {
    $icon_url = plugins_url( 'foo.png' , __FILE__ );
    ?>
    <style type="text/css" media="screen">
        #menu-posts-widget .wp-menu-image {
            background: url('<?php echo $icon_url ?>') no-repeat 6px -17px !important;
        }
        #menu-posts-widget:hover .wp-menu-image,
        #menu-posts-widget.wp-has-current-submenu .wp-menu-image,
        .menu-icon-widget.current .wp-menu-image {
            background-position: 6px 7px!important;
        }
    </style>
<?php }
add_action( 'admin_head', 'widget_icon' );
