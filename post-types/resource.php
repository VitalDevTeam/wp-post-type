<?php
namespace USD\Posttypes;

class Resource extends \Vital\Custom_Post_Type {
	/** @var string */
	static $name = 'resource';

	/** @var string */
	static $placeholder_text = 'Enter Resource Name';

	/** @var array */
	static $labels = [
		'singular' => 'Resource', // minimum needed
	];

	/** @var array */
	static $options = [
		'has_archive'        => 'resources',
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_rest'       => true,
		'menu_position'      => 20,
		'menu_icon'          => 'dashicons-media-document',
		'capability_type'    => 'resource',
		'supports'           => [
			'title',
			'custom-fields',
			'editor',
			'thumbnail',
			'excerpt',
		],
	];

	/** @var array */
	static $taxonomies = [
		'resource_type'     => [
			'public'            => true,
			'show_in_nav_menus' => false,
			'hierarchical'      => false,
			'labels'            => [
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
			],
			'rewrite'           => [
				'slug'         => 'resource-industry',
				'with_front'   => true,
				'hierarchical' => false,
			],
		],
		'resource_industry' => [
			'public'             => true,
			'publicly_queryable' => false,
			'show_in_nav_menus'  => false,
			'hierarchical'       => false,
			'labels'             => [
				'name'                       => 'Industries',
				'singular_name'              => 'Industry',
				'menu_name'                  => 'Industries',
				'all_items'                  => 'All Industries',
				'new_item_name'              => 'New Industry Name',
				'add_new_item'               => 'Add New Industry',
				'edit_item'                  => 'Edit Industry',
				'update_item'                => 'Update Industry',
				'view_item'                  => 'View Industry',
				'separate_items_with_commas' => 'Separate Industries with commas',
				'add_or_remove_items'        => 'Add or remove industries',
				'choose_from_most_used'      => 'Choose from the most used',
				'popular_items'              => 'Popular Industries',
				'search_items'               => 'Search Industries',
				'not_found'                  => 'Not Found',
				'items_list'                 => 'Industries list',
				'items_list_navigation'      => 'Industries list navigation',
			],
			'rewrite'            => [
				'slug'         => 'resource-industry',
				'with_front'   => true,
				'hierarchical' => false,
			],
		],
		'resource_product'  => [
			'public'             => true,
			'publicly_queryable' => false,
			'show_in_nav_menus'  => false,
			'hierarchical'       => false,
			'labels'             => [
				'name'                       => 'Products',
				'singular_name'              => 'Product',
				'menu_name'                  => 'Products',
				'all_items'                  => 'All Products',
				'new_item_name'              => 'New Product Name',
				'add_new_item'               => 'Add New Product',
				'edit_item'                  => 'Edit Product',
				'update_item'                => 'Update Product',
				'view_item'                  => 'View Product',
				'separate_items_with_commas' => 'Separate Products with commas',
				'add_or_remove_items'        => 'Add or remove Products',
				'choose_from_most_used'      => 'Choose from the most used',
				'popular_items'              => 'Popular Products',
				'search_items'               => 'Search Products',
				'not_found'                  => 'Not Found',
				'items_list'                 => 'Products list',
				'items_list_navigation'      => 'Products list navigation',
			],
			'rewrite'            => [
				'slug'         => 'resource-product',
				'with_front'   => true,
				'hierarchical' => false,
			],
		],
		'resource_service'  => [
			'public'             => true,
			'publicly_queryable' => false,
			'show_in_nav_menus'  => false,
			'hierarchical'       => false,
			'labels'             => [
				'name'                       => 'Services',
				'singular_name'              => 'Service',
				'menu_name'                  => 'Services',
				'all_items'                  => 'All Services',
				'new_item_name'              => 'New Service Name',
				'add_new_item'               => 'Add New Service',
				'edit_item'                  => 'Edit Service',
				'update_item'                => 'Update Service',
				'view_item'                  => 'View Service',
				'separate_items_with_commas' => 'Separate Services with commas',
				'add_or_remove_items'        => 'Add or remove Services',
				'choose_from_most_used'      => 'Choose from the most used',
				'popular_items'              => 'Popular Services',
				'search_items'               => 'Search Services',
				'not_found'                  => 'Not Found',
				'items_list'                 => 'Services list',
				'items_list_navigation'      => 'Services list navigation',
			],
			'rewrite'            => [
				'slug'         => 'resource-service',
				'with_front'   => true,
				'hierarchical' => false,
			],
		],
	];

	/**
	 * key/value pairs should be slug => label. If the slug matches a
	 * taxonomy then the column should automatically populate with terms from
	 * that taxonomy. If not, implement an admin_column_{slug}($column, $post)
	 * function in this class that echoes out what the column should contain.
	 *
	 * @var array
	 **/
	static $admin_columns = [
		'gated_resource'    => 'Gated Resource?',
		'resource_type'     => 'Type',
		'resource_industry' => 'Industry',
		'resource_product'  => 'Product',
		'resource_service'  => 'Service',
	];
	public static function admin_column_gated_resource($column, $post) {
		$value = get_post_meta($post->ID, 'gated_resource', true);
		echo $value == 1 ? 'Yes' : 'No';
	}

	/**
	 * Passed into acf_add_local_field_group() during the acf/init action.
	 * Leave the location paramter out, it will automatically be set for you!
	 *
	 * @var array
	 */
	static $field_group = [
		'key'                   => 'group_resource_cpt',
		'title'                 => 'Resource Properties',
		'menu_order'            => 0,
		'position'              => 'acf_after_title',
		'style'                 => 'seamless',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'fields'                => [
			// tab 2
			[
				'key'   => 'field_cpt_resource_tab2',
				'label' => 'Resource Descriptors',
				'type'  => 'tab',
			],
			//thumbnail
			[
				'key'                   => 'field_cpt_resource_thumbnail',
				'label'                 => 'Thumbnail Image',
				'name'                  => 'resource_thumbnail',
				'type'                  => 'image_crop',
				'return_format'         => 'url',
				'instructions'          => 'This image appears in the feed on the Resource index page. You will be prompted to crop the image to 600 x 360px.',
				'crop'                  => 'hard',
				'target_size'           => 'custom',
				'width'                 => 600,
				'height'                => 360,
				'force_crop'            => 'yes',
				'save_format'           => 'object',
				'save_in_media_library' => 'yes',
				'retina_mode'           => 'no',
				'preview_size'          => 'medium',
				'min_width'             => 600,
				'min_height'            => 360,
				'max_width'             => 2000,
				'max_height'            => 2000,
				'mime_types'            => 'jpg,jpeg,png',
				'wrapper'               => ['width' => '50%'],
			],
			//description
			[
				'key'          => 'field_cpt_resource_description',
				'label'        => 'Description',
				'name'         => 'resource_description',
				'type'         => 'textarea',
				'instructions' => 'Description will be used in Related Products, Services & Resources grid.',
				'wrapper'      => ['width' => '50%'],
			],

			//resource tab
			[
				'key'   => 'field_cpt_resource_tab1',
				'label' => 'Resource',
				'name'  => '',
				'type'  => 'tab',
			],
			//gated?
			[
				'key'          => 'field_cpt_resource_gated',
				'label'        => 'Gated Resource?',
				'name'         => 'gated_resource',
				'type'         => 'true_false',
				'ui'           => true,
				'instructions' => 'Check Here to force the user to fill out a form before they can download the Resource. Instead of the normal Landing Page, a Gated Resource displays as a Gate Page with a download form. After filling out the form, the end user is brought to a Thank You Page, which resembles the standard Resource Landing Page, but with additional content.',
			],
			//resource type
			[
				'key'          => 'field_cpt_resource_type',
				'label'        => 'Source of Resource File',
				'name'         => 'resource_file_type',
				'type'         => 'select',
				'instructions' => 'Select how you will source the file. You can directly upload a file to use for the Resource, select a URL, or embed a video.',
				'required'     => true,
				'choices'      => [
					'upload' => 'Upload a Resource File',
					'url'    => 'Enter a URL for a Resource File',
					'video'  => 'Embed Video',
				],
			],
			//upload
			[
				'key'               => 'field_cpt_resource_upload',
				'label'             => 'File Upload',
				'name'              => 'upload',
				'type'              => 'file',
				'required'          => true,
				'conditional_logic' => [
					[
						[
							'field'    => 'field_cpt_resource_type',
							'operator' => '==',
							'value'    => 'upload',
						],
					],
				],
				'return_format'     => 'url',
				'library'           => 'all',
			],
			// url
			[
				'key'               => 'field_cpt_resource_url',
				'label'             => 'Resource URL',
				'name'              => 'url',
				'type'              => 'url',
				'instructions'      => 'Enter the URL of the Resource.<br>Wistia video URLs must be in this format: <code>https://account.wistia.com/medias/wzzrblbgz7</code>',
				'required'          => true,
				'conditional_logic' => [
					[
						[
							'field'    => 'field_cpt_resource_type',
							'operator' => '==',
							'value'    => 'url',
						],
					],
				],
			],
			// video embed
			[
				'key'               => 'field_cpt_resource_video_url',
				'label'             => 'Resource Video URL',
				'name'              => 'video_url',
				'type'              => 'url',
				'instructions'      => 'Youtube video URLs must be in this format: <code>https://www.youtube.com/embed/jfStneVPX7s</code></br>Video will be embedded in Thank you page.',
				'required'          => true,
				'conditional_logic' => [
					[

						[
							'field'    => 'field_cpt_resource_type',
							'operator' => '==',
							'value'    => 'video',
						],
					],
				],
			],

			//gate page content
			[
				'key'               => 'field_cpt_resource_tab3',
				'label'             => 'Gate Page Content',
				'type'              => 'tab',
				'conditional_logic' => [
					[
						[
							'field'    => 'field_cpt_resource_gated',
							'operator' => '==',
							'value'    => '1',
						],
					],
				],
			],
			[
				'key'               => 'field_cpt_resource_download_form',
				'label'             => 'Download Form',
				'name'              => 'download_form',
				'type'              => 'gravity_forms_field',
				'instructions'      => '',
				'required'          => true,
				'conditional_logic' => [
					[
						[
							'field'    => 'field_cpt_resource_gated',
							'operator' => '==',
							'value'    => '1',
						],
					],
				],
				'allow_null'        => 0,
				'allow_multiple'    => 0,
			],
			[
				'key'          => 'field_cpt_resource_show_success_message',
				'label'        => 'Show Success Message?',
				'name'         => 'show_success_message',
				'type'         => 'true_false',
				'ui'           => 'true',
				'instructions' => 'Check here to show a customizable success message in the Resource Banner.',
			],
			[
				'key'               => 'field_cpt_resource_success_description',
				'label'             => 'Banner Description',
				'name'              => 'thankyou_description',
				'type'              => 'text',
				'default_value'     => 'Be sure to check your inbox for the download link to your new case study. You can also download the file using the link below.',
				'instructions'      => 'Use this field to give distinct instructions on the thank you page following the completion of the Download Form. If left blank, the Banner Description from the Resource Options will be used instead.',
				'conditional_logic' => [
					[
						[
							'field'    => 'field_cpt_resource_gated',
							'operator' => '==',
							'value'    => '1',
						],
						[
							'field'    => 'field_cpt_resource_show_success_message',
							'operator' => '==',
							'value'    => '1',
						],
					],
				],
			],
			[
				'key'          => 'field_cpt_resource_show_followup',
				'label'        => 'Show Follow-Up Form?',
				'name'         => 'show_followup_form',
				'type'         => 'true_false',
				'ui'           => 'true',
				'instructions' => 'Check here to show a secondary form on the Thank You page.',
			],
			[
				'key'               => 'field_cpt_resource_followup_form',
				'label'             => 'Follow-up Form',
				'name'              => 'followup_form',
				'type'              => 'gravity_forms_field',
				'instructions'      => 'This form will appear alongside the content on the Thank You page.',
				'allow_null'        => true,
				'conditional_logic' => [
					[
						[
							'field'    => 'field_cpt_resource_gated',
							'operator' => '==',
							'value'    => '1',
						],
						[
							'field'    => 'field_cpt_resource_show_followup',
							'operator' => '==',
							'value'    => '1',
						],
					],
				],
			],
		],
		'location'              => [
			[
				[
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'resource',
				],
			],
		],
	];

	/** @var array */
	static $options_field_group = [
		[
			'key'   => 'field_resource_opts_lptab',
			'label' => 'Landing Page',
			'type'  => 'tab',
		],
		[
			'key'           => 'field_resource_opts_section_title',
			'label'         => 'Section Title',
			'name'          => 'section_title',
			'type'          => 'text',
			'default_value' => 'Knowledge HUB',
			'instructions'  => 'The title for your resources section',
		],
		[
			'key'           => 'field_resource_opts_section_introduction',
			'label'         => 'Section Introduction',
			'name'          => 'section_description',
			'type'          => 'text',
			'default_value' => 'Latest news and resources to improve your WorkDay experience.',
			'instructions'  => 'A brief one-line introduction for your resources section',
		],
		[
			'key'          => 'field_resource_opts_archive_bottom',
			'type'         => 'post_object',
			'name'         => 'archive_bottom',
			'label'        => 'Archive Content AFTER Post Grid',
			'post_type'    => 'wp_block',
			'instructions' => '
				Select a <a href="/wp-admin/edit.php?post_type=wp_block"
				target="_blank">Reusable Block</a>. Its content will appear
				after the post grid on the <a href="/resources"
				target="_blank">Resource Archive</a>.
			',
		],

		[
			'key'   => 'field_resource_opts_tptab',
			'label' => 'Success Page',
			'type'  => 'tab',
		],
		[
			'key'           => 'field_resource_options_success_description',
			'label'         => 'Banner Description',
			'name'          => 'thankyou_description',
			'type'          => 'text',
			'instructions'  => 'This is a fallback option for a Banner Description on the Thank You page of a gated resource. This will only appear if the resource is set to show the Banner Description and no description is set for the specific resource',
			'default_value' => 'Be sure to check your inbox for the download link to your new case study. You can also download the file using the link below.',
		],
	];



	/**
	 * Get related posts based on number of terms in common
	 * and cache the results in a transient
	 * @param  integer $post_id Post ID
	 * @param  integer $limit   Return no more than this amount
	 * @param  integer $minimum Return at least this amount
	 * @return array|integer[]            Array of post IDs
	 */
	public static function get_related_resources($post_id, $limit = 6, $minimum = 3) {
		if (!$post_id) {
			return [];
		}

		// $transient_id = 'vtl-related-posts-{$post_id}';
		// $transient_data = get_transient($transient_id);

		// if ($transient_data) {
		// 	return $transient_data;
		// }

		global $wpdb;

		$related_resources = $wpdb->get_col($wpdb->prepare("
			SELECT ID, COUNT(*) as relevance
			FROM
			(
				SELECT {$wpdb->posts}.ID
				FROM {$wpdb->term_relationships}
				LEFT JOIN {$wpdb->terms} ON {$wpdb->terms}.term_id = {$wpdb->term_relationships}.term_taxonomy_id
				LEFT JOIN {$wpdb->posts} ON {$wpdb->posts}.ID = {$wpdb->term_relationships}.object_id
				WHERE {$wpdb->terms}.term_id IN (
					SELECT term_taxonomy_id FROM {$wpdb->term_relationships} WHERE object_id = %d
				) AND {$wpdb->posts}.ID != %d
			) as RelatedTerms
			GROUP BY ID
			ORDER BY relevance DESC
			LIMIT %d
		", $post_id, $post_id, $limit), 0);

		// If we found less than the minimum requested,
		// just grab posts of the same type off the top
		// of the stack until we have enough.
		$found_posts = count($related_resources);
		if ($minimum > 0 && $found_posts < $minimum) {
			$related_resources = array_merge($related_resources, get_posts([
				'post_type'      => get_post_type($post_id),
				'posts_per_page' => $minimum - $found_posts,
				'exclude'        => $related_resources,
			]));
		}

		//set_transient($transient_id, $related_resources);
		return $related_resources;
	}

	/**
	 * Deletes transients generated by get_related_resources() on post save
	 */
	// public static function delete_related_resources_transients($post_id) {
	// 	global $wpdb;
	// 	$wpdb->query( $wpdb->prepare('DELETE FROM %s WHERE option_name LIKE %s ', $wpdb->options, '%vtl-related-posts-' . $post_id) );
	// }


	/**
	* Add our Resource Download to the notification if applicable
	*
	* @param array $notification
	* @param object $form Gravity Forms form object
	* @param object $entry Gravity Forms entry object
	*
	* @return array
	*/
	public static function resource_download( $notification, $form, $entry) {
		// make sure we're on the right post type
		$post = get_post( $entry['post_id'] );
		if ($post->post_type != self::$name) {
			return $notification;
		}

		/**
		 * if it's not this specifically named notification
		 * let it go through as is.
		 */
		if ($notification['name'] == 'User Notification') {
			return $notification;
		}

		/**
		 * if the resources isn't for an upload
		 * we can let the notification go as is.
		 */
		$file_type = get_field('resource_file_type', $post);
		if ($file_type != 'upload') {
			return $notification;
		}

		// add our attachment
		$upload_dir = wp_upload_dir();
		$file_url = get_field('upload', $post);
		$attachment = preg_replace( '|^(.*?)/uploads|', $upload_dir['basedir'], $file_url );
		if ($attachment) {
			$notification['attachments'] = $attachment;
		}

		return $notification;
	}

	/**
	 * Adds 'thankyou' rewrite rule.
	 *
	 * Any time a user completes a gravity form, they are sent to ./thank-you.
	 * This action sets up a rewrite rule so that a Thank You page from a
	 * Resource page (presumably a Gated Resource) forwards to the Resource, but
	 * with a 'thankyou' query var set to true so the template knows to display
	 * The Resource Download page instead of the Resource Gate page.
	 */
	public static function thank_you_rewrite() {
		global $wp;

		$wp->add_query_var('thankyou');
		add_rewrite_rule(
			sprintf('^%s?/(.+)/thank-you', static::$name),
			sprintf('index.php?post_type=%s&name=$matches[1]&thankyou=1', static::$name),
			'top'
		);
	}

	/**
	 * Changes Gravity Forms confirmation behavior
	 * @param  string|array $confirmation The confirmation message/array to be filtered
	 * @param  object $form Current form
	 * @param  object $entry Current entry
	 * @param  boolean $ajax If form is configured with AJAX
	 */
	public static function gform_confirmation($confirmation, $form, $entry, $ajax) {
		$is_resource = false;
		$url_pattern1 = '/\/resource\/(.*)/';
		$url_pattern2 = '/\/resource\/(.*)\/thank-you/';

		if (isset($entry['source_url'])) {

			$source_url = $entry['source_url'];

			if ((preg_match($url_pattern1, $source_url) !== 0) && (preg_match($url_pattern2, $source_url) !== 1)) {
				$is_resource = true;
			}
		}

		if ($is_resource !== true) {
			return $confirmation;
		}

		// Remove unwanted query strings
		$conf_url = preg_replace('/\?.*$/', '', $source_url);
		// Remove any trailing slash
		$conf_url = preg_replace('/\/$/', '', $conf_url);
		// Remove any existing trailing /thank-you
		$conf_url = preg_replace('/thank-you$/', '', $conf_url);

		$conf_url = "{$conf_url}/thank-you";

		// Redirect back to post url
		return [
			'redirect' => $conf_url,
		];
	}


	/**
	 * filter function to inject content after the listing
	 *
	 * @return string
	 */
	public static function archive_after_listing() {
		if (!is_post_type_archive(self::$name)) {
			return;
		}

		if (!$archive_bottom = get_field('archive_bottom', 'resource-options')) {
			return;
		}

		echo apply_filters('the_content', $archive_bottom->post_content);
	}

	/**
	 * on a single resource page
	 * that is gated
	 * and that is not a thank you page
	 * --- add the landing-page class
	 *
	 * @param array $classes
	 * @return array
	 */
	public static function body_class($classes) {
		if (in_array('single-resource', $classes) && get_field('gated_resource') && !get_query_var('thankyou')) {
			$classes[] = 'landing-page';
		}

		return $classes;
	}


	static function initialize() {
		parent::initialize();

		// related transients
		// add_action('save_post', [__CLASS__, 'delete_related_resources_transients']);
		// add_action('wp_update_nav_menu', [__CLASS__, 'delete_related_resources_transients']);
		// add_action('post_updated', [__CLASS__, 'delete_related_resources_transients']);

		add_action('init', [__CLASS__, 'thank_you_rewrite']);
		add_filter('gform_confirmation', [__CLASS__, 'gform_confirmation'], 10, 4);
		add_filter('gform_notification', [__CLASS__, 'resource_download'], 10, 3);

		add_action('archive_after_resource_listing', [__CLASS__, 'archive_after_listing']);

		add_filter('body_class', [__CLASS__, 'body_class']);
		/*
		add_filter('gform_field_value_resource', function($value) {
			return get_the_title();
		} );
		*/

		/**
		 * a template for handling the render of a card for this posttype
		 */
		add_filter('render_resource_card', function($card, $resource) {
			return 'resource_card';

			// return Resource_Card::render(['resource' => $resource])
		}, 10, 3);

		/**
		 * a template for handing the grid card of the \Vital\Grid_Service
		 * @param string $card a pre-rendered card. In this case, it's based on the get_post_card function of \Vital\Grid_Service
		 *                     which happens to have the render_{posttype}_card output
		 * @param integer $card_index
		 * @param object $query WP_Rest_Response->data
		 */
		add_filter('resource_grid_card', function($card, $card_index, $query) {
			return 'resource_grid_card';
		}, 10, 4);
	}
}

add_action('after_setup_theme', ['\\USD\\Posttypes\\Resource', 'initialize']);
