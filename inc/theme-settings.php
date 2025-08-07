<?php
/**
 * Theme Settings for Casino Theme
 *
 * @package Casino_Theme
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add dynamic CSS for theme settings
 */
function casino_theme_dynamic_css()
{
    // Only load on frontend, not in admin
    if (!is_admin()) {
        // Use default colors since customizer settings were removed
        $primary_color = '#0a0a2b';
        $secondary_color = '#007bff';
        $accent_color = '#ffc107';
        
        $css = "
        :root {
            --casino-primary-color: {$primary_color};
            --casino-secondary-color: {$secondary_color};
            --casino-accent-color: {$accent_color};
        }
        
        .site-header {
            background-color: {$primary_color};
        }
        
        .btn-primary {
            background-color: {$secondary_color};
            border-color: {$secondary_color};
        }
        
        .btn-primary:hover {
            background-color: " . casino_theme_darken_color($secondary_color, 10) . ";
            border-color: " . casino_theme_darken_color($secondary_color, 10) . ";
        }
        
        .casino-rating {
            color: {$accent_color};
        }
        
        .feature-badge.loyalty {
            background-color: {$accent_color};
        }
        ";
        
        wp_add_inline_style('casino-theme-style', $css);
    }
}
add_action('wp_enqueue_scripts', 'casino_theme_dynamic_css');

/**
 * Darken a color
 *
 * @param string $color The hex color.
 * @param int $percent The percentage to darken.
 * @return string
 */
function casino_theme_darken_color($color, $percent)
{
    $color = str_replace('#', '', $color);
    
    if (strlen($color) == 3) {
        $color = $color[0] . $color[0] . $color[1] . $color[1] . $color[2] . $color[2];
    }
    
    $rgb = array(
        'r' => hexdec(substr($color, 0, 2)),
        'g' => hexdec(substr($color, 2, 2)),
        'b' => hexdec(substr($color, 4, 2))
    );
    
    $rgb['r'] = max(0, min(255, $rgb['r'] - ($rgb['r'] * $percent / 100)));
    $rgb['g'] = max(0, min(255, $rgb['g'] - ($rgb['g'] * $percent / 100)));
    $rgb['b'] = max(0, min(255, $rgb['b'] - ($rgb['b'] * $percent / 100)));
    
    return '#' . sprintf('%02x%02x%02x', $rgb['r'], $rgb['g'], $rgb['b']);
}