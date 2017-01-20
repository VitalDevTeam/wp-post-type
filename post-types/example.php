<?php
/**
 * Example post type
 */

 // Define our post type names
$widget_names = [
    'name' => 'vtl_widget',
    'singular' => 'Widget',
    'plural' => 'Widgets',
    'slug' => 'widget'
];

// Define our options
$widget_options = [
    'exclude_from_search' => false,
    'has_archive'         => false,
    'hierarchical'        => false,
    'menu_icon'           => 'dashicons-star-filled',
    'menu_position'       => 20,
    'has_archive'         => true,
    'rewrite'             => array('with_front' => false),
    'show_in_admin_bar'   => true,
    'show_in_menu'        => true,
    'show_in_nav_menus'   => true,
    'show_in_rest'        => false,
    'show_ui'             => true,
    'supports'            => array('title'),
];

// Create post type
$widget = new PostType($widget_names, $widget_options);

// Set the menu icon
$widget->icon('dashicons-star-filled');

// Set the title placeholder text
$widget->placeholder('Enter widget name');

// Hide admin columns
$widget->columns()->hide(['date', 'wpseo-score', 'wpseo-score-readability']);

// Add custom admin columns
$widget->columns()->add([
    'widget_color' => 'Color'
]);

// Populate custom admin columns
$widget->columns()->populate('widget_color', function($column, $post_id) {
    echo get_post_meta($post_id, 'widget_color');
});

// Make custom admin columns sortable
$widget->columns()->sortable([
    'widget_color' => ['widget_color', true]
]);

// Define taxonomy names
$widget_type_names = [
    'name'     => 'widget_type',
    'singular' => 'Widget Type',
    'plural'   => 'Widget Types',
    'slug'     => 'widget-type'
];

// Define taxonomy options
$widget_type_options = [
    'heirarchical'      => true,
    'labels'            => array('menu_name' => 'Types'),
    'show_admin_column' => true,
    'show_in_nav_menus' => false,
    'show_in_rest'      => true
];

// Register taxonomy
$widget->taxonomy($widget_type_names, $widget_type_options);

