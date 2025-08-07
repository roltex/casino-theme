<?php
/**
 * The front page template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @package Casino_Theme
 */

get_header();
?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <header class="page-header glass-card p-4 mb-4">
                            <h1 class="page-title text-gradient"><?php esc_html_e('All Casinos', 'casino-theme'); ?></h1>
                            <p class="page-description"><?php esc_html_e('Discover the best online casinos with our comprehensive reviews and ratings.', 'casino-theme'); ?></p>
                        </header>
                        
                        <!-- All Casinos as Cards -->
                        <div class="casinos-cards-section">
                            <?php
                            // Get all casinos
                            $casinos = get_posts(array(
                                'post_type' => 'casino',
                                'numberposts' => -1,
                                'post_status' => 'publish',
                                'orderby' => 'title',
                                'order' => 'ASC'
                            ));
                            
                            if (!empty($casinos)) :
                                ?>
                                <div class="row">
                                    <?php foreach ($casinos as $casino) : ?>
                                        <div class="col-md-6 col-lg-4 mb-4">
                                            <?php
                                            // Check if the function exists before calling it
                                            if (function_exists('casino_theme_display_casino_card')) {
                                                // Display casino card using the reusable template
                                                casino_theme_display_casino_card($casino->ID, array(
                                                    'card_type' => 'front-page',
                                                    'show_excerpt' => true,
                                                    'show_features' => true,
                                                    'show_details' => true,
                                                    'show_rating' => true,
                                                    'excerpt_length' => 20
                                                ));
                                            } else {
                                                // Fallback to direct template inclusion
                                                get_template_part('template-parts/casino-card', null, array(
                                                    'casino_id' => $casino->ID,
                                                    'card_type' => 'front-page',
                                                    'show_excerpt' => true,
                                                    'show_features' => true,
                                                    'show_details' => true,
                                                    'show_rating' => true,
                                                    'excerpt_length' => 20
                                                ));
                                            }
                                            ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php
                            else :
                                ?>
                                <div class="text-center">
                                    <div class="glass-card p-5">
                                        <i class="fas fa-dice fa-3x text-muted mb-3"></i>
                                        <p class="text-muted"><?php esc_html_e('No casinos found.', 'casino-theme'); ?></p>
                                    </div>
                                </div>
                                <?php
                            endif;
                            ?>
                        </div>
                        
                        <!-- Template 1 -->
                        <div class="casino-table-template-1 mt-5">
                                <?php echo do_shortcode('[casinos_table 10 Casinos" second_col="loyalty" template="1" limit="10"]'); ?>
                        </div>
                        
                        <!-- Template 2 -->
                        <div class="casino-table-template-2 mt-5">
                                <?php echo do_shortcode('[casinos_table  template="2" limit="10"]'); ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <?php get_sidebar(); ?>
                    </div>
                </div>
            </div>
        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_footer();
?>