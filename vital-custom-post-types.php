<?php
/*
	Plugin Name: Custom Post Types
	Description: Adds programmatic tools for registering custom post types for this site.
	Version: 3.0.2
	Author: Vital
	Author URI: https://vitaldesign.com
	License: GPLv2

	Uses Custom Post Type PHP class for creating post types by Joe Grainger
	https://github.com/jjgrainger/wp-custom-post-type-class
*/

defined('ABSPATH') or die('Do not access this file directly.');

require 'plugin-update-checker/plugin-update-checker.php';

$update_checker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/VitalDevTeam/wp-post-type',
	__FILE__,
	'wp-post-type'
);

require plugin_dir_path(__FILE__) . '/inc/class-CPT.php';
require plugin_dir_path(__FILE__) . '/inc/class-Vital-CPT.php';

/**
 * Plugin activation tasks
 */
function vtl_cpt_activate() {
	flush_rewrite_rules();
}

register_activation_hook(__FILE__, 'vtl_cpt_activate');
