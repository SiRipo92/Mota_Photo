<?php 

function get_landscape_photos() {
    $args = array(
        'post_type' => 'photo',
        'tax_query' => array(
            array(
                'taxonomy' => 'format',
                'field'    => 'slug',
                'terms'    => 'paysage',
            ),
        ),
        'posts_per_page' => -1
    );

    $query = new WP_Query($args);
    $photos = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $photo_url = get_the_post_thumbnail_url($query->post->ID, 'full');
            $acf_fields = get_fields($query->post->ID); // Retrieve all ACF fields for the post

            // Combine the photo URL and ACF fields into a single array
            $photo_data = array(
                'url' => $photo_url,
                'acf' => $acf_fields
            );

            // Log each photo URL
            $photos[] = $photo_data;
        }
        wp_reset_postdata();
    } else {
        // For debugging: return the query args if no posts found
        $photos['query_args'] = $args;
    }

    return $photos;
}

function enqueue_custom_scripts() {
    wp_enqueue_script('custom-banner', get_template_directory_uri() . '/assets/js/custom-banner.js', array('jquery'), '1.0', true);
    wp_localize_script('custom-banner', 'customBannerData', array(
        'photos' => get_landscape_photos(),
    ));
}

add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');
