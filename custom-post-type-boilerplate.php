<?php

/*
	Plugin Name: Post Type (Description)
	Plugin URI: https://github.com/VitalDevTeam/custom-post-type-boilerplate
	Description: A custom post type for XXXXXX
	Version: 1.0
	Author: Vital Dev Team
	Author URI: http://vtldesign.com
	License: GPLv2
 */

// Exit if accessed directly
if (! defined('ABSPATH')) exit;

class WP_Custom_Post_Type_Boilerplate {

	private static $instance = null;

	/**
	 * Creates or returns an instance of this class
	 */
	public static function get_instance() {

		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Initialize plugin
	 */
	private function __construct() {

		// Load post type and taxonomies
		add_action( 'init', array( $this, 'vital_widget_init' ), 0 );
		add_action( 'init', array( $this, 'vital_widget_tax_init' ), 0 );

		register_activation_hook( __FILE__, array( $this, 'activation' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deactivation' ) );

	}

    /**
     * Plugin activation
     */
    public function activation() {
		// Load post type and taxonomy
		$this->vital_widget_init();
		$this->vital_widget_tax_init();

		// Flush permalinks
		flush_rewrite_rules();
	}

    /**
     * Plugin deactivation
     */
    public function deactivation() {
		// Flush permalinks
		flush_rewrite_rules();
	}

	/**
	 * Register post type
	 */
	function vital_widget_init() {

		$labels = array(
			'name'                => _x( 'Widgets', 'Post Type General Name', 'vital' ),
			'singular_name'       => _x( 'Widget', 'Post Type Singular Name', 'vital' ),
			'menu_name'           => __( 'Widgets', 'vital' ),
			'name_admin_bar'      => __( 'Widget', 'vital' ),
			'parent_item_colon'   => __( 'Parent Widget:', 'vital' ),
			'all_items'           => __( 'All Widgets', 'vital' ),
			'add_new_item'        => __( 'Add New Widget', 'vital' ),
			'add_new'             => __( 'Add New', 'vital' ),
			'new_item'            => __( 'New Widget', 'vital' ),
			'edit_item'           => __( 'Edit Widget', 'vital' ),
			'update_item'         => __( 'Update Widget', 'vital' ),
			'view_item'           => __( 'View Widget', 'vital' ),
			'search_items'        => __( 'Search Widgets', 'vital' ),
			'not_found'           => __( 'Not found', 'vital' ),
			'not_found_in_trash'  => __( 'Not found in Trash', 'vital' ),
		);
		$args = array(
			'label'               => __( 'vital_widget', 'vital' ),
			'description'         => __( 'Widget', 'vital' ),
			'labels'              => $labels,
			'supports'            => array( 'title', ),
	        'taxonomies'          => array( 'vital_widget_tax' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 20,
			'menu_icon'           => 'dashicons-star-filled',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => false,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
		);

		register_post_type( 'vital_widget', $args );
	}

	/**
	 * Register taxonomy
	 */
	function vital_widget_tax_init() {

		$labels = array(
			'name'                       => _x( 'Widget Types', 'Taxonomy General Name', 'vital' ),
			'singular_name'              => _x( 'Widget Type', 'Taxonomy Singular Name', 'vital' ),
			'menu_name'                  => __( 'Types', 'vital' ),
			'all_items'                  => __( 'All Widget Types', 'vital' ),
			'parent_item'                => __( 'Parent Widget Type', 'vital' ),
			'parent_item_colon'          => __( 'Parent Widget Type:', 'vital' ),
			'new_item_name'              => __( 'New Widget Type Name', 'vital' ),
			'add_new_item'               => __( 'Add New Widget Type', 'vital' ),
			'edit_item'                  => __( 'Edit Widget Type', 'vital' ),
			'update_item'                => __( 'Update Widget Type', 'vital' ),
			'view_item'                  => __( 'View Widget Type', 'vital' ),
			'separate_items_with_commas' => __( 'Separate types with commas', 'vital' ),
			'add_or_remove_items'        => __( 'Add or remove types', 'vital' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'vital' ),
			'popular_items'              => __( 'Popular Widget Types', 'vital' ),
			'search_items'               => __( 'Search Widget Types', 'vital' ),
			'not_found'                  => __( 'Not Found', 'vital' ),
		);

		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => false,
			'show_tagcloud'              => false,
		);

		register_taxonomy( 'vital_widget_tax', array( 'vital_widget' ), $args );
	}

}

WP_Custom_Post_Type_Boilerplate::get_instance();