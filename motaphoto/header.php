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
        <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'MotaPhoto'); ?></a>
        <header id="masthead" class="site-header">
            <div class="logo-container">
                <?php the_custom_logo(); ?>
            </div>
            <nav id="header-navigation" class="main-navigation" role="navigation" aria-label="<?php _e('Main Menu', 'MotaPhoto'); ?>">
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
            <div class="mobile-menu-container">
                <button class="burger-btn" aria-controls="primary-menu" aria-expanded="false">
                        <span></span>
                        <span></span>
                        <span></span>
                </button> 
            </div>
            <div class="mobile-menu">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'main-menu',
                        'menu_id' => 'primary-menu',
                        'menu_class' => 'primary-menu'
                    )
                ); 
                ?>
            </div>
        </header><!-- #masthead -->
            
        <div id="content" class="site-content">