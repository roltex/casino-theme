<?php
/**
 * Template part for displaying casino table template 2
 *
 * @package Casino_Theme
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Get parameters
$title = isset($args['title']) ? $args['title'] : 'Best Casino';
$template = isset($args['template']) ? $args['template'] : '2';
$second_col = isset($args['second_col']) ? $args['second_col'] : 'loyalty';
$limit = isset($args['limit']) ? intval($args['limit']) : 10;

// Build query arguments - simplified without filters
$query_args = array(
    'post_type' => 'casino',
    'numberposts' => $limit,
    'post_status' => 'publish',
    'orderby' => 'meta_value_num',
    'meta_key' => '_casino_composite_rating',
    'order' => 'DESC'
);

// Get casinos
$casinos = get_posts($query_args);

if (!empty($casinos)) :
    ?>
    <div class="casino-table-wrapper template-2">
       
        <!-- Table Header -->
        <div class="table-header glass-card p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="table-title text-gradient mb-0"><?php echo esc_html($title); ?></h2>
                <div class="column-type-wrapper">
                    <label for="column-type-select" class="column-type-label">
                        <i class="fas fa-info-circle"></i>
                        <?php esc_html_e('Pick Info:', 'casino-theme'); ?>
                    </label>
                    <select id="column-type-select" class="form-select glass-select column-type-select">
                        <option value="loyalty" <?php selected($second_col, 'loyalty'); ?>><?php esc_html_e('Loyalty Program', 'casino-theme'); ?></option>
                        <option value="live_casino" <?php selected($second_col, 'live_casino'); ?>><?php esc_html_e('Live Casino', 'casino-theme'); ?></option>
                        <option value="mobile_casino" <?php selected($second_col, 'mobile_casino'); ?>><?php esc_html_e('Mobile Casino', 'casino-theme'); ?></option>
                        <option value="year_established" <?php selected($second_col, 'year_established'); ?>><?php esc_html_e('Year of Establishment', 'casino-theme'); ?></option>
                        <option value="contact_email" <?php selected($second_col, 'contact_email'); ?>><?php esc_html_e('Contact Email', 'casino-theme'); ?></option>
                        <option value="games" <?php selected($second_col, 'games'); ?>><?php esc_html_e('Games', 'casino-theme'); ?></option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table casino-table">
                <thead>
                    <tr>
                        <th class="glass-header">
                            <i class="fas fa-dice"></i>
                            <?php esc_html_e('Casino', 'casino-theme'); ?>
                        </th>
                        <th class="glass-header middle-column-header">
                            <i class="fas fa-star"></i>
                            <?php esc_html_e('Loyalty Program', 'casino-theme'); ?>
                        </th>
                        <th class="glass-header">
                            <i class="fas fa-eye"></i>
                            <?php esc_html_e('Review', 'casino-theme'); ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($casinos as $casino) : 
                        // Get casino meta data using optimized helper function
                        $casino_meta = casino_theme_get_casino_meta($casino->ID);
                        $composite_rating = $casino_meta['_casino_composite_rating'];
                        $loyalty_program = $casino_meta['_casino_loyalty_program'];
                        $live_casino = $casino_meta['_casino_live_casino'];
                        $mobile_casino = $casino_meta['_casino_mobile_casino'];
                        $year_established = $casino_meta['_casino_year_established'];
                        ?>
                        <tr class="casino-row" data-casino-id="<?php echo esc_attr($casino->ID); ?>">
                            <td>
                                <div class="casino-info-compact">
                                    <div class="casino-logo-wrapper">
                                        <?php if (has_post_thumbnail($casino->ID)) : ?>
                                            <?php echo get_the_post_thumbnail($casino->ID, 'thumbnail', array('class' => 'casino-logo')); ?>
                                        <?php else : ?>
                                            <div class="casino-logo-placeholder">
                                                <i class="fas fa-dice"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="casino-details-compact">
                                        <div class="casino-name">
                                            <a href="<?php echo esc_url(get_permalink($casino->ID)); ?>" class="casino-title-link">
                                                <?php echo esc_html($casino->post_title); ?>
                                            </a>
                                        </div>
                                        <?php if ($composite_rating) : ?>
                                            <div class="casino-rating-compact">
                                                <?php echo casino_theme_display_rating_stars($composite_rating); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td class="middle-column-cell">
                                <!-- Dynamic content will be loaded via AJAX -->
                                <div class="loading-spinner">
                                    <i class="fas fa-spinner fa-spin"></i>
                                </div>
                            </td>
                            <td>
                                <a href="<?php echo esc_url(get_permalink($casino->ID)); ?>" class="glass-btn glass-btn-primary">
                                    <i class="fas fa-arrow-right"></i>
                                    <?php esc_html_e('Review', 'casino-theme'); ?>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        // Trigger event for AJAX initialization
        $(document).trigger('casino_theme_template2_loaded');
    });
    </script>
    <?php
endif;
?>