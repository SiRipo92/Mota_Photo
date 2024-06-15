<?php
/**
 * The Header for our theme.
 *
 * 
 */

?>
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
        <a class="skip-link screen-reader-text" href="#content"></a>
        <header id="masthead" class="site-header">
            <div class="site-branding">
                <!------- Logo ------->
                <div class="logo-container">
                    <?php the_custom_logo() ; ?>
                </div>
            </div><!-- .site-branding -->
            <nav role="navigation" aria-label ="<?php _e('Menu principal', 'main-menu'); ?>" class="header-nav">
            <?php wp_nav_menu(
                array(
                'theme_location' => 'main-menu', 
                'menu_id' => 'main-menu',
                'menu_class' => 'header-nav',
                'container' => false,
                'walker' => new Motaphoto_Nav_Walker()
            )); 
            ?>
            <!-- Mobile Menu ? -->
            <div class="burger">
                <button class="mobile-menu-button" aria-expanded="false" aria-controls="burger-menu" aria-label="Menu">
                    <span class="line"></span>
                    <span class="line"></span>
                    <span class="line"></span>
                </button>
            </div>
        </nav><!-- #site-navigation -->
        </header><!-- #masthead -->

        <div id="content" class="site-content">
