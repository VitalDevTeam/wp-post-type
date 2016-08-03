<?php
/*
    Plugin Name: Post Type (Description)
    Plugin URI: https://github.com/VitalDevTeam/custom-post-type-boilerplate
    Description: A custom post type for {description}
    Version: 2.0
    Author: Vital Dev Team
    Author URI: http://vtldesign.com
    License: GPL2
*/

// Exit if this file is accessed directly
if (! defined('ABSPATH')) exit;

/**
 * Register Post Type
 */
function vtl_widget_init() {

    $labels = array(
        'name'                  => 'Widgets',
        'singular_name'         => 'Widget',
        'menu_name'             => 'Widgets',
        'name_admin_bar'        => 'Widget',
        'parent_item_colon'     => 'Parent Widget:',
        'all_items'             => 'All Widgets',
        'add_new_item'          => 'Add New Widget',
        'add_new'               => 'Add New',
        'new_item'              => 'New Widget',
        'edit_item'             => 'Edit Widget',
        'update_item'           => 'Update Widget',
        'view_item'             => 'View Widget',
        'search_items'          => 'Search Widget',
        'not_found'             => 'Not found',
        'not_found_in_trash'    => 'Not found in Trash',
        'items_list'            => 'Widgets list',
        'items_list_navigation' => 'Widgets list navigation',
        'filter_items_list'     => 'Filter widgets list',
    );
    $rewrite = array(
        'slug'                  => 'widget',
        'with_front'            => false,
        'pages'                 => true,
        'feeds'                 => true,
    );
    $args = array(
        'label'                 => 'Widget',
        'description'           => 'Widget',
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail'),
        'taxonomies'            => array('widget_type'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 20,
        'menu_icon'             => 'dashicons-star-filled',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'rewrite'               => $rewrite,
        'capability_type'       => 'post',
    );
    register_post_type('widget', $args);

}
add_action('init', 'vtl_widget_init', 0);


/**
 * Register Taxonomy
 */
function vtl_widget_type_init() {

    $labels = array(
        'name'                       => 'Types',
        'singular_name'              => 'Type',
        'menu_name'                  => 'Types',
        'all_items'                  => 'All Types',
        'parent_item'                => 'Parent Type',
        'parent_item_colon'          => 'Parent Type:',
        'new_item_name'              => 'New Type Name',
        'add_new_item'               => 'Add New Type',
        'edit_item'                  => 'Edit Type',
        'update_item'                => 'Update Type',
        'view_item'                  => 'View Type',
        'separate_items_with_commas' => 'Separate types with commas',
        'add_or_remove_items'        => 'Add or remove types',
        'choose_from_most_used'      => 'Choose from the most used',
        'popular_items'              => 'Popular Types',
        'search_items'               => 'Search Types',
        'not_found'                  => 'Not Found',
        'items_list'                 => 'Types list',
        'items_list_navigation'      => 'Types list navigation',
    );
    $rewrite = array(
        'slug'                       => 'widget-type',
        'with_front'                 => false,
        'hierarchical'               => false,
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'rewrite'                    => $rewrite,
    );
    register_taxonomy('widget_type', array('widget'), $args);

}
add_action('init', 'vtl_widget_type_init', 0);


/**
 * Post Type Update Messages
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
add_filter('post_updated_messages', 'widget_updated_messages');


/**
 * Customize title placeholder text
 * Un-comment add_filter to enable
 */
function vtl_widget_default_title($title) {
     $screen = get_current_screen();
     if  ('widget' === $screen->post_type) {
          $title = 'Enter widget name here';
     }
     return $title;
}
// add_filter('enter_title_here', 'vtl_widget_default_title');

/**
 * Hide date filter in post list
 * Un-comment add_filter to enable
 */
function vtl_widget_hide_date_dropdown($months) {
    $screen = get_current_screen();
    if  ('widget' === $screen->post_type) {
        return array();
    } else {
        return $months;
    }
}
// add_filter('months_dropdown_results', 'vtl_widget_hide_date_dropdown');

/**
 * Change default sort order in admin
 */
function vtl_widget_admin_sort_order($wp_query) {
    if (is_admin() && function_exists('get_current_screen')) {
        $screen = get_current_screen();
        if ($screen && 'edit-widget' === $screen->id) {
            $wp_query->set('orderby', 'title');
            $wp_query->set('order', 'ASC');
        }
    }
}
// add_filter('pre_get_posts', 'vtl_widget_admin_sort_order');

/**
* Tax CTP Filter Class
* Simple class to add custom taxonomy dropdown to a custom post type admin edit list
* @author Ohad Raz <admin@bainternet.info>
* @version 0.1
*/
if (!class_exists('Tax_CTP_Filter')) {
    class Tax_CTP_Filter
    {
        /**
         * __construct
         * @author Ohad Raz <admin@bainternet.info>
         * @since 0.1
         * @param array $cpt [description]
         */
        function __construct($cpt = array()) {
            $this->cpt = $cpt;
            // Adding a Taxonomy Filter to Admin List for a Custom Post Type
            add_action( 'restrict_manage_posts', array($this,'my_restrict_manage_posts' ));
        }

        /**
         * my_restrict_manage_posts  add the slelect dropdown per taxonomy
         * @author Ohad Raz <admin@bainternet.info>
         * @since 0.1
         * @return void
         */
        public function my_restrict_manage_posts() {
            // only display these taxonomy filters on desired custom post_type listings
            global $typenow;
            $types = array_keys($this->cpt);
            if (in_array($typenow, $types)) {
                // create an array of taxonomy slugs you want to filter by - if you want to retrieve all taxonomies, could use get_taxonomies() to build the list
                $filters = $this->cpt[$typenow];
                foreach ($filters as $tax_slug) {
                    // retrieve the taxonomy object
                    $tax_obj = get_taxonomy($tax_slug);
                    $tax_name = $tax_obj->labels->name;

                    // output html for taxonomy dropdown filter
                    echo "<select name='".strtolower($tax_slug)."' id='".strtolower($tax_slug)."' class='postform'>";
                    echo "<option value=''>All $tax_name</option>";
                    $this->generate_taxonomy_options($tax_slug,0,0,(isset($_GET[strtolower($tax_slug)])? $_GET[strtolower($tax_slug)] : null));
                    echo "</select>";
                }
            }
        }

        /**
         * generate_taxonomy_options generate dropdown
         * @author Ohad Raz <admin@bainternet.info>
         * @since 0.1
         * @param  string  $tax_slug
         * @param  string  $parent
         * @param  integer $level
         * @param  string  $selected
         * @return void
         */
        public function generate_taxonomy_options($tax_slug, $parent = '', $level = 0,$selected = null) {
            $args = array('show_empty' => 1);
            if(!is_null($parent)) {
                $args = array('parent' => $parent);
            }
            $terms = get_terms($tax_slug,$args);
            $tab='';
            for($i=0;$i<$level;$i++){
                $tab.='--';
            }

            foreach ($terms as $term) {
                // output each select option line, check against the last $_GET to show the current option selected
                echo '<option value='. $term->slug, $selected == $term->slug ? ' selected="selected"' : '','>' .$tab. $term->name .' (' . $term->count .')</option>';
                $this->generate_taxonomy_options($tax_slug, $term->term_id, $level+1,$selected);
            }

        }
    }
}
// new Tax_CTP_Filter(array('widget' => array('widget_type')));
