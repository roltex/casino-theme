<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">

    <!-- Header Wrapper for Sticky Functionality -->
    <header id="masthead" class="site-header">
        <!-- Top Bar -->
        <div class="top-bar glass-card-light">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="top-bar-info">
                            <span>
                                <i class="fas fa-phone"></i>
                                <?php esc_html_e('+1 (555) 123-4567', 'casino-theme'); ?>
                            </span>
                            <span>
                                <i class="fas fa-envelope"></i>
                                <?php esc_html_e('info@casinotheme.com', 'casino-theme'); ?>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="top-bar-social text-end">
                            <a href="#" class="social-link" aria-label="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="social-link" aria-label="Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="social-link" aria-label="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="social-link" aria-label="YouTube">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Navigation -->
        <nav class="navbar navbar-expand-lg main-navbar glass-card">
            <div class="container">
                <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">
                    <?php
                    // Use WordPress core custom logo function
                    if (has_custom_logo()) {
                        the_custom_logo();
                    } else {
                        echo '<span class="brand-text text-gradient">' . get_bloginfo('name') . '</span>';
                    }
                    ?>
                </a>

                <button class="navbar-toggler glass-btn" type="button" data-bs-toggle="collapse" data-bs-target="#primary-menu" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation', 'casino-theme'); ?>">
                    <span class="navbar-toggler-icon">
                        <i class="fas fa-bars"></i>
                    </span>
                </button>

                <div class="collapse navbar-collapse" id="primary-menu">
                    <?php
                    if (has_nav_menu('primary')) {
                        $walker = new Bootstrap_5_Nav_Walker();
                        wp_nav_menu(array(
                            'theme_location' => 'primary',
                            'menu_id'        => 'primary-menu',
                            'container'      => false,
                            'menu_class'     => 'navbar-nav ms-auto',
                            'walker'         => $walker,
                        ));
                    } else {
                        // Fallback for when no menu is set up
                        echo '<ul class="navbar-nav ms-auto">';
                        echo '<li class="nav-item"><a class="nav-link" href="' . esc_url(home_url('/')) . '">' . esc_html__('Home', 'casino-theme') . '</a></li>';
                        echo '</ul>';
                    }
                    ?>
                    
                    <div class="navbar-nav ms-auto">
                        <button class="btn-search glass-btn" type="button" data-bs-toggle="modal" data-bs-target="#searchModal">
                            <i class="fas fa-search"></i>
                            <span class="d-none d-md-inline"><?php esc_html_e('Search', 'casino-theme'); ?></span>
                        </button>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Search Modal -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content glass-card">
                <div class="modal-header">
                    <h5 class="modal-title" id="searchModalLabel">
                        <i class="fas fa-search me-2"></i>
                        <?php esc_html_e('Search Casinos', 'casino-theme'); ?>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                        <div class="input-group">
                            <input type="search" class="form-control glass-input" placeholder="<?php esc_attr_e('Search for casinos...', 'casino-theme'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
                            <button class="btn glass-btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="content" class="site-content">