<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <title><?php wp_title('|', true, 'right'); ?></title>

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <div id="page" class="site-main">
        <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'textdomain'); ?></a>
        <header id="masthead" class="site-header">
            <div class="nav-menu">
                <div class="site-branding">
                    <div class="logo-container">
                        <?php the_custom_logo(); ?>
                    </div>
                </div><!-- .site-branding -->

                <nav role="navigation" aria-label="<?php _e('Main Menu', 'textdomain'); ?>" class="main-nav" id="main-menu">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'main-menu',
                            'menu_id' => 'primary-menu',
                            'menu_class' => 'primary-menu',
                            'container' => false,
                            'walker' => new Motaphoto_Nav_Walker(),
                        )
                    );
                    ?>
                </nav>

                <div class="burger close-button">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
            <div id="mobile-menu" class="mobile-menu">
            <div class="mobile-header">
                <div class="site-branding">
                    <div class="logo-container">
                        <?php the_custom_logo(); ?>
                    </div>
                </div>
            </div>
            <div class="mobile-menu-container">
                <nav role="navigation" aria-label="<?php _e('Mobile Menu', 'textdomain'); ?>" class="mobile-nav">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'main-menu',
                            'menu_id' => 'mobile-main-menu',
                            'menu_class' => 'mobile-menu-nav',
                            'container' => false,
                            'walker' => new Motaphoto_Nav_Walker(),
                        )
                    );
                    ?>
                </nav>
            </div>
        </div>
        </header><!-- #masthead -->

        <div id="content" class="site-content">