<section id="related-photos">
    <h3 class="related-photos__title">Vous aimerez aussi</h3>
    <div class="related-photos__container">
        <?php
        // Get current post categories
        $categories = wp_get_post_terms(get_the_ID(), 'category', array('fields' => 'ids'));

        // WP_Query to get related photos
        $args = array(
            'post_type' => 'photo',
            'posts_per_page' => 2,
            'category__in' => $categories,
            'orderby' => 'rand',
            'post__not_in' => array(get_the_ID())
        );

        $related_photos_query = new WP_Query($args);

        if ($related_photos_query->have_posts()) : 
            while ($related_photos_query->have_posts()) : $related_photos_query->the_post();
                $similar_photos_url = get_the_post_thumbnail_url(get_the_ID(), 'featured-image');
                $post_title = get_the_title();
        ?>
                <article class="related-photo">
                    <img src="<?php echo esc_url($similar_photos_url); ?>" alt="<?php echo esc_attr($post_title); ?>">
                </article>
        <?php
            endwhile;
            wp_reset_postdata(); // Reset the global post object so that the rest of the page works correctly.
        endif;
        ?>
    </div>
</section>