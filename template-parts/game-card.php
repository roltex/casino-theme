<?php
/**
 * Game Card Template
 *
 * This template is used to display game cards consistently across the theme.
 *
 * @package Casino_Theme
 *
 * @param int $game_id Game post ID
 * @param string $card_type Type of card (archive, front-page, sidebar, etc.)
 * @param array $args Additional arguments for customization
 */

// Get game data
$game_id = isset($args['game_id']) ? $args['game_id'] : get_the_ID();
$card_type = isset($args['card_type']) ? $args['card_type'] : 'default';
$show_excerpt = isset($args['show_excerpt']) ? $args['show_excerpt'] : true;
$show_features = isset($args['show_features']) ? $args['show_features'] : true;
$show_details = isset($args['show_details']) ? $args['show_details'] : true;
$show_rating = isset($args['show_rating']) ? $args['show_rating'] : true;
$excerpt_length = isset($args['excerpt_length']) ? $args['excerpt_length'] : 15;

// Get game meta data using optimized helper function
$game_meta = casino_theme_get_game_meta($game_id);
$game_type = $game_meta['_game_type'];
$game_provider = $game_meta['_game_provider'];
$game_rating = $game_meta['_game_rating'];
$linked_casinos = $game_meta['_game_linked_casinos'];

// Get game post object
$game = get_post($game_id);
?>

<article id="game-<?php echo esc_attr($game_id); ?>" class="game-card-item glass-card <?php echo esc_attr($card_type); ?>-card">
    <!-- Full Width Game Image -->
    <?php if (has_post_thumbnail($game_id)) : ?>
        <div class="game-card-image">
            <?php echo get_the_post_thumbnail($game_id, 'medium', array('class' => 'game-card-img')); ?>
        </div>
    <?php endif; ?>

    <div class="game-card-content d-flex flex-column">
        <!-- Game Header -->
        <div class="game-card-header d-flex align-items-start gap-3">
            <!-- Info Section -->
            <div class="game-info-section flex-grow-1">
                <h3 class="game-title mb-1">
                    <a href="<?php echo esc_url(get_permalink($game_id)); ?>" class="game-title-link">
                        <?php echo esc_html($game->post_title); ?>
                    </a>
                </h3>

                <?php if ($show_rating && $game_rating) : ?>
                    <div class="game-rating-section mb-2">
                        <?php echo casino_theme_display_rating_stars($game_rating); ?>
                    </div>
                <?php endif; ?>

                <?php if ($show_features && ($game_type || $game_provider)) : ?>
                    <div class="game-features">
                        <?php if ($game_type) : ?>
                            <span class="feature-badge game-type" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php esc_attr_e('Game Type', 'casino-theme'); ?>">
                                <i class="fas fa-tag"></i>
                            </span>
                        <?php endif; ?>
                        <?php if ($game_provider) : ?>
                            <span class="feature-badge game-provider" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php esc_attr_e('Game Provider', 'casino-theme'); ?>">
                                <i class="fas fa-building"></i>
                            </span>
                        <?php endif; ?>
                        <?php if (!empty($linked_casinos) && is_array($linked_casinos)) : ?>
                            <span class="feature-badge game-available" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php esc_attr_e('Available at Casinos', 'casino-theme'); ?>">
                                <i class="fas fa-dice"></i>
                            </span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Game Content -->
        <?php if ($show_excerpt || $show_details) : ?>
            <div class="game-card-body">
                <?php if ($show_excerpt) : ?>
                    <div class="game-excerpt">
                        <p class="mb-1"><?php echo wp_trim_words($game->post_content, $excerpt_length); ?></p>
                    </div>
                <?php endif; ?>

                <?php if ($show_details && ($game_type || $game_provider || !empty($linked_casinos))) : ?>
                    <div class="game-details-compact">
                        <?php if ($game_type) : ?>
                            <div class="game-detail-compact">
                                <span class="game-detail-label">
                                    <i class="fas fa-tag me-1"></i>
                                    <?php esc_html_e('Type', 'casino-theme'); ?>
                                </span>
                                <span class="game-detail-value"><?php echo esc_html($game_type); ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if ($game_provider) : ?>
                            <div class="game-detail-compact">
                                <span class="game-detail-label">
                                    <i class="fas fa-building me-1"></i>
                                    <?php esc_html_e('Provider', 'casino-theme'); ?>
                                </span>
                                <span class="game-detail-value"><?php echo esc_html($game_provider); ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($linked_casinos) && is_array($linked_casinos)) : ?>
                            <div class="game-detail-compact">
                                <span class="game-detail-label">
                                    <i class="fas fa-dice me-1"></i>
                                    <?php esc_html_e('Casinos', 'casino-theme'); ?>
                                </span>
                                <span class="game-detail-value"><?php echo count($linked_casinos); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Game Footer -->
        <div class="game-card-footer">
            <a href="<?php echo esc_url(get_permalink($game_id)); ?>" class="glass-btn glass-btn-primary w-100">
                <i class="fas fa-arrow-right me-1"></i>
                <?php esc_html_e('Read Review', 'casino-theme'); ?>
            </a>
        </div>
    </div>
</article> 