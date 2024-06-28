<?php 
/**
 * Footer Template
 *
 * @package MotaPhoto
 * @version 1.1
 * @author Sierra Ripoche
 * @since 1.0
 *
 * Description: This template is used to display the custom footer of the MotaPhoto theme using Nav Walker class for navigation
 */
?>

<!-- footer.php -->
<footer>
    <nav class="footer-nav" role="navigation" aria-label="<?php _e('Menu footer', 'footer'); ?>">
        <?php wp_nav_menu(array(
            'theme_location' => 'footer',
            'container' => false,
            'menu_id' => 'footer-menu',
            'menu_class' => 'footer-menu',
            'walker' => new Motaphoto_Nav_Walker()
        )); ?>
    </nav>
    <?php get_template_part('template-parts/modal-contact'); ?>
    <?php wp_footer(); ?>
</footer>
</body>
</html>