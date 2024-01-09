# WordPress Custom Post Types Plugin

Custom post type class for easy creation. Based on JJGrainger's PHP class: https://jjgrainger.co.uk/2013/07/15/easy-wordpress-custom-post-types/

## Installation

1. Download, install, and enable plugin in WordPress
2. Create a new file for each post type in `post-types` directory.
3. `require` each post type file in `custom-post-types.php`

## How to Use

Check out `post-types/example.php` for an example.

### Post Type Name
	static $name = 'vtl_widget';

* `name` – Post type name (required, singular, lowercase, underscores). It's recommended to prefix this value to prevent collisions.

### Post Type Labels

    static $labels = [
        'singular' => 'Widget',
        'plural'   => 'Widgets',
    ];

* `singular` – Name for one object of this post type.
* `plural` – Name for two or more objects of this post type.

### Post Type Options

    static $options = [
        'supports'            => array('title'),
        'hierarchical'        => false,
        'menu_position'       => 20,
        'menu_icon'           => 'dashicons-star-filled',
        'show_in_nav_menus'   => true,
        'has_archive'         => false,
        'exclude_from_search' => false,
        'rewrite'             => array('with_front' => false)
    ];

[All available options →](https://codex.wordpress.org/Function_Reference/register_post_type)

### Create Post Type

    add_action('after_setup_theme', ['\\Vital\\Posttypes\\Example', 'initialize']);

This will call the parent class's `initialize` function which will handle all the dirty work.

### Set Menu Icon
Carefully choose your perfect [Dashicon →](https://developer.wordpress.org/resource/dashicons)

The slug of the dashicon should be set to the `$options` `menu-icon` item.

    $options['menu-icon] = 'dashicons-star-filled';

### Change Title Placeholder Text (Optional)
Changes the placeholder text in the title field on the post editor.

    static $placeholder_text = 'Enter widget name here';

### Customize Admin Columns
#### Adding Columns
##### Create column

    static $admin_columns = [
        'custom_meta' => 'Custom Meta'
    ];

The admin_columns property on the class is an array of `key` & `value` pairs where the `key` represents the slug of the column and the `value` is the label to display for the column.

##### Populate column with content

	static $admin_columns = [
		'widget_category' => 'Widget Categories',
		'is_locked'       => 'Is Locked?'
	];
	public static function admin_column_is_locked($column, $post) {
		$value = get_post_meta($post->ID, 'is_locked', true);
		echo $value === 1 ? 'Yes' : 'No';
	}

If the column `key` represents a slug for an associated taxonomy, the values will be pre-populated by the extended class and there is no other logic needed for those columns unless desired.

In the example above, `widget_category` is for a taxonomy and will NOT require any futher logic to display the basic column content. The `is_locked` column requires additional logic to populate it's content. The extended class creates a scaffold for populating that content. Just create a function called `admin_column_[column-slug]` where `[column-slug]` is the array key of the column as defined in `$admin_columns` and have that function echo out the desired content.


#### Hiding Columns

    static $admin_columns_to_remove = ['date', 'author', 'wpseo-score', 'wpseo-score-readability'];

Add the column key to the array of columns to remove.

### Taxonomies

    static $taxonomies = [
		'widget_category' => [
			'labels' => [
				'name'              => 'Widget Categories',
				'singular'          => 'Widget Category',
				'plural'            => 'Widget Categories',
				'menu_name'         => 'Widget Categories',
				'add_new_item'      => 'Add Widget Category',
				'not_found'         => 'No Widget Categories Found',
				'parent_item'       => 'Parent Widget Categories',
				'parent_item_colon' => 'Parent Widget Categories:',
			]
			'heirarchical'     => true,
			'rewrite' => [
				'slug'       => 'widget-category'
				'with_front' => true,
			]
		],
		'tags' => []
    ];

Taxonomies are associated with this posttype, by a key and value array of taxonomy settings. The key should be the slug of the taxonomy (singular, lowercase, using underscores). If this is a 'new' taxonomy, add an array of the configuration options for the taxonomy. If this is a pre-existing taxonomy, an empty array is all that is required for the options value.

[All available options →](https://codex.wordpress.org/Function_Reference/register_taxonomy)

The extended class will create filter dropdowns for any taxonomies associated with this posttype.