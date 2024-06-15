        <footer>
            <?php wp_footer(); ?>
            <nav role="navigation" aria-label="<?php _e('Menu footer', 'footer'); ?>">
            <?php wp_nav_menu(array
            ('theme_location' => 'footer',
            'container' => false,
            'menu_id' => 'footer-menu',
            'menu_class' => 'footer-menu',
            'walker' => new Motaphoto_Nav_Walker()
            )); ?>
        </footer>
    </body>
</html>