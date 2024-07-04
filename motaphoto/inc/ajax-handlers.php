<?php
/**
 * AJAX handlers theme supports used for loading, filtering, and sorting custom post type photos from catalogue
 */

/**
 * Generates markup for a single photo post.
 * @package MotaPhoto
 * @version 1.0
 * @since 1.0
 * 
 * 
 * @param WP_Post $post The post object.
 */
function generate_photo_markup($post) {
    setup_postdata($post); ?>
            <article class="gallery-photo">
            <a href="<?php echo esc_url(get_permalink()); ?>" class="photo__link">
                <div class="photo-container">
                <?php
                    if (has_post_thumbnail()) {
                        the_post_thumbnail('featured-image');
                    } else {
                        echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/images/default-thumbnail.jpg') . '" alt="Placeholder">';
                    }
                    ?>
                </div>
                <div class="photo-overlay">
                    <img class="icon icon-fullscreen" src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/lightbox/Icon_fullscreen.png'); ?>" alt="Fullscreen Icon">
                    <img class="icon icon-eye" src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/lightbox/Icon_eye.png'); ?>" alt="Eye Icon">
                    <span class="photo-title"><?php the_title(); ?></span>
                    <span class="photo-category">
                        <?php
                        $categories = get_field('Categorie');
                        if ($categories) {
                            $category_names = array();
                            foreach ($categories as $category) {
                                $category_names[] = $category->name;
                            }
                            echo implode(', ', $category_names);
                        }
                        ?>
                </span>
                </div>
            </a>
        </article>
    <?php wp_reset_postdata();
}

/**
 * Handles AJAX request for loading more photos.
 */
function load_more_photos() {
    check_ajax_referer('load_more_photos_nonce', 'security');

    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : '';

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'paged' => $paged,
    );

    // Apply category and format filters
    if (!empty($category)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field'    => 'slug',
            'terms'    => $category,
        );
    }

    if (!empty($format)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format', // Adjust 'format' to your actual taxonomy
            'field'    => 'slug',
            'terms'    => $format,
        );
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        ob_start();
        while ($query->have_posts()) {
            $query->the_post();
            generate_photo_markup($query->post);
        }
    } else {
        wp_send_json_error('No more photos found.');
    }

    wp_die();
}
/**
 * Handles AJAX request for fetching, filtering, and sorting photos.
 */
function fetch_photos() {
    check_ajax_referer('fetch_photos_nonce', 'security'); // Adjust nonce as necessary

    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : ''; // New format parameter
    $order = isset($_POST['sorting']) ? sanitize_text_field($_POST['sorting']) : 'DESC'; // Use 'sorting' parameter

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'order' => $order,
    );

    $tax_query = array('relation' => 'AND');
    if (!empty($category)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field'    => 'slug',
            'terms'    => $category,
        );
    }

    if (!empty($format)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format', // Adjust 'format' to your actual taxonomy
            'field'    => 'slug',
            'terms'    => $format,
        );
    }

    if (count($tax_query) > 1 ) { // More than just the relation element
        $args['tax_query'] = $tax_query;
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            generate_photo_markup($query->post);
        }
    } else {
        wp_send_json_error('No photos found.');
    }
    wp_die();
}

function filter_photos() {
    check_ajax_referer('filter_photos_nonce', 'security');

    // Assume filtering parameters are passed similarly to fetch_photos
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'tax_query' => array(
            array(
                'taxonomy' => 'category',
                'field'    => 'slug',
                'terms'    => $category,
            ),
        ),
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            generate_photo_markup($query->post);
        }
    } else {
        wp_send_json_error('No photos found for the selected category.');
    }
    wp_die();
}

function sort_photos() {
    check_ajax_referer('sort_photos_nonce', 'security');

    // Sorting parameters, e.g., by date or title
    $order = isset($_POST['order']) ? sanitize_text_field($_POST['order']) : 'DESC';
    $orderby = isset($_POST['orderby']) ? sanitize_text_field($_POST['orderby']) : 'date';

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'order' => $order,
        'orderby' => $orderby,
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            generate_photo_markup($query->post);
        }
    } else {
        wp_send_json_error('No photos found with the selected sorting.');
    }
    wp_die();
}


// Register AJAX actions
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');
add_action('wp_ajax_load_more_photos', 'load_more_photos');

add_action('wp_ajax_nopriv_fetch_photos', 'fetch_photos');
add_action('wp_ajax_fetch_photos', 'fetch_photos');
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos');
add_action('wp_ajax_filter_photos', 'filter_photos');
add_action('wp_ajax_nopriv_sort_photos', 'sort_photos');
add_action('wp_ajax_sort_photos', 'sort_photos');