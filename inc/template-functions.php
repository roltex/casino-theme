<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Casino_Theme
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function casino_theme_body_classes($classes) {
    // Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present.
    if (!is_active_sidebar('sidebar-1')) {
        $classes[] = 'no-sidebar';
    }

    return $classes;
}
add_filter('body_class', 'casino_theme_body_classes');

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function casino_theme_pingback_header() {
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
    }
}
add_action('wp_head', 'casino_theme_pingback_header');

/**
 * Add casino post class to casino posts
 */
function casino_theme_post_classes($classes) {
    if (is_singular('casino') || is_post_type_archive('casino') || is_tax('casino_category') || is_tax('casino_tag')) {
        $classes[] = 'casino-post';
    }
    
    if (is_singular('game') || is_post_type_archive('game') || is_tax('game_category') || is_tax('game_tag')) {
        $classes[] = 'game-post';
    }
    
    return $classes;
}
add_filter('post_class', 'casino_theme_post_classes');

/**
 * Modify the excerpt more text
 */
function casino_theme_excerpt_more($more) {
    if (!is_admin()) {
        return '...';
    }
    return $more;
}
add_filter('excerpt_more', 'casino_theme_excerpt_more');

/**
 * Modify the excerpt length
 */
function casino_theme_excerpt_length($length) {
    if (!is_admin()) {
        return 20;
    }
    return $length;
}
add_filter('excerpt_length', 'casino_theme_excerpt_length');

/**
 * Add casino rating to casino archive and single pages
 */
function casino_theme_add_casino_rating($content) {
    if (is_singular('casino') || is_post_type_archive('casino')) {
        global $post;
        
        if ($post->post_type === 'casino') {
            $composite_rating = casino_theme_get_casino_composite_rating($post->ID);
            
            if ($composite_rating) {
                $rating_html = '<div class="casino-composite-rating">';
                $rating_html .= '<h3>' . esc_html__('Rating', 'casino-theme') . '</h3>';
                $rating_html .= casino_theme_display_rating_stars($composite_rating);
                $rating_html .= '</div>';
                
                // Add rating before content on single pages, after title on archive pages
                if (is_singular()) {
                    $content = $rating_html . $content;
                } else {
                    // For archive pages, we'll add this in the template directly
                }
            }
        }
    }
    
    return $content;
}
// We're adding this in templates directly instead
// add_filter('the_content', 'casino_theme_add_casino_rating');

/**
 * Add linked casinos to game single pages
 */
function casino_theme_add_linked_casinos($content) {
    if (is_singular('game')) {
        global $post;
        
        if ($post->post_type === 'game') {
            $linked_casinos = casino_theme_get_linked_casinos($post->ID);
            
            if (!empty($linked_casinos)) {
                $casinos_html = '<div class="linked-casinos-section">';
                $casinos_html .= '<h3>' . esc_html__('Related Casinos', 'casino-theme') . '</h3>';
                $casinos_html .= '<div class="row">';
                
                foreach ($linked_casinos as $casino) {
                    $composite_rating = casino_theme_get_casino_composite_rating($casino->ID);
                    
                    $casinos_html .= '<div class="col-md-3 col-sm-4 col-6">';
                    $casinos_html .= '<div class="casino-item">';
                    $casinos_html .= '<a href="' . esc_url(get_permalink($casino->ID)) . '">';
                    $casinos_html .= get_the_post_thumbnail($casino->ID, 'thumbnail', array('class' => 'img-fluid'));
                    $casinos_html .= '<span class="casino-title">' . esc_html($casino->post_title) . '</span>';
                    
                    if ($composite_rating) {
                        $casinos_html .= '<div class="casino-rating">';
                        $casinos_html .= casino_theme_display_rating_stars($composite_rating);
                        $casinos_html .= '</div>';
                    }
                    
                    $casinos_html .= '</a>';
                    $casinos_html .= '</div>';
                    $casinos_html .= '</div>';
                }
                
                $casinos_html .= '</div>';
                $casinos_html .= '</div>';
                
                $content .= $casinos_html;
            }
        }
    }
    
    return $content;
}
// We're adding this in templates directly instead
// add_filter('the_content', 'casino_theme_add_linked_casinos');

/**
 * Add linked games to casino single pages
 */
function casino_theme_add_linked_games($content) {
    if (is_singular('casino')) {
        global $post;
        
        if ($post->post_type === 'casino') {
            $linked_games = casino_theme_get_linked_games($post->ID);
            
            if (!empty($linked_games)) {
                $games_html = '<div class="linked-games-section">';
                $games_html .= '<h3>' . esc_html__('Related Games', 'casino-theme') . '</h3>';
                $games_html .= '<div class="row">';
                
                foreach ($linked_games as $game) {
                    $games_html .= '<div class="col-md-3 col-sm-4 col-6">';
                    $games_html .= '<div class="game-item">';
                    $games_html .= '<a href="' . esc_url(get_permalink($game->ID)) . '">';
                    $games_html .= get_the_post_thumbnail($game->ID, 'thumbnail', array('class' => 'img-fluid'));
                    $games_html .= '<span class="game-title">' . esc_html($game->post_title) . '</span>';
                    $games_html .= '</a>';
                    $games_html .= '</div>';
                    $games_html .= '</div>';
                }
                
                $games_html .= '</div>';
                $games_html .= '</div>';
                
                $content .= $games_html;
            }
        }
    }
    
    return $content;
}
// We're adding this in templates directly instead
// add_filter('the_content', 'casino_theme_add_linked_games');

/**
 * Add casino structured data
 */
function casino_theme_add_casino_structured_data() {
    if (is_singular('casino')) {
        global $post;
        
        if ($post->post_type === 'casino') {
            $casino_meta = casino_theme_get_casino_meta($post->ID);
            $official_site = $casino_meta['_casino_official_site'];
            $year_established = $casino_meta['_casino_year_established'];
            $contact_email = $casino_meta['_casino_contact_email'];
            $composite_rating = $casino_meta['_casino_composite_rating'];
            
            $structured_data = array(
                '@context' => 'https://schema.org',
                '@type' => 'Organization',
                'name' => $post->post_title,
                'description' => wp_strip_all_tags($post->post_content),
                'url' => get_permalink($post->ID)
            );
            
            if ($official_site) {
                $structured_data['sameAs'] = $official_site;
            }
            
            if ($year_established) {
                $structured_data['foundingDate'] = $year_established;
            }
            
            if ($contact_email) {
                $structured_data['email'] = $contact_email;
            }
            
            if ($composite_rating) {
                $structured_data['aggregateRating'] = array(
                    '@type' => 'AggregateRating',
                    'ratingValue' => $composite_rating,
                    'bestRating' => '10',
                    'worstRating' => '0'
                );
            }
            
            echo '<script type="application/ld+json">' . wp_json_encode($structured_data) . '</script>';
        }
    }
}
add_action('wp_head', 'casino_theme_add_casino_structured_data');

/**
 * Add Open Graph meta tags
 */
function casino_theme_add_og_meta_tags() {
    if (is_singular()) {
        global $post;
        
        $og_title = get_the_title();
        $og_description = wp_strip_all_tags(get_the_excerpt());
        $og_url = get_permalink();
        $og_image = '';
        
        if (has_post_thumbnail()) {
            $og_image = get_the_post_thumbnail_url($post->ID, 'large');
        }
        
        echo '<meta property="og:title" content="' . esc_attr($og_title) . '" />' . "\n";
        echo '<meta property="og:description" content="' . esc_attr($og_description) . '" />' . "\n";
        echo '<meta property="og:url" content="' . esc_url($og_url) . '" />' . "\n";
        echo '<meta property="og:type" content="article" />' . "\n";
        
        if ($og_image) {
            echo '<meta property="og:image" content="' . esc_url($og_image) . '" />' . "\n";
        }
    }
}
add_action('wp_head', 'casino_theme_add_og_meta_tags');