<?php
/**
 * Team Member
 */

$team_names = [
	'name'      => 'vtl_team_member',
	'menu_name' => 'Team',
	'singular'  => 'Team Member',
	'plural'    => 'Team Members',
	'all_items' => 'All Team Members',
	'slug'      => 'team-member',
];

$team_options = [
	'exclude_from_search' => true,
	'hierarchical'        => false,
	'menu_position'       => 20,
	'has_archive'         => false,
	'rewrite'             => ['with_front' => false],
	'show_in_admin_bar'   => true,
	'show_in_menu'        => true,
	'show_in_nav_menus'   => false,
	'show_in_rest'        => false,
	'show_ui'             => true,
	'supports'            => ['title', 'thumbnail'],
];

$team = new PostType($team_names, $team_options);

$team->icon('dashicons-groups');

$team->placeholder('Enter name');

$team->columns()->hide(['wpseo-score', 'wpseo-score-readability']);

$team->columns()->set([
	'cb'                => '<input type="checkbox" />',
	'team_member_photo' => 'Photo',
	'title'             => __('Title'),
	'ct_team_group'     => __('Group'),
]);

$team->columns()->populate('team_member_photo', function($column, $post_id) {
	$edit_post_link = get_edit_post_link($post_id);

	if ($thumb = get_the_post_thumbnail($post_id, 'thumbnail', ['style' => 'width: 32px; height: 32px;'])) {
		$img = $thumb;
	} else {
		$default = get_avatar_data(2, [
			'size'          => 64,
			'force_default' => true,
		]);

		$img = sprintf('<img src="%s" style="width: 32px; height: 32px;">', $default['url']);
	}

	printf('<a href="%s">%s</a>', $edit_post_link, $img);
});

add_action('admin_head', function() {
	$screen = get_current_screen();
	if ($screen && ($screen->base === 'edit') && ($screen->id === 'edit-vtl_team_member')) {
		echo '<style>
		th[id=team_member_photo] {
			width: 42px;
		}
		</style>';
	}
});

$team_group_names = [
	'name'     => 'team_group',
	'singular' => 'Group',
	'plural'   => 'Groups',
	'slug'     => 'team-group',
];

$team_group_options = [
	'heirarchical'      => true,
	'show_in_nav_menus' => false,
	'show_in_rest'      => false,
	'show_admin_column' => true,
];

$team->taxonomy($team_group_names, $team_group_options);
