<?php
/**
 * Casino Theme functions and definitions
 *
 * @package Casino_Theme
 * @version 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define theme version
define('CASINO_THEME_VERSION', '1.0.0');

// Include required files
require get_template_directory() . '/inc/helpers.php';
require get_template_directory() . '/inc/theme-settings.php';
require get_template_directory() . '/inc/admin-settings.php';
require get_template_directory() . '/inc/custom-header.php';
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/template-functions.php';
require get_template_directory() . '/inc/custom-post-types.php';
require get_template_directory() . '/inc/custom-fields.php';
require get_template_directory() . '/inc/shortcodes.php';
require get_template_directory() . '/inc/sidebar-widget.php';

/**
 * Bootstrap 5 Navigation Walker
 */
class Bootstrap_5_Nav_Walker extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = null) {
        $output .= "<ul class='dropdown-menu'>";
    }

    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $item_classes = array('nav-item');
        
        // Check if item has children
        $has_children = false;
        if (isset($item->classes) && is_array($item->classes)) {
            $has_children = in_array('menu-item-has-children', $item->classes);
        } elseif (isset($args->has_children)) {
            $has_children = $args->has_children;
        }
        
        if ($has_children) {
            $item_classes[] = 'dropdown';
        }
        
        // Add active classes
        $is_active = false;
        if (isset($item->classes) && is_array($item->classes)) {
            $is_active = in_array('current-menu-item', $item->classes) || 
                        in_array('current_page_item', $item->classes) ||
                        in_array('current_page_parent', $item->classes) ||
                        in_array('current-menu-parent', $item->classes) ||
                        in_array('current-menu-ancestor', $item->classes);
        } else {
            $is_active = (isset($item->ID) && $item->ID == get_queried_object_id());
        }
        
        if ($is_active) {
            $item_classes[] = 'active';
        }
        
        $output .= "<li class='" . implode(' ', $item_classes) . "'>";
        
        $link_classes = array('nav-link');
        
        if ($has_children) {
            $link_classes[] = 'dropdown-toggle';
            $attributes = ' class="' . implode(' ', $link_classes) . '" data-bs-toggle="dropdown" aria-expanded="false"';
        } else {
            if ($is_active) {
                $link_classes[] = 'active';
            }
            $attributes = ' class="' . implode(' ', $link_classes) . '"';
        }
        
        $item_output = $args->before;
        $item_output .= '<a' . $attributes . ' href="' . $item->url . '">';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
if (!function_exists('casino_theme_setup')) :
    function casino_theme_setup() {
        // Make theme available for translation
        load_theme_textdomain('casino-theme', get_template_directory() . '/languages');

        // Add default posts RSS feed links to head
        add_theme_support('automatic-feed-links');

        // Let WordPress manage the document title
        add_theme_support('title-tag');

        // Enable support for Post Thumbnails
        add_theme_support('post-thumbnails');

        // Register navigation menus
        register_nav_menus(
            array(
                'primary' => esc_html__('Primary Menu', 'casino-theme'),
                'footer'  => esc_html__('Footer Menu', 'casino-theme'),
            )
        );

        // Switch default core markup to output valid HTML5
        add_theme_support(
            'html5',
            array(
                'search-form',
                'gallery',
                'caption',
                'style',
                'script',
            )
        );

        // Set up custom background feature
        add_theme_support(
            'custom-background',
            apply_filters(
                'casino_theme_custom_background_args',
                array(
                    'default-color' => 'ffffff',
                    'default-image' => '',
                )
            )
        );

        // Add theme support for selective refresh for widgets
        add_theme_support('customize-selective-refresh-widgets');

        // Add support for custom logo
        add_theme_support(
            'custom-logo',
            array(
                'height'      => 250,
                'width'       => 250,
                'flex-width'  => true,
                'flex-height' => true,
            )
        );

        // Add support for responsive embedded content
        add_theme_support('responsive-embeds');

        // Add support for custom line height controls
        add_theme_support('custom-line-height');

        // Add support for experimental link color control
        add_theme_support('experimental-link-color');

        // Add support for custom units
        add_theme_support('custom-units', 'rem', 'em');
    }
endif;
add_action('after_setup_theme', 'casino_theme_setup');

/**
 * Set the content width in pixels
 */
function casino_theme_content_width() {
    $GLOBALS['content_width'] = apply_filters('casino_theme_content_width', 640);
}
add_action('after_setup_theme', 'casino_theme_content_width');

/**
 * Register widget area
 */
function casino_theme_widgets_init() {
    register_sidebar(
        array(
            'name'          => esc_html__('Sidebar', 'casino-theme'),
            'id'            => 'sidebar-1',
            'description'   => esc_html__('Add widgets here.', 'casino-theme'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
}
add_action('widgets_init', 'casino_theme_widgets_init');

/**
 * Enqueue scripts and styles
 */
function casino_theme_scripts() {
    if (!is_admin()) {
        // Enqueue Bootstrap CSS
        wp_enqueue_style('bootstrap-css', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), '5.3.0');
        
        // Enqueue FontAwesome
        wp_enqueue_style('fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0');
        
        // Enqueue theme styles
        wp_enqueue_style('casino-theme-style', get_stylesheet_uri(), array(), CASINO_THEME_VERSION);
        wp_enqueue_style('casino-theme-custom-style', get_template_directory_uri() . '/assets/css/style.css', array(), CASINO_THEME_VERSION);
        
        // Enqueue scripts
        wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/assets/js/bootstrap.bundle.min.js', array('jquery'), '5.3.0', true);
        wp_enqueue_script('casino-theme-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array('jquery'), CASINO_THEME_VERSION, true);
        wp_enqueue_script('casino-theme-widget-tabs', get_template_directory_uri() . '/assets/js/widget-tabs.js', array('jquery', 'bootstrap-js'), CASINO_THEME_VERSION, true);
        wp_enqueue_script('casino-theme-glassmorphism', get_template_directory_uri() . '/assets/js/glassmorphism.js', array('jquery', 'bootstrap-js'), CASINO_THEME_VERSION, true);
    }
}
add_action('wp_enqueue_scripts', 'casino_theme_scripts');

/**
 * Add defer attribute to scripts for better performance
 */
function casino_theme_defer_scripts($tag, $handle, $src) {
    $defer_scripts = array('casino-theme-navigation', 'casino-theme-widget-tabs', 'casino-theme-glassmorphism');
    
    if (in_array($handle, $defer_scripts)) {
        return str_replace('<script ', '<script defer ', $tag);
    }
    
    return $tag;
}
add_filter('script_loader_tag', 'casino_theme_defer_scripts', 10, 3);

/**
 * Add lazy loading to images
 */
function casino_theme_add_lazy_loading($attr, $attachment, $size) {
    if (!is_admin()) {
        $attr['loading'] = 'lazy';
    }
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'casino_theme_add_lazy_loading', 10, 3);

/**
 * Initialize Bootstrap tooltips
 */
function casino_theme_init_tooltips() {
    if (!is_admin()) {
        ?>
        <script type="text/javascript">
        jQuery(document).ready(function($) {
            if (typeof bootstrap !== 'undefined') {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl, {
                        trigger: 'hover',
                        placement: 'top',
                        animation: true
                    });
                });
            }
        });
        </script>
        <?php
    }
}
add_action('wp_footer', 'casino_theme_init_tooltips');

/**
 * AJAX handler for Template 2 dynamic content
 */
function casino_theme_ajax_template2_content() {
    if (!wp_verify_nonce($_POST['nonce'], 'casino_theme_ajax_nonce')) {
        wp_send_json_error('Security check failed');
        return;
    }

    $casino_id = intval($_POST['casino_id']);
    $column_type = sanitize_text_field($_POST['column_type']);
    
    if (!$casino_id || !$column_type) {
        wp_send_json_error('Invalid parameters');
        return;
    }

    $output = '';
    
    // Get casino meta data using optimized helper function
    $casino_meta = casino_theme_get_casino_meta($casino_id);
    
    switch ($column_type) {
        case 'loyalty':
            $loyalty_program = $casino_meta['_casino_loyalty_program'];
            if ($loyalty_program) {
                $output = '<span class="feature-badge yes-badge"><i class="fas fa-check"></i> ' . esc_html__('YES', 'casino-theme') . '</span>';
            } else {
                $output = '<span class="feature-badge no-badge"><i class="fas fa-times"></i> ' . esc_html__('NO', 'casino-theme') . '</span>';
            }
            break;
            
        case 'live_casino':
            $live_casino = $casino_meta['_casino_live_casino'];
            if ($live_casino) {
                $output = '<span class="feature-badge yes-badge"><i class="fas fa-check"></i> ' . esc_html__('YES', 'casino-theme') . '</span>';
            } else {
                $output = '<span class="feature-badge no-badge"><i class="fas fa-times"></i> ' . esc_html__('NO', 'casino-theme') . '</span>';
            }
            break;
            
        case 'mobile_casino':
            $mobile_casino = $casino_meta['_casino_mobile_casino'];
            if ($mobile_casino) {
                $output = '<span class="feature-badge yes-badge"><i class="fas fa-check"></i> ' . esc_html__('YES', 'casino-theme') . '</span>';
            } else {
                $output = '<span class="feature-badge no-badge"><i class="fas fa-times"></i> ' . esc_html__('NO', 'casino-theme') . '</span>';
            }
            break;
            
        case 'year_established':
            $year_established = $casino_meta['_casino_year_established'];
            if ($year_established) {
                $output = '<span class="year-established-badge">Est. ' . esc_html($year_established) . '</span>';
            } else {
                $output = '<span class="no-data-badge">' . esc_html__('N/A', 'casino-theme') . '</span>';
            }
            break;
            
        case 'contact_email':
            $contact_email = $casino_meta['_casino_contact_email'];
            if ($contact_email) {
                $output = '<a href="mailto:' . esc_attr($contact_email) . '" class="contact-email-link">' . esc_html($contact_email) . '</a>';
            } else {
                $output = '<span class="no-data-badge">' . esc_html__('N/A', 'casino-theme') . '</span>';
            }
            break;
            
        case 'games':
            $linked_games = get_post_meta($casino_id, '_casino_linked_games', true);
            
            if ($linked_games && is_array($linked_games) && !empty($linked_games)) {
                $games = get_posts(array(
                    'post_type' => 'game',
                    'post__in' => $linked_games,
                    'post_status' => 'publish',
                    'numberposts' => -1,
                    'orderby' => 'title',
                    'order' => 'ASC'
                ));
                
                if (!empty($games)) {
                    $output = '<ul class="games-list">';
                    foreach ($games as $game) {
                        $output .= '<li><a href="' . esc_url(get_permalink($game->ID)) . '">' . esc_html($game->post_title) . '</a></li>';
                    }
                    $output .= '</ul>';
                } else {
                    $output = '<span class="no-data-badge">' . esc_html__('No games found', 'casino-theme') . '</span>';
                }
            } else {
                $output = '<span class="no-data-badge">' . esc_html__('No games linked', 'casino-theme') . '</span>';
            }
            break;
            
        default:
            $output = '<span class="no-data-badge">' . esc_html__('N/A', 'casino-theme') . '</span>';
            break;
    }
    
    wp_send_json_success($output);
}
add_action('wp_ajax_casino_theme_template2_content', 'casino_theme_ajax_template2_content');
add_action('wp_ajax_nopriv_casino_theme_template2_content', 'casino_theme_ajax_template2_content');

/**
 * Enqueue AJAX scripts for Template 2
 */
function casino_theme_enqueue_template2_scripts() {
    wp_enqueue_script('casino-theme-template2', get_template_directory_uri() . '/assets/js/template2-ajax.js', array('jquery'), '1.0.0', true);
    wp_localize_script('casino-theme-template2', 'casino_theme_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('casino_theme_ajax_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'casino_theme_enqueue_template2_scripts');