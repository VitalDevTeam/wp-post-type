<?php
/**
 * FAQ post type
 */

// Define our post type names
$faq_names = [
    'name'     => 'vtl_faq',
    'singular' => 'Question',
    'plural'   => 'Questions',
    'slug'     => 'faq'
];

// Define our options
$faq_options = [
    'supports'            => array('title'),
    'hierarchical'        => false,
    'menu_position'       => 21,
    'show_in_nav_menus'   => true,
    'has_archive'         => true,
    'exclude_from_search' => true,
    'rewrite'             => array('with_front' => false),
    'labels'              => array('menu_name' => 'FAQs')
];

// Create post type
$faq = new PostType($faq_names, $faq_options);

// Set the menu icon
$faq->icon('dashicons-editor-help');

// Set the title placeholder text
$faq->placeholder('Enter question here');

// Hide admin columns
$faq->columns()->hide(['date', 'wpseo-score', 'wpseo-score-readability']);

// Define taxonomy names
$faq_type_names = [
    'name'     => 'faq_category',
    'singular' => 'FAQ Category',
    'plural'   => 'FAQ Categories',
    'slug'     => 'faq-category'
];

// Define taxonomy options
$faq_type_options = [
    'heirarchical'      => true,
    'show_in_nav_menus' => true
];

// Register taxonomy
$faq->taxonomy($faq_type_names, $faq_type_options);
