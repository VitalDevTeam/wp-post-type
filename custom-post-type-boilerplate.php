<?php
/*
    Plugin Name: Post Type (Description)
    Plugin URI: https://github.com/VitalDevTeam/custom-post-type-boilerplate
    Description: A custom post type for _____
    Version: 1.1
    Author: Vital Dev Team
    Author URI: http://vtldesign.com
    License: GPL2
*/

// Exit if this file is accessed directly
if (! defined('ABSPATH')) exit;

/**
 * Register Post Type
 * @return null
 */
function widget_init() {

    $labels = array(
        'name'                => _x( 'Widgets', 'Post Type General Name', 'vital' ),
        'singular_name'       => _x( 'Widget', 'Post Type Singular Name', 'vital' ),
        'menu_name'           => __( 'Widget', 'vital' ),
        'name_admin_bar'      => __( 'Widget', 'vital' ),
        'parent_item_colon'   => __( 'Parent Widget:', 'vital' ),
        'all_items'           => __( 'All Widgets', 'vital' ),
        'add_new_item'        => __( 'Add New Widget', 'vital' ),
        'add_new'             => __( 'Add New', 'vital' ),
        'new_item'            => __( 'New Widget', 'vital' ),
        'edit_item'           => __( 'Edit Widget', 'vital' ),
        'update_item'         => __( 'Update Widget', 'vital' ),
        'view_item'           => __( 'View Widget', 'vital' ),
        'search_items'        => __( 'Search Widgets', 'vital' ),
        'not_found'           => __( 'Not found', 'vital' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'vital' ),
    );
    $args = array(
        'label'               => __( 'widget', 'vital' ),
        'description'         => __( 'Widgets', 'vital' ),
        'labels'              => $labels,
        'supports'            => array( 'title' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 20,
        'menu_icon'           => 'dashicons-star-filled', // https://developer.wordpress.org/resource/dashicons
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
    );

    register_post_type( 'widget', $args );

}

/**
 * Post Type Update Messages
 * @param  object $messages Default messages
 * @return object           Customized messages
 */
function widget_updated_messages( $messages ) {

    $post             = get_post();
    $post_type        = get_post_type( $post );
    $post_type_object = get_post_type_object( $post_type );

    $messages['widget'] = array(
        0  => '',
        1  => 'Widget updated.',
        2  => 'Custom field updated.',
        3  => 'Custom field deleted.',
        4  => 'Widget updated.',
        5  => isset( $_GET['revision'] ) ? sprintf( 'Widget restored to revision from %s', wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
        6  => 'Widget published.',
        7  => 'Widget saved.',
        8  => 'Widget submitted.',
        9  => sprintf('Widget scheduled for: <strong>%1$s</strong>.', date_i18n( 'M j, Y @ G:i', strtotime( $post->post_date ) )),
        10 => 'Widget draft updated.'
    );

    if ( $post_type_object->publicly_queryable & $post->post_type == 'widget' ) {
        $permalink = get_permalink( $post->ID );
        $view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), 'View Widget' );
        $messages[ $post_type ][1] .= $view_link;
        $messages[ $post_type ][6] .= $view_link;
        $messages[ $post_type ][9] .= $view_link;
        $preview_permalink = add_query_arg( 'preview', 'true', $permalink );
        $preview_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), 'Preview Widget' );
        $messages[ $post_type ][8]  .= $preview_link;
        $messages[ $post_type ][10] .= $preview_link;
    }

    return $messages;

}


/**
 * Register Taxonomy
 * @return null
 */
function widget_type_taxonomy() {

    $labels = array(
        'name'                       => _x( 'Types', 'Taxonomy General Name', 'vital' ),
        'singular_name'              => _x( 'Type', 'Taxonomy Singular Name', 'vital' ),
        'menu_name'                  => __( 'Types', 'vital' ),
        'all_items'                  => __( 'All Types', 'vital' ),
        'parent_item'                => __( 'Parent Type', 'vital' ),
        'parent_item_colon'          => __( 'Parent Type:', 'vital' ),
        'new_item_name'              => __( 'New Type Name', 'vital' ),
        'add_new_item'               => __( 'Add New Type', 'vital' ),
        'edit_item'                  => __( 'Edit Type', 'vital' ),
        'update_item'                => __( 'Update Type', 'vital' ),
        'view_item'                  => __( 'View Type', 'vital' ),
        'separate_items_with_commas' => __( 'Separate types with commas', 'vital' ),
        'add_or_remove_items'        => __( 'Add or remove types', 'vital' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'vital' ),
        'popular_items'              => __( 'Popular Types', 'vital' ),
        'search_items'               => __( 'Search Types', 'vital' ),
        'not_found'                  => __( 'Not Found', 'vital' ),
    );

    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
    );

    register_taxonomy( 'type', array( 'widget' ), $args );

}

add_filter( 'post_updated_messages', 'widget_updated_messages' );
add_action( 'init', 'widget_init' );
add_action( 'init', 'widget_type_taxonomy', 0 );