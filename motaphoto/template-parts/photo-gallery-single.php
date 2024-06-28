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
    $categories = wp_get_post_terms(get_the_ID(), 'category', array('fields' => 'ids'));
    $posts_per_page = 2; // Number of related posts to display

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => $posts_per_page,
        'category__in' => $categories,
        'orderby' => 'rand',
        'post__not_in' => array(get_the_ID())
    );

    $gallery_photos_query = new WP_Query($args);

    if ($gallery_photos_query->have_posts()) :
        while ($gallery_photos_query->have_posts()) : $gallery_photos_query->the_post();
            $similar_photos_url = get_the_post_thumbnail_url(get_the_ID(), 'featured-image');
            $post_title = get_the_title();
            $post_permalink = get_permalink();
    ?>
            <article class="gallery-photo">
                <a href="<?php echo esc_url($post_permalink); ?>">
                    <img src="<?php echo esc_url($similar_photos_url); ?>" alt="<?php echo esc_attr($post_title); ?>">
                </a>
            </article>
    <?php
        endwhile;
        wp_reset_postdata();
    endif;
    ?>
</div>
