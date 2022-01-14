<?php
namespace Vital;

abstract class Custom_Post_Type {
	static $_cpt_instance = null;

	/** @var string */
	static $name = 'widget';
	/** @var string */
	static $placeholder_text = false;
	/** @var array */
	static $labels = [];
	/** @var array */
	static $options = [];

	/** @var array */
	static $field_group = [];

	/** @var string */
	static $options_capability = 'edit_posts';
	/** @var array */
	static $options_field_group = false;

	/** @var array */
	static $taxonomies = [];

	/** @var array */
	protected static $base_admin_columns = [
		'cb'    => '<input type="checkbox" />',
		'title' => 'Title',
	];

	/** @var */
	static $admin_columns = [];

	protected static function get_field_group() {
		return array_merge(static::$field_group, [
			'location' => [
				[
					[
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => static::$name,
					],
				],
			],
		]);
	}

	/**
	 * populates the placeholder text
	 * if the placeholder_text property is not set
	 * the text is built using the name of the posttype
	 *
	 * @param string $title
	 * @param WP_Post $post
	 * @return string
	 */
	static function get_placeholder_text($title, $post) {
		if (!$ret = static::$placeholder_text) {
			$ret = sprintf('Enter %s name', static::$name);
		}

		return $ret;
	}

	static function initialize() {
		$class = get_called_class();

		$cpt = new \CPT(array_merge(static::$labels, [
			'post_type_name' => static::$name,
		]), static::$options);

		/**
		 * Setting a few default properties for taxonomies.
		 *
		 * show_in_rest: true so the taxonomy appears in the block editor
		 * hierarchical: true to get the "checkbox" term input instead of tags
		 */
		$base_tax_opts = [
			'show_in_rest' => true,
			'hierarchical' => true,
		];

		foreach (static::$taxonomies as $tax=>$tax_opts) {
			$cpt->register_taxonomy($tax, array_merge($base_tax_opts, $tax_opts));
		}

		$cpt->columns(array_merge(static::$base_admin_columns, static::$admin_columns));

		foreach (static::$admin_columns as $col=>$col_title) {
			$callback = sprintf('admin_column_%s', $col);
			if (method_exists($class, $callback)) {
				$cpt->populate_column($col, [$class, $callback]);
			}
		}

		static::$_cpt_instance = $cpt;
		add_action('acf/init', [$class, 'add_field_group']);

		if (static::$options_field_group) {
			add_action('acf/init', [$class, 'add_options_page']);
		}

		add_filter('enter_title_here', function($title, $post) use ($class) {
			if ($post->post_type === static::$name) {
				$title = $class::get_placeholder_text($title, $post);
			}

			return $title;
		}, 10, 2);
	}

	static function add_field_group() {
		acf_add_local_field_group(static::get_field_group());
	}

	static function add_options_page() {
		$type = 'Post';
		if (isset(static::$labels['singular'])) {
			$type = static::$labels['singular'];
		}

		$options_page_title = sprintf('%s Options', $type);
		$options_post_id = sprintf('%s-options', static::$name);
		$options_parent_slug = sprintf('edit.php?post_type=%s', static::$name);

		SkeletorThemeOptions::add_skeletor_options_page(
			$options_page_title,
			static::$options_field_group,
			$options_post_id,
			$options_parent_slug,
			self::$options_capability
		);
	}
}
