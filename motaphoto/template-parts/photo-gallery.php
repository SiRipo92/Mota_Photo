<?php
/**
 * Unified template part for displaying photo galleries on the homepage and single photo pages.
 * 
 * @package MotaPhoto
 * @version 1.0
 * @author Sierra Ripoche
 * @since 1.0
 */

// Determine the context
$is_single_photo_page = is_single();

// Set common query arguments
$args = [
    'post_type' => 'photo',
    'posts_per_page' => $is_single_photo_page ? 2 : 8, // 2 for single, 8 for homepage
];

// Adjust arguments for single photo page
if ($is_single_photo_page) {
    // Get the IDs of the categories of the current post
    $categories = wp_get_post_terms(get_the_ID(), 'categorie', ['fields' => 'ids']);
    if (!is_wp_error($categories) && !empty($categories)) {
        $args += [
            'tax_query' => [
                [
                    'taxonomy' => 'categorie',
                    'field'    => 'term_id',
                    'terms'    => $categories,
                ],
            ],
            'orderby' => 'rand',
            'post__not_in' => [get_the_ID()], // Exclude the current post
        ];
    }
} else {
    // For homepage, handle pagination
    $args['paged'] = get_query_var('paged') ? get_query_var('paged') : 1;
}


$photo_query = new WP_Query($args);

if ($photo_query->have_posts()) : ?>
    <div class="gallery-photos__container">
        <?php while ($photo_query->have_posts()) : $photo_query->the_post(); ?>
            <article class="gallery-photo" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <a href="<?php the_permalink(); ?>" class="photo__link">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="photo-container">
                            <?php the_post_thumbnail('featured-image'); ?>
                        </div>
                        <div class="photo-overlay">
                            <div class="photo-overlay__text">
                                <img class="icon icon-eye" src="<?php echo get_template_directory_uri().'/assets/images/nav/Icon_eye.svg'; ?>" alt="View icon">
                                <img class="icon icon-fullscreen" src="<?php echo get_template_directory_uri().'/assets/images/nav/Icon_fullscreen.svg'; ?>" alt="Fullscreen icon">
                                <span class="photo_reference">
                                    <?php // Using ACF get_field() for ReferenceID
                                        $referenceID = get_field('Reference');
                                        if (!$referenceID) {
                                            echo '<span class="debug-message">ReferenceID not found for post ID: '.get_the_ID().'</span>';
                                        } else {
                                            echo '<span class="photo_reference">'.esc_html($referenceID).'</span>';
                                        }
                                    ?>
                                </span>
                                <span class="photo_category">
                                    <?php
                                    // Using get_the_terms() to retrieve categories
                                    $categories = get_the_terms(get_the_ID(), 'categorie'); // Ensure 'categorie' is the correct taxonomy
                                    if (!$categories || is_wp_error($categories)) {
                                        echo '<span class="debug-message">Category not found for post ID: '.get_the_ID().'</span>';
                                    } else {
                                        // Iterate through each category and display its name
                                        $category_names = array_map(function($cat) { return esc_html($cat->name); }, $categories);
                                        echo '<span class="photo_category">'.implode(', ', $category_names).'</span>';
                                    }
                                    ?>
                                </span>
                            </div>
                        </div>
                    <?php endif; ?>
                </a>
            </article>
        <?php endwhile; ?>
    </div>
    <?php wp_reset_postdata(); ?>
<?php else : ?>
    <p>No photos found</p>
<?php endif; ?>