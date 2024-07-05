<?php
/**
 * Template part for displaying a limited number of related photos on a single photo post page,
 * or a larger gallery with pagination on the index page.
 * 
 * @package MotaPhoto
 * @version 1.0
 * author Sierra Ripoche
 * @since 1.0
 */

// Determine number of posts per page based on the template
$posts_per_page = 8; // Default for index.php

if (is_singular('photo')) {
    // For single-photo.php, show related photos in the same category
    $posts_per_page = 2;
    $categories = wp_get_post_terms(get_the_ID(), 'categorie', array('fields' => 'ids'));
    $args = array(
        'post_type'      => 'photo',
        'posts_per_page' => $posts_per_page,
        'orderby'        => 'rand', // Random order for related photos
        'post__not_in'   => array(get_the_ID()), // Exclude the current photo from related photos
    );
    if (!empty($categories) && !is_wp_error($categories)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'categorie',
                'field'    => 'id',
                'terms'    => $categories,
            ),
        );
    }
} else {
    // For index.php, handle pagination and filtering
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
    $args = array(
        'post_type'      => 'photo',
        'posts_per_page' => $posts_per_page,
        'paged'          => $paged,
        'orderby'        => 'date', // Default order for index page
    );

    // Apply filters if present
    if (isset($_POST['category']) && !empty($_POST['category'])) {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field'    => 'slug',
            'terms'    => sanitize_text_field($_POST['category']),
        );
    }

    if (isset($_POST['format']) && !empty($_POST['format'])) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field'    => 'slug',
            'terms'    => sanitize_text_field($_POST['format']),
        );
    }

    if (isset($_POST['sort_order']) && !empty($_POST['sort_order'])) {
        $args['order'] = sanitize_text_field($_POST['sort_order']);
    }
}

$photo_query = new WP_Query($args);

if ($photo_query->have_posts()) :
    while ($photo_query->have_posts()) : $photo_query->the_post();
        ?>
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
    <?php
    endwhile;
    // Reset Post Data
    wp_reset_postdata();
else :
    // No posts found
    echo '<p>No photos found.</p>';
endif;
?>