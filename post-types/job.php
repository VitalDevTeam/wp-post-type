<?php
/**
 * Job post type
 */

$job_names = [
    'name'     => 'vtl_job',
    'singular' => 'Job',
    'plural'   => 'Jobs',
    'slug'     => 'careers'
];

$job_options = [
    'exclude_from_search' => true,
    'has_archive'         => false,
    'hierarchical'        => false,
    'labels'              => array('menu_name' => 'Careers'),
    'menu_position'       => 20,
    'rewrite'             => array('with_front' => false),
    'show_in_nav_menus'   => true,
    'show_in_rest'        => false,
    'supports'            => array('title')
];

$job = new PostType($job_names, $job_options);

$job->icon('dashicons-groups');
$job->placeholder('Enter job name here');
$job->columns()->hide(['wpseo-score', 'wpseo-score-readability']);

$job_type_names = [
    'name'     => 'job_category',
    'singular' => 'Job Category',
    'plural'   => 'Job Categories',
    'slug'     => 'job-category'
];

$job_type_options = [
    'heirarchical'      => true,
    'show_in_nav_menus' => true
];

$job->taxonomy($job_type_names, $job_type_options);
