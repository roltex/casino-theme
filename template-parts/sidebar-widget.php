<?php
/**
 * Template part for displaying the custom sidebar widget
 *
 * @package Casino_Theme
 */

// Get popular casinos
$popular_casinos = casino_theme_get_popular_casinos(3);

// Get recent casinos
$recent_casinos = casino_theme_get_recent_casinos(3);
?>

<div class="casino-sidebar-widget">
    <ul class="nav nav-tabs" id="casinoWidgetTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="popular-tab" data-bs-toggle="tab" data-bs-target="#popular" type="button" role="tab" aria-controls="popular" aria-selected="true">
                <?php esc_html_e('Popular', 'casino-theme'); ?>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="recent-tab" data-bs-toggle="tab" data-bs-target="#recent" type="button" role="tab" aria-controls="recent" aria-selected="false">
                <?php esc_html_e('Recent', 'casino-theme'); ?>
            </button>
        </li>
    </ul>
    
    <div class="tab-content" id="casinoWidgetTabsContent">
        <div class="tab-pane fade show active" id="popular" role="tabpanel" aria-labelledby="popular-tab">
            <?php if (!empty($popular_casinos)) : ?>
                <div class="casino-list">
                    <?php foreach ($popular_casinos as $casino) : 
                        $rating = casino_theme_get_casino_composite_rating($casino->ID);
                        ?>
                        <div class="casino-item">
                            <?php if (has_post_thumbnail($casino->ID)) : ?>
                                <div class="casino-thumbnail">
                                    <?php echo get_the_post_thumbnail($casino->ID, 'thumbnail', array('class' => 'casino-thumb')); ?>
                                </div>
                            <?php endif; ?>
                            <div class="casino-content">
                                <h4 class="casino-title">
                                    <a href="<?php echo esc_url(get_permalink($casino->ID)); ?>">
                                        <?php echo esc_html($casino->post_title); ?>
                                    </a>
                                </h4>
                                <?php if ($rating) : ?>
                                    <div class="casino-rating">
                                        <?php echo casino_theme_display_rating_stars($rating); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <p><?php esc_html_e('No casinos found.', 'casino-theme'); ?></p>
            <?php endif; ?>
        </div>
        
        <div class="tab-pane fade" id="recent" role="tabpanel" aria-labelledby="recent-tab">
            <?php if (!empty($recent_casinos)) : ?>
                <div class="casino-list">
                    <?php foreach ($recent_casinos as $casino) : 
                        $rating = casino_theme_get_casino_composite_rating($casino->ID);
                        ?>
                        <div class="casino-item">
                            <?php if (has_post_thumbnail($casino->ID)) : ?>
                                <div class="casino-thumbnail">
                                    <?php echo get_the_post_thumbnail($casino->ID, 'thumbnail', array('class' => 'casino-thumb')); ?>
                                </div>
                            <?php endif; ?>
                            <div class="casino-content">
                                <h4 class="casino-title">
                                    <a href="<?php echo esc_url(get_permalink($casino->ID)); ?>">
                                        <?php echo esc_html($casino->post_title); ?>
                                    </a>
                                </h4>
                                <div class="casino-date">
                                    <?php echo get_the_date(get_option('date_format'), $casino->ID); ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <p><?php esc_html_e('No casinos found.', 'casino-theme'); ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>