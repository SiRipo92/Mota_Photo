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
                <a href="<?php echo get_site_url() ?>"><img id="logo" class="header-logo main-nav navbar" src="<?php wp_get_attachment_image('/assets/images/logo.png') ; ?>"></a>
            </div><!-- .site-branding -->
            <nav id="primary-menu" class="main-nav navbar">
            </nav><!-- #site-navigation -->
        </header><!-- #masthead -->

        <div id="content" class="site-content">
