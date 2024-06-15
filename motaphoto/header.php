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
            <!------- Logo ------->
            <div class="logo-conteneur">
                <?php echo get_custom_logo('custom-logo') ; ?>
            </div><!-- .site-branding -->
            <nav role="navigation" aria-label ="<?php _e('Menu principal', 'main-menu'); ?>">
                <?php wp_nav_menu(
                    array(
                    'theme_location' => 'main-menu', 
                    'menu_id' => 'main-menu',
                    'menu_class' => 'header-nav',
                    'container' => false,
                    'walker' => new Motaphoto_Nav_Walker()
                )); 
                ?>
            </nav><!-- #site-navigation -->

            <!-- Mobile Menu ? -->
             <nav role="navigation" aria-label="<?php _e('Menu mobile', 'mobile-menu'); ?>">
                <div class="burger">
                    <div class="burger__patty">
                        <button class="mobile-menu-button" aria-expanded="false" aria-controls="burger-menu" aria-label="Menu">
                            <span class="burger__patty-container">
                                <span class="line"></span>
                                <span class="line"></span>
                                <span class="line"></span>
                            </span>
                        </button>
                    </div>
                <?php wp_nav_menu(
                    array(
                    'theme_location' => 'mobile-menu', 
                    'menu_id' => 'burger-menu',
                    'menu_class' => 'mobile',
                    'container' => false,
                    'walker' => new Motaphoto_Nav_Walker()
                ));
                ?>

        </header><!-- #masthead -->

        <div id="content" class="site-content">
