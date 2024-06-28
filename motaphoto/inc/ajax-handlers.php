<?php 
// Management for AJAX Pagination 
function load_more_photos() {
    $paged = $_POST['page'];
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'paged' => $paged,
    );
    $query = new WP_Query($args);
    if ($query->have_posts()) {
        while ($query->have_posts()) : $query->the_post(); ?>
            <article class="gallery-photo" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <a href="<?php the_permalink(); ?>">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('featured-image'); ?>
                    <?php endif; ?>
                    <h2 class="entry-title"><?php the_title(); ?></h2>
                </a>
            </article>
        <?php endwhile;
    }
    wp_reset_postdata();
    die();
}
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');
add_action('wp_ajax_load_more_photos', 'load_more_photos');

function filter_photos() {
    $category = $_POST['category'];
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'category_name' => $category,
    );
    $query = new WP_Query($args);
    if ($query->have_posts()) {
        while ($query->have_posts()) : $query->the_post(); ?>
            <article class="gallery-photo" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <a href="<?php the_permalink(); ?>">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('featured-image'); ?>
                    <?php endif; ?>
                    <h2 class="entry-title"><?php the_title(); ?></h2>
                </a>
            </article>
        <?php endwhile;
    }
    wp_reset_postdata();
    die();
}
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos');
add_action('wp_ajax_filter_photos', 'filter_photos');

function sort_photos() {
    $order = $_POST['order'];
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'order' => $order,
    );
    $query = new WP_Query($args);
    if ($query->have_posts()) {
        while ($query->have_posts()) : $query->the_post(); ?>
            <article class="gallery-photo" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <a href="<?php the_permalink(); ?>">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('featured-image'); ?>
                    <?php endif; ?>
                    <h2 class="entry-title"><?php the_title(); ?></h2>
                </a>
            </article>
        <?php endwhile;
    }
    wp_reset_postdata();
    die();
}
add_action('wp_ajax_nopriv_sort_photos', 'sort_photos');
add_action('wp_ajax_sort_photos', 'sort_photos');
