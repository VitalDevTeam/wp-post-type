<?php
/**
 * Example
 *
 * DO NOT USE AS-IS! Edit components you need and REMOVE components you don't.
 */

// Define our post type names
$widget_names = [
	'name'                  => 'vtl_widget',
	'menu_name'             => 'Widgets',
	'singular'              => 'Widget',
	'plural'                => 'Widgets',
	'all_items'             => 'All Widgets',
	'slug'                  => 'widget',
	'featured_image'        => 'Widget Diagram',
	'set_featured_image'    => 'Set widget diagram',
	'remove_featured_image' => 'Remove widget diagram',
	'use_featured_image'    => 'Use as widget diagram',
];

// Define our options
$widget_options = [
	'exclude_from_search' => false,
	'hierarchical'        => false,
	'menu_position'       => 20,
	'has_archive'         => true,
	'rewrite'             => ['with_front' => false],
	'show_in_admin_bar'   => true,
	'show_in_menu'        => true,
	'show_in_nav_menus'   => true,
	'show_in_rest'        => false,
	'show_ui'             => true,
	'supports'            => ['title', 'page-attributes'],
];

// Create post type
$widget = new PostType($widget_names, $widget_options);

// Set the menu icon
$widget->icon('dashicons-star-filled');

// Set the title placeholder text
$widget->placeholder('Enter widget name');

// Hide admin columns
$widget->columns()->hide(['wpseo-score', 'wpseo-score-readability']);

// Set all columns
$widget->columns()->set([
	'cb'          => '<input type="checkbox" />',
	'feat_img'    => 'Thumb',
	'title'       => __('Title'),
	'widget_type' => __('Group'),
]);

// Add custom admin columns to default array
$widget->columns()->add([
	'widget_color' => 'Color',
]);

// Populate custom admin columns
$widget->columns()->populate('widget_color', function($column, $post_id) {
	echo get_post_meta($post_id, 'widget_color');
});

// Add CSS to style columns
add_action('admin_head', function() {
	$screen = get_current_screen();
	if ($screen && ($screen->base === 'edit') && ($screen->id === 'edit-vtl_widget')) {
		echo '<style>
		th[id=feat_img] {
			width: 42px;
		}
		</style>';
	}
});

// Make custom admin columns sortable
$widget->columns()->sortable([
	'widget_color' => ['widget_color', true],
]);

// Define taxonomy names
$widget_type_names = [
	'name'     => 'widget_type',
	'singular' => 'Widget Type',
	'plural'   => 'Widget Types',
	'slug'     => 'widget-type',
];

// Define taxonomy options
$widget_type_options = [
	'heirarchical'      => true,
	'labels'            => ['menu_name' => 'Types'],
	'show_admin_column' => true,
	'show_in_nav_menus' => false,
	'show_in_rest'      => true,
];

// Register taxonomy
$widget->taxonomy($widget_type_names, $widget_type_options);
