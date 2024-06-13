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
                <a href="<?php echo esc_url(home_url('/')); ?>">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/nav/logo.svg" alt="<?php wp_title('name'); ?>">
                </a>
            </div><!-- .site-branding -->
            <nav id="primary-menu" class="main-nav navbar burger-menu">
                <ul id="header-nav-menu" class="nav-menu">
                    <li class="menu-item">
                        <a href="<?php echo esc_url(home_url('/')); ?>">Accueil</a>
                    </li>
                    <li class="menu-item">
                        <a href="<?php echo esc_url(home_url('/')); ?>about">À Propos</a>
                    </li>
                    <li class="menu-item">
                        <a href="<?php echo esc_url(home_url('/')); ?>contact">Contact</a>
                    </li>
                </ul>
            </nav><!-- #site-navigation -->
        </header><!-- #masthead -->

        <div id="content" class="site-content">
