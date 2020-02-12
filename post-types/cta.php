<?php
/**
 * CTA
 *
 * This post type is designed to be used with ACF. You will create ACF field groups
 * for each CTA style so that the user is given the appropriate set of custom fields
 * depending on the style they choose when creating a CTA.
 *
 */

$cta_names = [
	'name'      => 'vtl_cta',
	'singular'  => 'CTA',
	'plural'    => 'CTA',
	'all_items' => 'All CTAs',
	'menu_name' => 'CTAs',
	'slug'      => 'cta',
];

$cta_options = [
	'exclude_from_search' => true,
	'has_archive'         => false,
	'hierarchical'        => false,
	'menu_position'       => 22,
	'publicly_queryable'  => false,
	'rewrite'             => ['with_front' => false],
	'show_in_nav_menus'   => false,
	'show_in_rest'        => false,
	'supports'            => ['title'],
];

$cta = new PostType($cta_names, $cta_options);

$cta->icon('dashicons-welcome-widgets-menus');
$cta->placeholder('Enter description');
$cta->columns()->hide(['wpseo-score', 'wpseo-score-readability']);

$cta_style_names = [
	'name'     => 'cta_style',
	'singular' => 'CTA Style',
	'plural'   => 'CTA Styles',
	'slug'     => 'cta-style',
];

$cta_style_options = [
	'heirarchical'      => true,
	'show_in_nav_menus' => false,
	'labels'            => ['menu_name' => 'Styles'],
];

$cta->taxonomy($cta_style_names, $cta_style_options);

/**
 * Disable the taxonomy archive pages
 */
function disable_cta_style_archive($query) {
	if (is_admin()) {
		return;
	}
	if (is_tax('cta_style')) {
		$query->set_404();
	}
}
add_action('pre_get_posts', 'disable_cta_style_archive');

/**
 * Replace default taxonomy metabox with radio button metabox
 */
class CTA_Style_Radio_Metabox {
	static $taxonomy = 'cta_style';
	static $taxonomy_metabox_id = 'cta_stylediv';
	static $post_type= 'vtl_cta';

	public static function load() {
		add_action('admin_menu', [__CLASS__, 'remove_meta_box']);
		add_action('add_meta_boxes', [__CLASS__, 'add_meta_box']);
	}

	public static function remove_meta_box() {
		remove_meta_box(static::$taxonomy_metabox_id, static::$post_type, 'normal');
	}

	public static function add_meta_box() {
		add_meta_box('cta_style_metabox', 'CTA Style', array(__CLASS__, 'metabox'), static::$post_type, 'side', 'core');
	}

	public static function metabox($post) {
		$taxonomy = self::$taxonomy;
		$tax = get_taxonomy($taxonomy);
		$terms = get_terms($taxonomy, ['hide_empty' => 0]);
       		$name = 'tax_input[' . $taxonomy . '][]';
		$postterms = get_the_terms($post->ID, $taxonomy);
		$current = ($postterms ? array_pop($postterms) : false);
		$current = ($current ? $current->term_id : 0);
		?>
		<div id="taxonomy-<?php echo $taxonomy; ?>" class="categorydiv">
			<div id="<?php echo $taxonomy; ?>-all" class="tabs-panel">
				<ul id="<?php echo $taxonomy; ?>checklist" class="list:<?php echo $taxonomy; ?> categorychecklist form-no-clear">
					<?php
					foreach ($terms as $term) {
						$id = $taxonomy . '-' . $term->term_id;
						$value = (is_taxonomy_hierarchical($taxonomy) ? "value='{$term->term_id}'" : "value='{$term->term_slug}'");
						echo "<li id='$id'><label class='selectit'>";
						echo "<input type='radio' id='in-$id' name='{$name}'" . checked($current, $term->term_id, false) . " {$value}>$term->name<br>";
						echo '</label></li>';
					}
					?>
				</ul>
			</div>
		</div>
		<?php
	}
}

CTA_Style_Radio_Metabox::load();
