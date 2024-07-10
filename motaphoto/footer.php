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

            <!-- Lightbox Modal -->

            <?php  
            // Retrieve ACF 'format' field value for the current post
            $format = get_field('format'); 

            // Retrieve taxonomy terms for the current post
            $terms = get_the_terms(get_the_ID(), 'format'); 

            // Check if the format is 'portrait' or 'paysage' and set classes accordingly
            $container_classes = 'lightbox-modal__container';
            $caption_classes = 'lightbox-modal__caption';
            $image_styles = '';

            if ($format === 'portrait') {
                $container_classes .= ' portrait-format'; // Add custom class for portrait format
                $caption_classes .= ' portrait-caption'; // Add custom class for portrait caption style
            } elseif ($format === 'paysage') {
                $container_classes .= ' paysage-format'; // Add custom class for paysage format
                $caption_classes .= ' paysage-caption'; // Add custom class for paysage caption style
            }
            
            // Retrieve the featured image URL
            $featured_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full'); // Adjust 'full' size as needed

            ?>
                <div class="lightbox-modal" id="lightbox-modal">
                    <div class="lightbox-modal__overlay" id="lightbox-modal-overlay">
                        <div class="<?php echo esc_attr($container_classes); ?>">
                            <div class="lightbox-modal__container-header">
                                <button class="lightbox-modal__close" id="lightbox-modal-close">
                                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/lightbox/close.png'); ?>" alt="Closing button">
                                </button>
                            </div>
                            <div class="lightbox-modal__display">
                                <div class="main-axis">
                                    <span class="lightbox-modal__button prev-btn" id="lightbox-modal-prev">
                                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/lightbox/prev-arrow.png'); ?>" alt="Previous">
                                    </span>
                                    <div class="main-image-container">
                                        <img class="lightbox-modal__image" id="lightbox-modal-image" src="<?php echo esc_url($featured_image_url); ?>" alt="Lightbox Image" style="<?php echo esc_attr($image_styles); ?>">
                                    </div>
                                    <span class="lightbox-modal__button next-btn" id="lightbox-modal-next">
                                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/lightbox/next-arrow.png'); ?>" alt="Next">
                                    </span>
                                </div>
                                <div class="<?php echo esc_attr($caption_classes); ?>" id="lightbox-modal-caption">
                                    <span class="photo_reference"></span>
                                    <span class="photo_category"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php wp_footer(); ?>
        </footer>
    </body>
</html>