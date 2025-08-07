<?php
/**
 * The template for displaying all single game posts
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
                        
                        // Get linked casinos
                        $linked_casinos = casino_theme_get_linked_casinos(get_the_ID());
                        
                        // Get game meta data using optimized helper function
                        $game_meta = casino_theme_get_game_meta(get_the_ID());
                        $game_type = $game_meta['_game_type'];
                        $game_provider = $game_meta['_game_provider'];
                        $game_rating = $game_meta['_game_rating'];
                        ?>
                        
                        <article id="post-<?php the_ID(); ?>" <?php post_class('game-single'); ?>>
                            <!-- Game Header -->
                            <div class="game-header glass-card">
                                <div class="game-header-content">
                                    <div class="game-logo-section">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <div class="game-logo-wrapper">
                                                <?php the_post_thumbnail('large', array('class' => 'game-logo')); ?>
                                            </div>
                                        <?php else : ?>
                                            <div class="game-logo-placeholder">
                                                <i class="fas fa-gamepad"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="game-info-section">
                                        <h1 class="game-title"><?php the_title(); ?></h1>
                                        
                                        <?php if ($game_rating) : ?>
                                            <div class="game-rating">
                                                <div class="rating-stars">
                                                    <?php echo casino_theme_display_rating_stars($game_rating); ?>
                                                </div>
                                                <span class="rating-score"><?php echo number_format($game_rating, 1); ?>/10</span>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <div class="game-meta">
                                            <?php if ($game_type) : ?>
                                                <span class="meta-item">
                                                    <i class="fas fa-tag"></i>
                                                    <?php echo esc_html($game_type); ?>
                                                </span>
                                            <?php endif; ?>
                                            
                                            <?php if ($game_provider) : ?>
                                                <span class="meta-item">
                                                    <i class="fas fa-building"></i>
                                                    <?php echo esc_html($game_provider); ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Game Content -->
                            <div class="game-content glass-card">
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

                            <!-- Linked Casinos Section -->
                            <?php if (!empty($linked_casinos)) : ?>
                                <div class="linked-casinos-section glass-card">
                                    <h3 class="section-title">
                                        <i class="fas fa-dice me-2"></i>
                                        <?php esc_html_e('Available at Casinos', 'casino-theme'); ?>
                                    </h3>
                                    <div class="casinos-grid">
                                        <?php foreach ($linked_casinos as $casino) : ?>
                                            <div class="casino-card-wrapper">
                                                <?php
                                                $args = array(
                                                    'casino_id' => $casino->ID,
                                                    'card_type' => 'game-single',
                                                    'show_excerpt' => false,
                                                    'show_features' => true,
                                                    'show_details' => false,
                                                    'show_rating' => true
                                                );
                                                casino_theme_display_casino_card($casino->ID, $args);
                                                ?>
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