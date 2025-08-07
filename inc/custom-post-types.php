<?php
/**
 * Custom post types for games and casinos
 *
 * @package Casino_Theme
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Game post type
 */
function casino_theme_register_game_post_type() {
    $labels = array(
        'name'                  => _x('Games', 'Post type general name', 'casino-theme'),
        'singular_name'         => _x('Game', 'Post type singular name', 'casino-theme'),
        'menu_name'             => _x('Games', 'Admin Menu text', 'casino-theme'),
        'name_admin_bar'        => _x('Game', 'Add New on Toolbar', 'casino-theme'),
        'add_new'               => __('Add New', 'casino-theme'),
        'add_new_item'          => __('Add New Game', 'casino-theme'),
        'new_item'              => __('New Game', 'casino-theme'),
        'edit_item'             => __('Edit Game', 'casino-theme'),
        'view_item'             => __('View Game', 'casino-theme'),
        'all_items'             => __('All Games', 'casino-theme'),
        'search_items'          => __('Search Games', 'casino-theme'),
        'parent_item_colon'     => __('Parent Games:', 'casino-theme'),
        'not_found'             => __('No games found.', 'casino-theme'),
        'not_found_in_trash'    => __('No games found in Trash.', 'casino-theme'),
        'featured_image'        => _x('Game Cover Image', 'Overrides the "Featured Image" phrase for this post type', 'casino-theme'),
        'set_featured_image'    => _x('Set cover image', 'Overrides the "Set featured image" phrase for this post type', 'casino-theme'),
        'remove_featured_image' => _x('Remove cover image', 'Overrides the "Remove featured image" phrase for this post type', 'casino-theme'),
        'use_featured_image'    => _x('Use as cover image', 'Overrides the "Use as featured image" phrase for this post type', 'casino-theme'),
        'archives'              => _x('Game archives', 'The post type archive label used in nav menus', 'casino-theme'),
        'insert_into_item'      => _x('Insert into game', 'Overrides the "Insert into post" phrase for this post type', 'casino-theme'),
        'uploaded_to_this_item' => _x('Uploaded to this game', 'Overrides the "Uploaded to this post" phrase for this post type', 'casino-theme'),
        'filter_items_list'     => _x('Filter games list', 'Screen reader text for the filter links', 'casino-theme'),
        'items_list_navigation' => _x('Games list navigation', 'Screen reader text for the pagination', 'casino-theme'),
        'items_list'            => _x('Games list', 'Screen reader text for the items list', 'casino-theme'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'games'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-games',
        'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt'),
        'show_in_rest'       => true,
    );

    register_post_type('game', $args);
}
add_action('init', 'casino_theme_register_game_post_type');

/**
 * Register Casino post type
 */
function casino_theme_register_casino_post_type() {
    $labels = array(
        'name'                  => _x('Casinos', 'Post type general name', 'casino-theme'),
        'singular_name'         => _x('Casino', 'Post type singular name', 'casino-theme'),
        'menu_name'             => _x('Casinos', 'Admin Menu text', 'casino-theme'),
        'name_admin_bar'        => _x('Casino', 'Add New on Toolbar', 'casino-theme'),
        'add_new'               => __('Add New', 'casino-theme'),
        'add_new_item'          => __('Add New Casino', 'casino-theme'),
        'new_item'              => __('New Casino', 'casino-theme'),
        'edit_item'             => __('Edit Casino', 'casino-theme'),
        'view_item'             => __('View Casino', 'casino-theme'),
        'all_items'             => __('All Casinos', 'casino-theme'),
        'search_items'          => __('Search Casinos', 'casino-theme'),
        'parent_item_colon'     => __('Parent Casinos:', 'casino-theme'),
        'not_found'             => __('No casinos found.', 'casino-theme'),
        'not_found_in_trash'    => __('No casinos found in Trash.', 'casino-theme'),
        'featured_image'        => _x('Casino Logo', 'Overrides the "Featured Image" phrase for this post type', 'casino-theme'),
        'set_featured_image'    => _x('Set logo', 'Overrides the "Set featured image" phrase for this post type', 'casino-theme'),
        'remove_featured_image' => _x('Remove logo', 'Overrides the "Remove featured image" phrase for this post type', 'casino-theme'),
        'use_featured_image'    => _x('Use as logo', 'Overrides the "Use as featured image" phrase for this post type', 'casino-theme'),
        'archives'              => _x('Casino archives', 'The post type archive label used in nav menus', 'casino-theme'),
        'insert_into_item'      => _x('Insert into casino', 'Overrides the "Insert into post" phrase for this post type', 'casino-theme'),
        'uploaded_to_this_item' => _x('Uploaded to this casino', 'Overrides the "Uploaded to this post" phrase for this post type', 'casino-theme'),
        'filter_items_list'     => _x('Filter casinos list', 'Screen reader text for the filter links', 'casino-theme'),
        'items_list_navigation' => _x('Casinos list navigation', 'Screen reader text for the pagination', 'casino-theme'),
        'items_list'            => _x('Casinos list', 'Screen reader text for the items list', 'casino-theme'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'casino'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-money',
        'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt'),
        'show_in_rest'       => true,
    );

    register_post_type('casino', $args);
}
add_action('init', 'casino_theme_register_casino_post_type');

/**
 * Register Game Category taxonomy
 */
function casino_theme_register_game_category_taxonomy() {
    $labels = array(
        'name'              => _x('Game Categories', 'taxonomy general name', 'casino-theme'),
        'singular_name'     => _x('Game Category', 'taxonomy singular name', 'casino-theme'),
        'search_items'      => __('Search Game Categories', 'casino-theme'),
        'all_items'         => __('All Game Categories', 'casino-theme'),
        'parent_item'       => __('Parent Game Category', 'casino-theme'),
        'parent_item_colon' => __('Parent Game Category:', 'casino-theme'),
        'edit_item'         => __('Edit Game Category', 'casino-theme'),
        'update_item'       => __('Update Game Category', 'casino-theme'),
        'add_new_item'      => __('Add New Game Category', 'casino-theme'),
        'new_item_name'     => __('New Game Category Name', 'casino-theme'),
        'menu_name'         => __('Game Categories', 'casino-theme'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'game-category'),
        'show_in_rest'      => true,
    );

    register_taxonomy('game_category', array('game'), $args);
}
add_action('init', 'casino_theme_register_game_category_taxonomy');

/**
 * Register Game Tag taxonomy
 */
function casino_theme_register_game_tag_taxonomy() {
    $labels = array(
        'name'                       => _x('Game Tags', 'taxonomy general name', 'casino-theme'),
        'singular_name'              => _x('Game Tag', 'taxonomy singular name', 'casino-theme'),
        'search_items'               => __('Search Game Tags', 'casino-theme'),
        'popular_items'              => __('Popular Game Tags', 'casino-theme'),
        'all_items'                  => __('All Game Tags', 'casino-theme'),
        'edit_item'                  => __('Edit Game Tag', 'casino-theme'),
        'update_item'                => __('Update Game Tag', 'casino-theme'),
        'add_new_item'               => __('Add New Game Tag', 'casino-theme'),
        'new_item_name'              => __('New Game Tag Name', 'casino-theme'),
        'separate_items_with_commas' => __('Separate game tags with commas', 'casino-theme'),
        'add_or_remove_items'        => __('Add or remove game tags', 'casino-theme'),
        'choose_from_most_used'      => __('Choose from the most used game tags', 'casino-theme'),
        'not_found'                  => __('No game tags found.', 'casino-theme'),
        'menu_name'                  => __('Game Tags', 'casino-theme'),
    );

    $args = array(
        'hierarchical'      => false,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var'         => true,
        'rewrite'           => array('slug' => 'game-tag'),
        'show_in_rest'      => true,
    );

    register_taxonomy('game_tag', array('game'), $args);
}
add_action('init', 'casino_theme_register_game_tag_taxonomy');

/**
 * Register Casino Category taxonomy
 */
function casino_theme_register_casino_category_taxonomy() {
    $labels = array(
        'name'              => _x('Casino Categories', 'taxonomy general name', 'casino-theme'),
        'singular_name'     => _x('Casino Category', 'taxonomy singular name', 'casino-theme'),
        'search_items'      => __('Search Casino Categories', 'casino-theme'),
        'all_items'         => __('All Casino Categories', 'casino-theme'),
        'parent_item'       => __('Parent Casino Category', 'casino-theme'),
        'parent_item_colon' => __('Parent Casino Category:', 'casino-theme'),
        'edit_item'         => __('Edit Casino Category', 'casino-theme'),
        'update_item'       => __('Update Casino Category', 'casino-theme'),
        'add_new_item'      => __('Add New Casino Category', 'casino-theme'),
        'new_item_name'     => __('New Casino Category Name', 'casino-theme'),
        'menu_name'         => __('Casino Categories', 'casino-theme'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'casino-category'),
        'show_in_rest'      => true,
    );

    register_taxonomy('casino_category', array('casino'), $args);
}
add_action('init', 'casino_theme_register_casino_category_taxonomy');

/**
 * Register Casino Tag taxonomy
 */
function casino_theme_register_casino_tag_taxonomy() {
    $labels = array(
        'name'                       => _x('Casino Tags', 'taxonomy general name', 'casino-theme'),
        'singular_name'              => _x('Casino Tag', 'taxonomy singular name', 'casino-theme'),
        'search_items'               => __('Search Casino Tags', 'casino-theme'),
        'popular_items'              => __('Popular Casino Tags', 'casino-theme'),
        'all_items'                  => __('All Casino Tags', 'casino-theme'),
        'edit_item'                  => __('Edit Casino Tag', 'casino-theme'),
        'update_item'                => __('Update Casino Tag', 'casino-theme'),
        'add_new_item'               => __('Add New Casino Tag', 'casino-theme'),
        'new_item_name'              => __('New Casino Tag Name', 'casino-theme'),
        'separate_items_with_commas' => __('Separate casino tags with commas', 'casino-theme'),
        'add_or_remove_items'        => __('Add or remove casino tags', 'casino-theme'),
        'choose_from_most_used'      => __('Choose from the most used casino tags', 'casino-theme'),
        'not_found'                  => __('No casino tags found.', 'casino-theme'),
        'menu_name'                  => __('Casino Tags', 'casino-theme'),
    );

    $args = array(
        'hierarchical'      => false,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var'         => true,
        'rewrite'           => array('slug' => 'casino-tag'),
        'show_in_rest'      => true,
    );

    register_taxonomy('casino_tag', array('casino'), $args);
}
add_action('init', 'casino_theme_register_casino_tag_taxonomy');