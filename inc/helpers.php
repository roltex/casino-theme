<?php
/**
 * Helper functions
 *
 * @package Casino_Theme
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get linked casinos for a game
 *
 * @param int $game_id Game post ID
 * @return array Array of casino post objects
 */
function casino_theme_get_linked_casinos($game_id)
{
    $casino_ids = get_post_meta($game_id, '_game_linked_casinos', true);
    
    if (empty($casino_ids) || !is_array($casino_ids)) {
        return array();
    }
    
    // Get casino posts
    $casinos = get_posts(array(
        'post_type' => 'casino',
        'post__in' => $casino_ids,
        'numberposts' => -1,
        'post_status' => 'publish',
        'orderby' => 'title',
        'order' => 'ASC'
    ));
    
    return $casinos;
}

/**
 * Get linked games for a casino
 *
 * @param int $casino_id Casino post ID
 * @return array Array of game post objects
 */
function casino_theme_get_linked_games($casino_id)
{
    $game_ids = get_post_meta($casino_id, '_casino_linked_games', true);
    
    if (empty($game_ids) || !is_array($game_ids)) {
        return array();
    }
    
    // Get game posts
    $games = get_posts(array(
        'post_type' => 'game',
        'post__in' => $game_ids,
        'numberposts' => -1,
        'post_status' => 'publish',
        'orderby' => 'title',
        'order' => 'ASC'
    ));
    
    return $games;
}

/**
 * Get popular casinos (highest rated)
 *
 * @param int $limit Number of casinos to retrieve
 * @return array Array of casino post objects
 */
function casino_theme_get_popular_casinos($limit = 3)
{
    $casinos = get_posts(array(
        'post_type' => 'casino',
        'numberposts' => $limit,
        'post_status' => 'publish',
        'meta_key' => '_casino_composite_rating',
        'orderby' => 'meta_value_num',
        'order' => 'DESC'
    ));
    
    return $casinos;
}

/**
 * Get recent casinos
 *
 * @param int $limit Number of casinos to retrieve
 * @return array Array of casino post objects
 */
function casino_theme_get_recent_casinos($limit = 3)
{
    $casinos = get_posts(array(
        'post_type' => 'casino',
        'numberposts' => $limit,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC'
    ));
    
    return $casinos;
}

/**
 * Display casino rating stars
 *
 * @param float $rating Rating value (0-10)
 * @param int $max Maximum rating value
 * @return string HTML for rating stars
 */
function casino_theme_display_rating_stars($rating, $max = 10)
{
    if (!$rating) {
        return '';
    }
    
    // Convert 0-10 scale to 0-5 scale
    $rating = $rating / 2;
    
    $full_stars = floor($rating);
    $half_star = ($rating - $full_stars) >= 0.5 ? 1 : 0;
    $empty_stars = 5 - $full_stars - $half_star;
    
    $output = '<div class="casino-rating-stars">';
    
    // Full stars
    for ($i = 0; $i < $full_stars; $i++) {
        $output .= '<span class="star full">&#9733;</span>';
    }
    
    // Half star
    if ($half_star) {
        $output .= '<span class="star half">&#9733;</span>';
    }
    
    // Empty stars
    for ($i = 0; $i < $empty_stars; $i++) {
        $output .= '<span class="star empty">&#9734;</span>';
    }
    
    $output .= ' <span class="rating-value">' . number_format($rating * 2, 1) . '/' . $max . '</span>';
    $output .= '</div>';
    
    return $output;
}

/**
 * Display casino card using the reusable template
 *
 * @param int $casino_id Casino post ID
 * @param array $args Additional arguments for customization
 * @return void
 */
if (!function_exists('casino_theme_display_casino_card')) {
    function casino_theme_display_casino_card($casino_id, $args = array()) {
        // Set default arguments
        $defaults = array(
            'casino_id' => $casino_id,
            'card_type' => 'default',
            'show_excerpt' => true,
            'show_features' => true,
            'show_details' => true,
            'show_rating' => true,
            'excerpt_length' => 15
        );
        
        // Merge with provided arguments
        $args = wp_parse_args($args, $defaults);
        
        // Include the casino card template
        get_template_part('template-parts/casino-card', null, $args);
    }
}

/**
 * Display game card using the reusable template
 *
 * @param int $game_id Game post ID
 * @param array $args Additional arguments for customization
 * @return void
 */
if (!function_exists('casino_theme_display_game_card')) {
    function casino_theme_display_game_card($game_id, $args = array()) {
        // Set default arguments
        $defaults = array(
            'game_id' => $game_id,
            'card_type' => 'default',
            'show_excerpt' => true,
            'show_features' => true,
            'show_details' => true,
            'show_rating' => true,
            'excerpt_length' => 15
        );
        
        // Merge with provided arguments
        $args = wp_parse_args($args, $defaults);
        
        // Include the game card template
        get_template_part('template-parts/game-card', null, $args);
    }
}

/**
 * Get casino features as compact badges for widgets
 *
 * @param int $casino_id Casino post ID
 * @param bool $show_tooltips Whether to show tooltips (default: true)
 * @return string HTML for compact feature badges
 */
function casino_theme_get_casino_features($casino_id, $size = 'compact', $show_tooltips = true)
{
    $features = array();
    
    if (get_post_meta($casino_id, '_casino_loyalty_program', true)) {
        $features[] = array(
            'name' => __('Loyalty Program', 'casino-theme'),
            'class' => 'loyalty',
            'icon' => 'fas fa-star',
            'tooltip' => __('Loyalty Program', 'casino-theme')
        );
    }
    
    if (get_post_meta($casino_id, '_casino_live_casino', true)) {
        $features[] = array(
            'name' => __('Live Casino', 'casino-theme'),
            'class' => 'live',
            'icon' => 'fas fa-video',
            'tooltip' => __('Live Casino', 'casino-theme')
        );
    }
    
    if (get_post_meta($casino_id, '_casino_mobile_casino', true)) {
        $features[] = array(
            'name' => __('Mobile Casino', 'casino-theme'),
            'class' => 'mobile',
            'icon' => 'fas fa-mobile-alt',
            'tooltip' => __('Mobile Casino', 'casino-theme')
        );
    }
    
    if (empty($features)) {
        return '';
    }
    
    $output = '<div class="feature-badges-compact">';
    
    foreach ($features as $feature) {
        $tooltip_attrs = '';
        if ($show_tooltips) {
            $tooltip_attrs = ' data-bs-toggle="tooltip" data-bs-placement="top" title="' . esc_attr($feature['tooltip']) . '"';
        }
        
        $output .= '<span class="feature-badge-compact ' . esc_attr($feature['class']) . '"' . $tooltip_attrs . '>';
        $output .= '<i class="' . esc_attr($feature['icon']) . '"></i>';
        $output .= '</span>';
    }
    
    $output .= '</div>';
    
    return $output;
}

/**
 * Get casino official site URL
 *
 * @param int $casino_id Casino post ID
 * @return string Official site URL
 */
function casino_theme_get_casino_site_url($casino_id)
{
    return get_post_meta($casino_id, '_casino_official_site', true);
}

/**
 * Get casino contact email
 *
 * @param int $casino_id Casino post ID
 * @return string Contact email
 */
function casino_theme_get_casino_contact_email($casino_id)
{
    return get_post_meta($casino_id, '_casino_contact_email', true);
}

/**
 * Get casino year established
 *
 * @param int $casino_id Casino post ID
 * @return int Year established
 */
function casino_theme_get_casino_year_established($casino_id)
{
    return get_post_meta($casino_id, '_casino_year_established', true);
}

/**
 * Get casino composite rating
 *
 * @param int $casino_id Casino post ID
 * @return float Composite rating
 */
function casino_theme_get_casino_composite_rating($casino_id)
{
    return get_post_meta($casino_id, '_casino_composite_rating', true);
}

/**
 * Check if casino has loyalty program
 *
 * @param int $casino_id Casino post ID
 * @return bool True if has loyalty program
 */
function casino_theme_has_loyalty_program($casino_id)
{
    return (bool) get_post_meta($casino_id, '_casino_loyalty_program', true);
}

/**
 * Check if casino has live casino
 *
 * @param int $casino_id Casino post ID
 * @return bool True if has live casino
 */
function casino_theme_has_live_casino($casino_id)
{
    return (bool) get_post_meta($casino_id, '_casino_live_casino', true);
}

/**
 * Check if casino has mobile casino
 *
 * @param int $casino_id Casino post ID
 * @return bool True if has mobile casino
 */
function casino_theme_has_mobile_casino($casino_id)
{
    return (bool) get_post_meta($casino_id, '_casino_mobile_casino', true);
}

/**
 * Get casino statistics
 *
 * @return array Array of casino statistics
 */
function casino_theme_get_casino_stats() {
    $stats = array();
    
    // Total casinos
    $stats['total_casinos'] = wp_count_posts('casino')->publish;
    
    // Total games
    $stats['total_games'] = wp_count_posts('game')->publish;
    
    // Average rating
    global $wpdb;
    $avg_rating = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT AVG(meta_value) FROM {$wpdb->postmeta} 
             WHERE meta_key = %s AND meta_value != ''",
            '_casino_composite_rating'
        )
    );
    $stats['average_rating'] = $avg_rating ? round($avg_rating, 1) : 0;
    
    // Casinos with loyalty programs
    $loyalty_casinos = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT COUNT(*) FROM {$wpdb->postmeta} 
             WHERE meta_key = %s AND meta_value = %s",
            '_casino_loyalty_program',
            '1'
        )
    );
    $stats['loyalty_casinos'] = $loyalty_casinos ? $loyalty_casinos : 0;
    
    return $stats;
}

/**
 * Get related casinos based on categories
 *
 * @param int $casino_id Casino post ID
 * @param int $limit Number of related casinos to return
 * @return array Array of related casino post objects
 */
function casino_theme_get_related_casinos($casino_id, $limit = 3) {
    $casino_categories = wp_get_post_terms($casino_id, 'casino_category', array('fields' => 'ids'));
    
    if (empty($casino_categories)) {
        return array();
    }
    
    $related_casinos = get_posts(array(
        'post_type' => 'casino',
        'numberposts' => $limit,
        'post_status' => 'publish',
        'post__not_in' => array($casino_id),
        'tax_query' => array(
            array(
                'taxonomy' => 'casino_category',
                'field' => 'term_id',
                'terms' => $casino_categories,
            ),
        ),
        'orderby' => 'rand',
    ));
    
    return $related_casinos;
}

/**
 * Get casino search suggestions
 *
 * @param string $search_term Search term
 * @param int $limit Number of suggestions to return
 * @return array Array of casino suggestions
 */
function casino_theme_get_casino_suggestions($search_term, $limit = 5) {
    $suggestions = get_posts(array(
        'post_type' => 'casino',
        'numberposts' => $limit,
        'post_status' => 'publish',
        's' => $search_term,
        'orderby' => 'title',
        'order' => 'ASC'
    ));
    
    return $suggestions;
}

/**
 * Format casino rating for display
 *
 * @param float $rating Rating value
 * @param int $max Maximum rating value
 * @return string Formatted rating string
 */
function casino_theme_format_rating($rating, $max = 10) {
    if ($rating >= 9) {
        return sprintf(__('Excellent (%s/%s)', 'casino-theme'), $rating, $max);
    } elseif ($rating >= 7) {
        return sprintf(__('Good (%s/%s)', 'casino-theme'), $rating, $max);
    } elseif ($rating >= 5) {
        return sprintf(__('Average (%s/%s)', 'casino-theme'), $rating, $max);
    } else {
        return sprintf(__('Poor (%s/%s)', 'casino-theme'), $rating, $max);
    }
}

/**
 * Get casino features as array
 *
 * @param int $casino_id Casino post ID
 * @return array Array of casino features
 */
function casino_theme_get_casino_features_array($casino_id) {
    $features = array();
    
    if (casino_theme_has_loyalty_program($casino_id)) {
        $features[] = __('Loyalty Program', 'casino-theme');
    }
    
    if (casino_theme_has_live_casino($casino_id)) {
        $features[] = __('Live Casino', 'casino-theme');
    }
    
    if (casino_theme_has_mobile_casino($casino_id)) {
        $features[] = __('Mobile Casino', 'casino-theme');
    }
    
    return $features;
}

/**
 * Get casino meta data in a single call
 *
 * @param int $casino_id Casino post ID
 * @param array $meta_keys Array of meta keys to retrieve
 * @return array Array of meta values
 */
function casino_theme_get_casino_meta($casino_id, $meta_keys = array()) {
    if (empty($meta_keys)) {
        $meta_keys = array(
            '_casino_composite_rating',
            '_casino_loyalty_program',
            '_casino_live_casino',
            '_casino_mobile_casino',
            '_casino_official_site',
            '_casino_year_established',
            '_casino_contact_email'
        );
    }
    
    $meta_data = array();
    foreach ($meta_keys as $key) {
        $meta_data[$key] = get_post_meta($casino_id, $key, true);
    }
    
    return $meta_data;
}

/**
 * Get game meta data in a single call
 *
 * @param int $game_id Game post ID
 * @param array $meta_keys Array of meta keys to retrieve
 * @return array Array of meta values
 */
function casino_theme_get_game_meta($game_id, $meta_keys = array()) {
    if (empty($meta_keys)) {
        $meta_keys = array(
            '_game_type',
            '_game_provider',
            '_game_rating',
            '_game_linked_casinos'
        );
    }
    
    $meta_data = array();
    foreach ($meta_keys as $key) {
        $meta_data[$key] = get_post_meta($game_id, $key, true);
    }
    
    return $meta_data;
}