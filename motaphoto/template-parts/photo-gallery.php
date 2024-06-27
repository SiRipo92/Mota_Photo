<div class="gallery-photos__container">
    <?php
    // Get current post categories
    $categories = wp_get_post_terms(get_the_ID(), 'category', array('fields' => 'ids'));

    // Determine the number of posts to display based on the context
    $posts_per_page = is_front_page() ? -1 : 2; // -1 for all posts on the homepage, 2 for single-photo pages

    // WP_Query to get related photos
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
            $post_permalink = get_permalink(); // Define $post_permalink here
    ?>
            <article class="gallery-photo">
                <a href="<?php echo esc_url($post_permalink); ?>">
                    <img src="<?php echo esc_url($similar_photos_url); ?>" alt="<?php echo esc_attr($post_title); ?>">
                </a>
            </article>
    <?php
        endwhile;
        wp_reset_postdata(); // Reset the global post object so that the rest of the page works correctly.
    endif;
    ?>
</div>