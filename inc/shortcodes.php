<?php
/**
 * Custom shortcodes
 *
 * @package Casino_Theme
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Casinos table shortcode
 *
 * @param array $atts Shortcode attributes
 * @return string
 */
function casino_theme_casinos_table_shortcode($atts) {
    // Normalize attribute keys
    $atts = array_change_key_case((array) $atts, CASE_LOWER);
    
    // Merge default attributes with user attributes
    $atts = shortcode_atts(
        array(
            'title' => '',
            'template' => '1',
            'second_col' => 'loyalty',
            'limit' => 10
        ),
        $atts,
        'casinos_table'
    );
    
    // Sanitize attributes
    $atts['title'] = sanitize_text_field($atts['title']);
    $atts['template'] = in_array($atts['template'], array('1', '2')) ? $atts['template'] : '1';
    $atts['second_col'] = in_array($atts['second_col'], array('loyalty', 'live_casino', 'mobile_casino')) ? $atts['second_col'] : 'loyalty';
    $atts['limit'] = intval($atts['limit']);
    
    // Set default title if no title provided
    if (empty($atts['title'])) {
        $atts['title'] = 'Best Casino';
    }
    
    // Load the appropriate template
    ob_start();
    
    if ($atts['template'] === '2') {
        get_template_part('template-parts/casino-table-template2', null, $atts);
    } else {
        get_template_part('template-parts/casino-table-template1', null, $atts);
    }
    
    return ob_get_clean();
}
add_shortcode('casinos_table', 'casino_theme_casinos_table_shortcode');

/**
 * Enhanced casino search shortcode
 *
 * @param array $atts Shortcode attributes
 * @return string
 */
function casino_theme_casino_search_shortcode($atts) {
    // Normalize attribute keys
    $atts = array_change_key_case((array) $atts, CASE_LOWER);
    
    // Merge default attributes with user attributes
    $atts = shortcode_atts(
        array(
            'placeholder' => __('Search casinos...', 'casino-theme'),
            'button_text' => __('Search', 'casino-theme'),
            'show_filters' => 'true',
            'results_per_page' => 12
        ),
        $atts,
        'casino_search'
    );
    
    // Sanitize attributes
    $atts['placeholder'] = sanitize_text_field($atts['placeholder']);
    $atts['button_text'] = sanitize_text_field($atts['button_text']);
    $atts['show_filters'] = filter_var($atts['show_filters'], FILTER_VALIDATE_BOOLEAN);
    $atts['results_per_page'] = intval($atts['results_per_page']);
    
    ob_start();
    ?>
    <div class="casino-search-wrapper">
        <form class="casino-search-form" method="get" action="<?php echo esc_url(home_url('/')); ?>">
            <div class="row g-3">
                <div class="col-md-6">
                    <input type="text" 
                           name="s" 
                           class="form-control" 
                           placeholder="<?php echo esc_attr($atts['placeholder']); ?>"
                           value="<?php echo esc_attr(get_search_query()); ?>"
                           aria-label="<?php echo esc_attr($atts['placeholder']); ?>">
                    <input type="hidden" name="post_type" value="casino">
                </div>
                
                <?php if ($atts['show_filters']) : ?>
                    <div class="col-md-3">
                        <select name="casino_category" class="form-select">
                            <option value=""><?php esc_html_e('All Categories', 'casino-theme'); ?></option>
                            <?php
                            $categories = get_terms(array(
                                'taxonomy' => 'casino_category',
                                'hide_empty' => true,
                            ));
                            
                            foreach ($categories as $category) {
                                $selected = (isset($_GET['casino_category']) && $_GET['casino_category'] == $category->slug) ? 'selected' : '';
                                echo '<option value="' . esc_attr($category->slug) . '" ' . $selected . '>' . esc_html($category->name) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <select name="rating_filter" class="form-select">
                            <option value=""><?php esc_html_e('All Ratings', 'casino-theme'); ?></option>
                            <option value="9-10" <?php selected(isset($_GET['rating_filter']) ? $_GET['rating_filter'] : '', '9-10'); ?>><?php esc_html_e('9-10 (Excellent)', 'casino-theme'); ?></option>
                            <option value="7-8" <?php selected(isset($_GET['rating_filter']) ? $_GET['rating_filter'] : '', '7-8'); ?>><?php esc_html_e('7-8 (Good)', 'casino-theme'); ?></option>
                            <option value="5-6" <?php selected(isset($_GET['rating_filter']) ? $_GET['rating_filter'] : '', '5-6'); ?>><?php esc_html_e('5-6 (Average)', 'casino-theme'); ?></option>
                            <option value="1-4" <?php selected(isset($_GET['rating_filter']) ? $_GET['rating_filter'] : '', '1-4'); ?>><?php esc_html_e('1-4 (Poor)', 'casino-theme'); ?></option>
                        </select>
                    </div>
                <?php endif; ?>
                
                <div class="col-md-<?php echo $atts['show_filters'] ? '12' : '6'; ?>">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> <?php echo esc_html($atts['button_text']); ?>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('casino_search', 'casino_theme_casino_search_shortcode');