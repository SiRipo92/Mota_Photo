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


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////            ADD ACTIONS           /////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Load more photos
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');
add_action('wp_ajax_load_more_photos', 'load_more_photos');

// Fetch photos
add_action('wp_ajax_nopriv_fetch_photos', 'fetch_photos');
add_action('wp_ajax_fetch_photos', 'fetch_photos');

// Fetch lightbox data
add_action('wp_ajax_fetch_lightbox_data', 'fetch_lightbox_data_callback');
add_action('wp_ajax_nopriv_fetch_lightbox_data', 'fetch_lightbox_data_callback'); 


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////  GENERATE MARKUP FOR NEW PHOTOS  /////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function generate_photo_markup($post) {
    setup_postdata($post); ?>
    <article class="gallery-photo" data-photo-id="<?php echo get_the_ID(); ?>" data-reference-id="<?php echo esc_attr(get_field('Reference')); ?>">
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

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////// ACTION FUNCTION FOR PAGINATION LOADING AND HANDLING /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function load_more_photos() {
    check_ajax_referer('load_more_photos_nonce', 'security');

    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : '';
    $sorting = isset($_POST['sorting']) ? sanitize_text_field($_POST['sorting']) : 'DESC';
    $orderby = isset($_POST['orderby']) ? sanitize_text_field($_POST['orderby']) : 'date[Y]';

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'paged' => $paged,
        'total_posts' => -1,
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
            'taxonomy' => 'format', 
            'field'    => 'slug',
            'terms'    => $format,
        );
    }

    if (!empty($sorting)) {
        $args['order'] = $sorting;
        $args['orderby'] = $orderby;
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
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////// AJAX HANDLER TO FETCH PHOTOS, FILTER & SORT THEM  ///////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function fetch_photos() {
    check_ajax_referer('fetch_photos_nonce', 'security'); 

    $category = isset($_POST['category']) ? ($_POST['category'] === 'all' ? '' : sanitize_text_field($_POST['category'])) : '';
    $format = isset($_POST['format']) ? ($_POST['format'] === 'all' ? '' : sanitize_text_field($_POST['format'])) : '';
    $order = isset($_POST['sorting']) ? ($_POST['sorting'] === 'all' ? 'DESC' : sanitize_text_field($_POST['sorting'])) : 'DESC';

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
            'taxonomy' => 'format', 
            'field'    => 'slug',
            'terms'    => $format,
        );
    }

    if (count($tax_query) > 1 ) { 
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

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////// AJAX HANDLER TO FETCH REFERENCE IDS & CATEGORIES FOR LIGHTBOX  /////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function fetch_lightbox_data_callback() {
    // Verify nonce
    $nonce = $_POST['nonce'];
    if (!wp_verify_nonce($nonce, 'lightbox_fetch_photos_nonce')) {
        wp_send_json_error('Invalid nonce');
        die();
    }

    // Sanitize and retrieve photo ID
    $photo_id = absint($_POST['photo_id']);

    // Retrieve additional data based on $photo_id
    $additional_data = array(
        'referenceID' => get_field('Reference', $photo_id),
        'categories' => wp_get_post_terms($photo_id, 'categorie', array('fields' => 'names')),
        'featured_image' => get_the_post_thumbnail_url($photo_id, 'full'),
    );

    // Return JSON response
    wp_send_json_success($additional_data);
    die();
}