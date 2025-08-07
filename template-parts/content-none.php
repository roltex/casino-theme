<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Casino_Theme
 */

?>

<section class="no-results not-found glass-card p-5 text-center">
    <header class="page-header">
        <h1 class="page-title text-gradient"><?php esc_html_e('Nothing Found', 'casino-theme'); ?></h1>
    </header><!-- .page-header -->

    <div class="page-content">
        <?php
        if (is_home() && current_user_can('publish_posts')) :

            printf(
                '<p>' . wp_kses(
                    /* translators: 1: link to WP admin new post page. */
                    __('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'casino-theme'),
                    array(
                        'a' => array(
                            'href' => array(),
                        ),
                    )
                ) . '</p>',
                esc_url(admin_url('post-new.php'))
            );

        elseif (is_search()) :
            ?>

            <p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'casino-theme'); ?></p>
            <?php
            get_search_form();

        elseif (is_home()) :
            ?>

            <p><?php esc_html_e('It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'casino-theme'); ?></p>
            <?php
            get_search_form();

        else :
            ?>

            <p><?php esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'casino-theme'); ?></p>
            <?php
            get_search_form();

        endif;
        ?>
    </div><!-- .page-content -->

    <div class="no-results-actions mt-4">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="glass-btn glass-btn-primary me-3">
            <i class="fas fa-home me-2"></i>
            <?php esc_html_e('Back to Home', 'casino-theme'); ?>
        </a>
        <button type="button" class="glass-btn" data-bs-toggle="modal" data-bs-target="#searchModal">
            <i class="fas fa-search me-2"></i>
            <?php esc_html_e('Search', 'casino-theme'); ?>
        </button>
    </div>
</section><!-- .no-results -->