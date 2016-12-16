<?php
/**
 * Job post type
 */

// Define our post type names
$job_names = [
    'name'     => 'vtl_job',
    'singular' => 'Job',
    'plural'   => 'Jobs',
    'slug'     => 'careers'
];

// Define our options
$job_options = [
    'supports'            => array('title'),
    'hierarchical'        => false,
    'menu_position'       => 20,
    'show_in_nav_menus'   => true,
    'has_archive'         => false,
    'exclude_from_search' => true,
    'rewrite'             => array('with_front' => false),
    'labels'              => array('menu_name' => 'Careers')
];

// Create post type
$job = new PostType($job_names, $job_options);

// Set the menu icon
$job->icon('dashicons-groups');

// Set the title placeholder text
$job->placeholder('Enter job name here');

// Hide admin columns
$job->columns()->hide(['wpseo-score', 'wpseo-score-readability']);

// Define taxonomy names
$job_type_names = [
    'name'     => 'job_category',
    'singular' => 'Job Category',
    'plural'   => 'Job Categories',
    'slug'     => 'job-category'
];

// Define taxonomy options
$job_type_options = [
    'heirarchical'      => true,
    'show_in_nav_menus' => true
];

// Register taxonomy
$job->taxonomy($job_type_names, $job_type_options);
