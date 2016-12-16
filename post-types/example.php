<?php
/**
 * Example post type
 */

// Define our post type names
$widget_names = [
    'name'     => 'vtl_widget',
    'singular' => 'Widget',
    'plural'   => 'Widgets',
    'slug'     => 'widget'
];

// Define our options
$widget_options = [
    'supports'            => array('title'),
    'hierarchical'        => false,
    'menu_position'       => 20,
    'show_in_nav_menus'   => true,
    'has_archive'         => false,
    'exclude_from_search' => true,
    'rewrite'             => array('with_front' => false),
    'labels'              => array('menu_name' => 'Widgets')
];

// Create post type
$widgets = new PostType($widget_names, $widget_options);

// Set the menu icon
$widgets->icon('dashicons-star-filled');

// Set the title placeholder text
$widgets->placeholder('Enter widget name here');

// Hide admin columns
$widgets->columns()->hide(['date', 'author', 'wpseo-score', 'wpseo-score-readability']);

// Add a custom admin column
$widgets->columns()->add([
    'custom_meta' => 'Custom Meta'
]);

// Populate the custom column
$widgets->columns()->populate('type', function($column, $post_id) {
    echo get_post_meta($post_id, 'custom_meta');
});

// Set sortable columns
$widgets->columns()->sortable([
    'custom_meta' => ['custom_meta', true]
]);

// Define taxonomy names
$widget_type_names = [
    'name'     => 'widget_type',
    'singular' => 'Type',
    'plural'   => 'Types',
    'slug'     => 'widget-type'
];

// Define taxonomy options
$widget_type_options = [
    'heirarchical'      => true,
    'show_in_nav_menus' => false
];

// Register taxonomy
$widgets->taxonomy($widget_type_names, $widget_type_options);
