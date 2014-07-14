<?php
/*
    Plugin Name: Post Type (Description)
    Plugin URI: https://github.com/VitalDevTeam/custom-post-type-boilerplate
    Description: A custom post type for _____
    Version: 1.0
    Author: Vital Dev Team
    Author URI: http://vtldesign.com
    License: GPL2
*/

/*  ==========================================================================
     INIT
    ==========================================================================  */

    function widget_init() {
        $labels = array(
            'name'               => 'Widgets', 'post type general name',
            'singular_name'      => 'Widget', 'post type singular name',
            'menu_name'          => 'Widgets', 'admin menu',
            'name_admin_bar'     => 'Widget', 'add new on admin bar',
            'add_new'            => 'Add New', 'Widget',
            'add_new_item'       => 'Add New Widget',
            'new_item'           => 'New Widget',
            'edit_item'          => 'Edit Widget',
            'view_item'          => 'View Widget',
            'all_items'          => 'All Widgets',
            'search_items'       => 'Search Widgets',
            'parent_item_colon'  => 'Parent Widgets:',
            'not_found'          => 'No Widget found.',
            'not_found_in_trash' => 'No Widget found in Trash.'
        );
        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'menu_icon'          => 'dashicons-star-filled', // Dashicons CSS class name - http://melchoyce.github.io/dashicons/
            'menu_position'      => 20,
            'show_in_menu'       => true,
            'query_var'          => true,
            // 'rewrite'            => array( 'slug' => 'widget' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array( 'title', 'editor' )
        );
        register_post_type( 'widget', $args );
    }
    add_action( 'init', 'widget_init' );


    /*  ==========================================================================
         UPDATE MESSAGES
        ==========================================================================  */

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
        if ( $post_type_object->publicly_queryable ) {
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
    add_filter( 'post_updated_messages', 'widget_updated_messages' );


/*  ==========================================================================
     TAXONOMIES
    ==========================================================================  */

    function widget_taxonomies() {
        $labels = array(
            'name'              => 'Types', 'taxonomy general name',
            'singular_name'     => 'Type', 'taxonomy singular name',
            'search_items'      => 'Search Types',
            'all_items'         => 'All Types',
            'parent_item'       => 'Parent Type',
            'parent_item_colon' => 'Parent Type:',
            'edit_item'         => 'Edit Type',
            'update_item'       => 'Update Type',
            'add_new_item'      => 'Add New Type',
            'new_item_name'     => 'New Type Name',
            'menu_name'         => 'Type',
        );
        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            // 'rewrite'           => array( 'slug' => 'new-slug' ),
        );
        register_taxonomy( 'type', array( 'widget' ), $args );
    }
    add_action( 'init', 'widget_taxonomies', 0 );