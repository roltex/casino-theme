<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Casino_Theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('glass-card mb-4'); ?>>
    <div class="card-body">
        <header class="entry-header">
            <?php
            if (is_singular()) :
                the_title('<h1 class="entry-title text-gradient">', '</h1>');
            else :
                the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark" class="text-gradient">', '</a></h2>');
            endif;

            if ('post' === get_post_type()) :
                ?>
                <div class="entry-meta">
                    <span class="posted-on">
                        <i class="fas fa-calendar-alt me-1"></i>
                        <a href="<?php echo esc_url(get_permalink()); ?>">
                            <time class="entry-date published" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                <?php echo esc_html(get_the_date()); ?>
                            </time>
                        </a>
                    </span>
                    <span class="byline">
                        <i class="fas fa-user me-1"></i>
                        <span class="author vcard">
                            <a class="url fn n" href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                <?php echo esc_html(get_the_author()); ?>
                            </a>
                        </span>
                    </span>
                    <?php if (has_category()) : ?>
                        <span class="cat-links">
                            <i class="fas fa-folder me-1"></i>
                            <?php the_category(', '); ?>
                        </span>
                    <?php endif; ?>
                </div><!-- .entry-meta -->
            <?php endif; ?>
        </header><!-- .entry-header -->

        <?php if (has_post_thumbnail() && !is_singular()) : ?>
            <div class="post-thumbnail mb-3">
                <a href="<?php echo esc_url(get_permalink()); ?>">
                    <?php the_post_thumbnail('medium', array('class' => 'img-fluid rounded')); ?>
                </a>
            </div>
        <?php endif; ?>

        <div class="entry-content">
            <?php
            if (is_singular()) :
                the_content(
                    sprintf(
                        wp_kses(
                            /* translators: %s: Name of current post. Only visible to screen readers */
                            __('Continue reading<span class="screen-reader-text"> "%s"</span>', 'casino-theme'),
                            array(
                                'span' => array(
                                    'class' => array(),
                                ),
                            )
                        ),
                        wp_kses_post(get_the_title())
                    )
                );

                wp_link_pages(
                    array(
                        'before' => '<div class="page-links">' . esc_html__('Pages:', 'casino-theme'),
                        'after'  => '</div>',
                    )
                );
            else :
                the_excerpt();
                ?>
                <div class="read-more">
                    <a href="<?php echo esc_url(get_permalink()); ?>" class="glass-btn glass-btn-primary">
                        <?php esc_html_e('Read More', 'casino-theme'); ?>
                        <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            <?php endif; ?>
        </div><!-- .entry-content -->

        <footer class="entry-footer">
            <?php if ('post' === get_post_type()) : ?>
                <div class="entry-footer-meta">
                    <?php if (has_tag()) : ?>
                        <div class="tags-links">
                            <i class="fas fa-tags me-1"></i>
                            <?php the_tags('', ', '); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </footer><!-- .entry-footer -->
    </div>
</article><!-- #post-<?php the_ID(); ?> -->