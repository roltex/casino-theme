<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
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
                        <?php
                        while (have_posts()) :
                            the_post();

                            get_template_part('template-parts/content', 'page');

                        endwhile; // End of the loop.
                        ?>
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