<?php
/**
 * Casino Card Template
 *
 * This template is used to display casino cards consistently across the theme.
 *
 * @package Casino_Theme
 *
 * @param int $casino_id Casino post ID
 * @param string $card_type Type of card (archive, front-page, sidebar, etc.)
 * @param array $args Additional arguments for customization
 */

// Get casino data
$casino_id = isset($args['casino_id']) ? $args['casino_id'] : get_the_ID();
$card_type = isset($args['card_type']) ? $args['card_type'] : 'default';
$show_excerpt = isset($args['show_excerpt']) ? $args['show_excerpt'] : true;
$show_features = isset($args['show_features']) ? $args['show_features'] : true;
$show_details = isset($args['show_details']) ? $args['show_details'] : true;
$show_rating = isset($args['show_rating']) ? $args['show_rating'] : true;
$excerpt_length = isset($args['excerpt_length']) ? $args['excerpt_length'] : 15;

// Get casino meta data using optimized helper function
$casino_meta = casino_theme_get_casino_meta($casino_id);
$composite_rating = $casino_meta['_casino_composite_rating'];
$loyalty_program = $casino_meta['_casino_loyalty_program'];
$live_casino = $casino_meta['_casino_live_casino'];
$mobile_casino = $casino_meta['_casino_mobile_casino'];
$official_site = $casino_meta['_casino_official_site'];
$year_established = $casino_meta['_casino_year_established'];
$contact_email = $casino_meta['_casino_contact_email'];

// Get casino post object
$casino = get_post($casino_id);
?>

<article id="casino-<?php echo esc_attr($casino_id); ?>" class="casino-card-item glass-card <?php echo esc_attr($card_type); ?>-card">
    <!-- Full Width Casino Image -->
    <?php if (has_post_thumbnail($casino_id)) : ?>
        <div class="casino-card-image">
            <?php echo get_the_post_thumbnail($casino_id, 'medium', array('class' => 'casino-card-img')); ?>
        </div>
    <?php endif; ?>

    <div class="casino-card-content d-flex flex-column">
        <!-- Casino Header -->
        <div class="casino-card-header d-flex align-items-start gap-3">
            <!-- Info Section -->
            <div class="casino-info-section flex-grow-1">
                <h3 class="casino-title mb-1">
                    <a href="<?php echo esc_url(get_permalink($casino_id)); ?>" class="casino-title-link">
                        <?php echo esc_html($casino->post_title); ?>
                    </a>
                </h3>

                <?php if ($show_rating && $composite_rating) : ?>
                    <div class="casino-rating-section mb-2">
                        <?php echo casino_theme_display_rating_stars($composite_rating); ?>
                    </div>
                <?php endif; ?>

                <?php if ($show_features && ($loyalty_program || $live_casino || $mobile_casino)) : ?>
                    <div class="casino-features">
                        <?php if ($loyalty_program) : ?>
                            <span class="feature-badge loyalty" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php esc_attr_e('Loyalty Program', 'casino-theme'); ?>">
                                <i class="fas fa-star"></i>
                            </span>
                        <?php endif; ?>
                        <?php if ($live_casino) : ?>
                            <span class="feature-badge live" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php esc_attr_e('Live Casino', 'casino-theme'); ?>">
                                <i class="fas fa-video"></i>
                            </span>
                        <?php endif; ?>
                        <?php if ($mobile_casino) : ?>
                            <span class="feature-badge mobile" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php esc_attr_e('Mobile Casino', 'casino-theme'); ?>">
                                <i class="fas fa-mobile-alt"></i>
                            </span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Casino Content -->
        <?php if ($show_excerpt || $show_details) : ?>
            <div class="casino-card-body">
                <?php if ($show_excerpt) : ?>
                    <div class="casino-excerpt">
                        <p class="mb-1"><?php echo wp_trim_words($casino->post_content, 10); ?></p>
                    </div>
                <?php endif; ?>

                <?php if ($show_details && ($year_established || $official_site)) : ?>
                    <div class="casino-details-compact">
                        <?php if ($year_established) : ?>
                            <div class="casino-detail-compact">
                                <span class="casino-detail-label">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    <?php esc_html_e('Est.', 'casino-theme'); ?>
                                </span>
                                <span class="casino-detail-value"><?php echo esc_html($year_established); ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if ($official_site) : ?>
                            <div class="casino-detail-compact">
                                <span class="casino-detail-label">
                                    <i class="fas fa-globe me-1"></i>
                                    <?php esc_html_e('Site', 'casino-theme'); ?>
                                </span>
                                <a href="<?php echo esc_url($official_site); ?>" target="_blank" rel="noopener noreferrer" class="casino-detail-value">
                                    <?php esc_html_e('Visit', 'casino-theme'); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Casino Footer -->
        <div class="casino-card-footer">
            <a href="<?php echo esc_url(get_permalink($casino_id)); ?>" class="glass-btn glass-btn-primary w-100">
                <i class="fas fa-arrow-right me-1"></i>
                <?php esc_html_e('Read Review', 'casino-theme'); ?>
            </a>
        </div>
    </div>
</article> 