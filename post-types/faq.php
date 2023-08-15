<?php
namespace Projectname\Posttypes;

class FAQ extends \Vital\Custom_Post_Type {
	/** @var string */
	static $name = 'faq';

	/** @var string */
	static $placeholder_text = 'Enter question here';

	/** @var array */
	static $labels = [
		'menu_name' => 'FAQs',
		'singular'  => 'Question',
		'plural'    => 'Questions',
		'all_items' => 'All Questions',
	];


	/** @var array */
	static $options = [
		'has_archive'       => 'faqs',
		'public'            => false,
		'show_ui'           => true,
		'show_in_rest'      => false,
		'show_in_nav_menus' => false,
		'hierarchical'      => false,
		'menu_position'     => 20,
		'menu_icon'         => 'dashicons-editor-help',
		'rewrite'           => [
			'slug'       => 'faq',
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
		'faq_category' => [
			'heirarchical'      => true,
			'show_in_nav_menus' => false,
			'labels'            => [
				'name'              => 'FAQ Categories',
				'singular'          => 'FAQ Category',
				'plural'            => 'FAQ Categories',
				'menu_name'         => 'FAQ Categories',
				'add_new_item'      => 'Add FAQ Category',
				'not_found'         => 'No FAQ Categories Found',
				'parent_item'       => 'Parent FAQ Categories',
				'parent_item_colon' => 'Parent FAQ Categories:',
			],
			'rewrite'           => [
				'slug'       => 'faq-category',
				'with_front' => true,
			],
		],
	];

	/** @var array */
	static $admin_columns = [
		'faq_category' => 'Categories',
	];

	/** @var array */
	static $admin_columns_to_remove = ['wpseo-score', 'wpseo-score-readability'];


	static function initialize() {
		parent::initialize();

	}
}

add_action('after_setup_theme', ['\\USD\\Posttypes\\FAQ', 'initialize']);
