<?php
/**
 * Template part for displaying all photo posts on the homepage with pagination.
 * 
 * @package MotaPhoto
 * @version 1.0
 * @author Sierra Ripoche
 * @since 1.0
 * 
 */
?>

<div id="photo-gallery" class="gallery-photos__container">
    <?php
    $args = [
        'post_type' => 'photo',
        'posts_per_page' => 8, // Load initial 8 photos
        'paged' => 1 // Ensure it's the first page
    ];

    $photo_query = new WP_Query($args);

    if ($photo_query->have_posts()) :
        while ($photo_query->have_posts()) : $photo_query->the_post();
    ?>
            <article class="gallery-photo" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <a href="<?php the_permalink(); ?>">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('featured-image'); ?>
                    <?php endif; ?>
                    <h2 class="entry-title"><?php the_title(); ?></h2>
                </a>
            </article>
    <?php
        endwhile;
        wp_reset_postdata();
    else :
        echo '<p>No photos found</p>';
    endif;
    ?>
</div>
