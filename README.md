# WordPress Custom Post Types Plugin

Custom post type class for easy creation. Based on JJGrainer's PHP class: http://jjgrainger.co.uk/2013/07/15/easy-wordpress-custom-post-types/

## Installation

1. Download, install, and enable plugin in WordPress
2. Create a new file for each post type in `post-types` directory.
3. `require` each post type file in `custom-post-types.php`

_Coming soon: A wp-admin options page that will let you activate/deactivate individual post types without having to manually edit `custom-post-types.php`._

## How to Use

Check out `post-types/example.php` for an example.

### Post Type Names

    $widget_names = [
        'name' => 'vtl_widget',
        'singular' => 'Widget',
        'plural' => 'Widgets',
        'slug' => 'widget'
    ];

* `name` – Post type name (required, singular, lowercase, underscores). It's recommended to prefix this value to prevent collisions.
* `singular` – Name for one object of this post type.
* `plural` – Name for two or more objects of this post type.
* `slug` – The URL base for this post type.

### Post Type Options

    $widget_options = [
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

    $widgets = new PostType($widget_names, $widget_options);

### Set Menu Icon
Carefully choose your perfect [Dashicon →](https://developer.wordpress.org/resource/dashicons)

    $widgets->icon('dashicons-star-filled');

### Change Title Placeholder Text (Optional)
Changes the placeholder text in the title field on the post editor.

    $widgets->placeholder('Enter widget name here');

### Customize Admin Columns
#### Adding Columns
##### Create column

    $widgets->columns()->add([
        'custom_meta' => 'Custom Meta'
    ]);

##### Populate column with content

    $widgets->columns()->populate('type', function($column, $post_id) {
        echo get_post_meta($post_id, 'custom_meta');
    });

##### Make column sortable

    $widgets->columns()->sortable([
        'custom_meta' => ['custom_meta', true]
    ]);

`true` = Sort numerically
`false` = Sort alphabetically

#### Hiding Columns

    $widgets->columns()->hide(['date', 'author', 'wpseo-score', 'wpseo-score-readability']);

### Taxonomies
#### Taxonomy Names

    $widget_type_names = [
        'name'     => 'widget_type',
        'singular' => 'Type',
        'plural'   => 'Types',
        'slug'     => 'widget-type'
    ];

* `name` – Taxonomy name (required, singular, lowercase, underscores).
* `singular` – Singular name of taxonomy.
* `plural` – Plural name of taxonomy.
* `slug` – The URL base for taxonomy.

#### Taxonomy Options

    $widget_type_options = [
        'heirarchical'      => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => false
    ];

[All available options →](https://codex.wordpress.org/Function_Reference/register_taxonomy)

#### Create Taxonomy

    $widgets->taxonomy($widget_type_names, $widget_type_options);

#### Add Admin Filters (Optional)
Adds dropdown menus to admin list for filtering by taxonomy.

    new Taxonomy_Filter(array($post_type => $taxonomies));

* `$post_type` – Name of this post type.
* `$taxonomies` – Array of taxonomy names. Each item will get its own dropdown.