<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
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
                    <?php if (have_posts()) : ?>
                        <header class="page-header glass-card p-4 mb-4">
                            <?php
                            // Custom archive title without "Archives:" prefix
                            if (is_post_type_archive('casino')) {
                                echo '<h1 class="page-title text-gradient">' . esc_html__('Casinos', 'casino-theme') . '</h1>';
                            } elseif (is_post_type_archive('game')) {
                                echo '<h1 class="page-title text-gradient">' . esc_html__('Games', 'casino-theme') . '</h1>';
                            } elseif (is_tax('casino_category') || is_tax('casino_tag')) {
                                echo '<h1 class="page-title text-gradient">' . single_term_title('', false) . '</h1>';
                            } elseif (is_tax('game_category') || is_tax('game_tag')) {
                                echo '<h1 class="page-title text-gradient">' . single_term_title('', false) . '</h1>';
                            } elseif (is_category()) {
                                echo '<h1 class="page-title text-gradient">' . single_cat_title('', false) . '</h1>';
                            } elseif (is_tag()) {
                                echo '<h1 class="page-title text-gradient">' . single_tag_title('', false) . '</h1>';
                            } elseif (is_author()) {
                                echo '<h1 class="page-title text-gradient">' . get_the_author() . '</h1>';
                            } elseif (is_date()) {
                                if (is_year()) {
                                    echo '<h1 class="page-title text-gradient">' . get_the_date('Y') . '</h1>';
                                } elseif (is_month()) {
                                    echo '<h1 class="page-title text-gradient">' . get_the_date('F Y') . '</h1>';
                                } else {
                                    echo '<h1 class="page-title text-gradient">' . get_the_date() . '</h1>';
                                }
                            } else {
                                echo '<h1 class="page-title text-gradient">' . esc_html__('Archive', 'casino-theme') . '</h1>';
                            }
                            
                            the_archive_description('<div class="archive-description">', '</div>');
                            
                            // Add post count for casino and game archives
                            if (is_post_type_archive('casino') || is_tax('casino_category') || is_tax('casino_tag')) {
                                echo '<div class="archive-stats mt-2">';
                                echo '<span class="archive-count text-muted">';
                                echo '<i class="fas fa-dice me-2"></i>';
                                printf(esc_html(_n('%s Casino', '%s Casinos', $wp_query->found_posts, 'casino-theme')), number_format_i18n($wp_query->found_posts));
                                echo '</span>';
                                echo '</div>';
                            } elseif (is_post_type_archive('game') || is_tax('game_category') || is_tax('game_tag')) {
                                echo '<div class="archive-stats mt-2">';
                                echo '<span class="archive-count text-muted">';
                                echo '<i class="fas fa-gamepad me-2"></i>';
                                printf(esc_html(_n('%s Game', '%s Games', $wp_query->found_posts, 'casino-theme')), number_format_i18n($wp_query->found_posts));
                                echo '</span>';
                                echo '</div>';
                            }
                            ?>
                        </header>

                        <div class="archive-content">
                            <div class="row">
                                <?php
                                /* Start the Loop */
                                while (have_posts()) :
                                    the_post();
                                    ?>
                                    <div class="col-md-6 col-lg-4 mb-4">
                                        <?php
                                        // Use specific templates for casino and game post types
                                        if (get_post_type() === 'casino') {
                                            // Use casino card template for casino posts
                                            get_template_part('template-parts/casino-card', null, array(
                                                'casino_id' => get_the_ID(),
                                                'card_type' => 'archive',
                                                'show_excerpt' => true,
                                                'show_features' => true,
                                                'show_details' => true,
                                                'show_rating' => true,
                                                'excerpt_length' => 20
                                            ));
                                        } elseif (get_post_type() === 'game') {
                                            // Use game card template for game posts
                                            get_template_part('template-parts/game-card', null, array(
                                                'game_id' => get_the_ID(),
                                                'card_type' => 'archive',
                                                'show_excerpt' => true,
                                                'show_features' => true,
                                                'show_details' => true,
                                                'show_rating' => true,
                                                'excerpt_length' => 20
                                            ));
                                        } else {
                                            // Default content template for other post types
                                            get_template_part('template-parts/content', get_post_type());
                                        }
                                        ?>
                                    </div>
                                    <?php
                                endwhile;
                                ?>
                            </div>

                            <!-- Pagination -->
                            <div class="pagination-wrapper mt-4">
                                <?php
                                the_posts_pagination(array(
                                    'mid_size'  => 2,
                                    'prev_text' => '<i class="fas fa-chevron-left"></i> ' . __('Previous', 'casino-theme'),
                                    'next_text' => __('Next', 'casino-theme') . ' <i class="fas fa-chevron-right"></i>',
                                    'class'     => 'pagination justify-content-center',
                                ));
                                ?>
                            </div>

                        </div>

                    <?php else : ?>
                        <div class="no-posts-found glass-card p-5 text-center">
                            <i class="fas fa-search fa-3x text-muted mb-3"></i>
                            <h2 class="text-gradient">
                                <?php 
                                if (is_post_type_archive('casino') || is_tax('casino_category') || is_tax('casino_tag')) {
                                    esc_html_e('No Casinos Found', 'casino-theme');
                                } elseif (is_post_type_archive('game') || is_tax('game_category') || is_tax('game_tag')) {
                                    esc_html_e('No Games Found', 'casino-theme');
                                } else {
                                    esc_html_e('No posts found', 'casino-theme');
                                }
                                ?>
                            </h2>
                            <p class="text-muted">
                                <?php 
                                if (is_post_type_archive('casino') || is_tax('casino_category') || is_tax('casino_tag')) {
                                    esc_html_e('Sorry, no casinos matched your criteria. Please try a different search or browse our casino categories.', 'casino-theme');
                                } elseif (is_post_type_archive('game') || is_tax('game_category') || is_tax('game_tag')) {
                                    esc_html_e('Sorry, no games matched your criteria. Please try a different search or browse our game categories.', 'casino-theme');
                                } else {
                                    esc_html_e('Sorry, no posts matched your criteria.', 'casino-theme');
                                }
                                ?>
                            </p>
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="glass-btn glass-btn-primary">
                                <i class="fas fa-home me-2"></i>
                                <?php esc_html_e('Back to Home', 'casino-theme'); ?>
                            </a>
                        </div>
                    <?php endif; ?>
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