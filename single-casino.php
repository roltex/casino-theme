<?php
/**
 * The template for displaying all single casino posts
 *
 * @package Casino_Theme
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <?php
                    while (have_posts()) :
                        the_post();
                        
                        // Get casino meta data using optimized helper function
                        $casino_meta = casino_theme_get_casino_meta(get_the_ID());
                        $official_site = $casino_meta['_casino_official_site'];
                        $year_established = $casino_meta['_casino_year_established'];
                        $contact_email = $casino_meta['_casino_contact_email'];
                        $loyalty_program = $casino_meta['_casino_loyalty_program'];
                        $live_casino = $casino_meta['_casino_live_casino'];
                        $mobile_casino = $casino_meta['_casino_mobile_casino'];
                        $composite_rating = $casino_meta['_casino_composite_rating'];
                        
                        // Get linked games
                        $linked_games = casino_theme_get_linked_games(get_the_ID());
                        ?>
                        
                        <article id="post-<?php the_ID(); ?>" <?php post_class('casino-single'); ?>>
                            <!-- Casino Hero Section -->
                            <div class="casino-hero glass-card">
                                <div class="casino-hero-content">
                                    <div class="casino-hero-left">
                                        <div class="casino-logo-section">
                                            <?php if (has_post_thumbnail()) : ?>
                                                    <?php the_post_thumbnail('large', array('class' => 'casino-logo')); ?>
                                            <?php else : ?>
                                                <div class="casino-logo-placeholder glass-card-light">
                                                    <i class="fas fa-dice"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <div class="casino-info-section">
                                            <h1 class="casino-title"><?php the_title(); ?></h1>
                                            
                                            <?php if ($composite_rating) : ?>
                                                <div class="casino-rating-section">
                                                    <div class="rating-stars">
                                                        <?php echo casino_theme_display_rating_stars($composite_rating); ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <div class="casino-features">
                                                <?php if ($loyalty_program || $live_casino || $mobile_casino) : ?>
                                                    <?php echo casino_theme_get_casino_features(get_the_ID(), 'default', true); ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="casino-hero-right">
                                        <?php if ($official_site) : ?>
                                            <div class="casino-actions">
                                                <a href="<?php echo esc_url($official_site); ?>" target="_blank" rel="noopener noreferrer" class="glass-btn glass-btn-primary">
                                                    <i class="fas fa-external-link-alt me-2"></i>
                                                    <?php esc_html_e('Visit Official Site', 'casino-theme'); ?>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if ($year_established || $contact_email) : ?>
                                            <div class="casino-meta">
                                                <?php if ($year_established) : ?>
                                                    <div class="meta-item">
                                                        <i class="fas fa-calendar-alt"></i>
                                                        <span><?php esc_html_e('Established:', 'casino-theme'); ?> <?php echo esc_html($year_established); ?></span>
                                                    </div>
                                                <?php endif; ?>
                                                
                                                <?php if ($contact_email) : ?>
                                                    <div class="meta-item">
                                                        <i class="fas fa-envelope"></i>
                                                        <a href="mailto:<?php echo esc_attr($contact_email); ?>" class="contact-email-link">
                                                            <?php echo esc_html($contact_email); ?>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Casino Content -->
                            <div class="casino-content glass-card">
                                <div class="entry-content">
                                    <?php
                                    the_content();

                                    wp_link_pages(
                                        array(
                                            'before' => '<div class="page-links">' . esc_html__('Pages:', 'casino-theme'),
                                            'after'  => '</div>',
                                        )
                                    );
                                    ?>
                                </div>
                            </div>

                            <!-- Linked Games Section -->
                            <?php if (!empty($linked_games)) : ?>
                                <div class="linked-games-section glass-card">
                                    <h3 class="section-title">
                                        <i class="fas fa-gamepad me-2"></i>
                                        <?php esc_html_e('Available Games', 'casino-theme'); ?>
                                    </h3>
                                    <div class="games-grid">
                                        <?php foreach ($linked_games as $game) : ?>
                                            <div class="game-item glass-card-light">
                                                <a href="<?php echo esc_url(get_permalink($game->ID)); ?>" class="game-link">
                                                    <?php if (has_post_thumbnail($game->ID)) : ?>
                                                        <div class="game-image">
                                                            <?php echo get_the_post_thumbnail($game->ID, 'thumbnail', array('class' => 'game-img')); ?>
                                                        </div>
                                                    <?php else : ?>
                                                        <div class="game-image-placeholder">
                                                            <i class="fas fa-dice"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="game-info">
                                                        <h4 class="game-title"><?php echo esc_html($game->post_title); ?></h4>
                                                    </div>
                                                </a>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </article>
                    <?php endwhile; ?>
                </div>
                <div class="col-lg-4">
                    <?php get_sidebar(); ?>
                </div>
            </div>
        </div>
    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
?>