<?php
/**
 * Template part for displaying a limited number of related photos on a single photo post page.
 * 
 * @package MotaPhoto
 * @version 1.0
 * @author Sierra Ripoche
 * @since 1.0
 * 
 */
?>

<div class="gallery-photos__container">
    <?php
    // Determine number of posts per page based on the template
    $posts_per_page = 8; // Default for index.php
    if (is_singular('photo')) {
        $posts_per_page = 2; // For single-photo.php
        // Fetch category of the current post
        $categories = wp_get_post_terms(get_the_ID(), 'categorie', array('fields' => 'ids'));
    }

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => $posts_per_page,
        'orderby' => is_singular('photo') ? 'rand' : 'date',
        'post__not_in' => is_singular('photo') ? array(get_the_ID()) : array()
    );

    // Apply category filter for single-photo.php
    if (is_singular('photo')) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'categorie',
                'field'    => 'id',
                'terms'    => $categories,
            ),
        );
    }

    $gallery_photos_query = new WP_Query($args);

    if ($gallery_photos_query->have_posts()) :
        while ($gallery_photos_query->have_posts()) : $gallery_photos_query->the_post();
            $photo_url = get_the_post_thumbnail_url(get_the_ID(), 'featured-image');
            $post_title = get_the_title();
            $post_permalink = get_permalink();
    ?>
            <article class="gallery-photo">
                <a href="<?php echo esc_url($post_permalink); ?>">
                    <img src="<?php echo esc_url($photo_url); ?>" alt="<?php echo esc_attr($post_title); ?>">
                </a>
            </article>
    <?php
        endwhile;
        wp_reset_postdata();
    endif;
    ?>
</div>