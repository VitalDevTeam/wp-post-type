<?php
/**
 * NOTE:
 * this is just an example file
 */
namespace Vital\Posttypes;

class Example extends \Vital\Custom_Post_Type {
	/** @var string */
	static $name = 'vtl_widget';

	/** @var string */
	static $placeholder_text = 'Enter name here';

	/** @var array */
	static $labels = [
		'singular' => 'Widget',
		'plural'   => 'Widgets',
	];


	/** @var array */
	static $options = [
		'has_archive'       => 'widgets',
		'public'            => false,
		'show_ui'           => true,
		'show_in_rest'      => false,
		'show_in_nav_menus' => false,
		'hierarchical'      => false,
		'menu_position'     => 20,
		'menu_icon'         => 'dashicons-editor-help',
		'rewrite'           => [
			'slug'       => 'widget',
			'with_front' => false,
		],
		'supports'          => [
			'title',
			'custom-fields',
			'editor',
		],
	];

	/** @var array */
	static $taxonomies = [
		'widget_category' => [
			'heirarchical'      => true,
			'show_in_nav_menus' => false,
			'labels'            => [
				'name'              => 'Widget Categories',
				'singular'          => 'Widget Category',
				'plural'            => 'Widget Categories',
				'menu_name'         => 'Widget Categories',
				'add_new_item'      => 'Add Widget Category',
				'not_found'         => 'No Widget Categories Found',
				'parent_item'       => 'Parent Widget Categories',
				'parent_item_colon' => 'Parent Widget Categories:',
			],
			'rewrite'           => [
				'slug'       => 'widget-category',
				'with_front' => true,
			],
		],
	];

	/** @var array */
	static $admin_columns = [
		'widget_category' => 'Widget Categories',
		'is_locked'       => 'Is Locked?'
	];
	public static function admin_column_is_locked($column, $post) {
		$value = get_post_meta($post->ID, 'is_locked', true);
		echo $value === 1 ? 'Yes' : 'No';
	}

	/** @var array */
	static $admin_columns_to_remove = ['wpseo-score', 'wpseo-score-readability'];


	static function initialize() {
		parent::initialize();

	}
}

add_action('after_setup_theme', ['\\Vital\\Posttypes\\Example', 'initialize']);
