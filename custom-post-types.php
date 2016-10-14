<?php
/*
    Plugin Name: Custom Post Types
    Plugin URI: http://vtldesign.com
    Description: Registers all the custom post types for this site.
    Version: 1.0
    Author: Vital
    Author URI: http://vtldesign.com
    License: GPLv2

    Uses PostTypes PHP class for creating post types by Joe Grainger
    https://github.com/jjgrainger/PostTypes
*/

defined('ABSPATH') or die('Do not access this file directly.');

// Include classes
require plugin_dir_path(__FILE__) . 'inc/class-columns.php';
require plugin_dir_path(__FILE__) . 'inc/class-posttype.php';
require plugin_dir_path(__FILE__) . 'inc/class-taxonomy.php';
require plugin_dir_path(__FILE__) . 'inc/class-taxfilter.php';

// Include all post type PHP files
foreach (glob(plugin_dir_path(__FILE__) . 'post-types/*.php') as $filename) {
    include $filename;
}
