<?php 
/**
 * The template for displaying a single photo custom post type for the custom theme MotaPhoto.
 *
 *
 * @package WordPress
 * @subpackage MotaPhoto
 * @since 1.0.0
 */


get_header(); ?>

<main id="site-content" role="main">
<section id="photo-page">
    <div class="photo-display-wrapper">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) : the_post();
                // Get custom fields using ACF functions
                $fields = [
                    'Référence' => get_field('Reference'),
                    'Photo Image' => get_field('photo_image'),
                    'Catégorie' => get_the_terms(get_the_ID(), 'categorie'),
                    'Format' => get_the_terms(get_the_ID(), 'format'),
                    'Type' => get_field('Type'),
                    'Année' => get_the_date('Y')
                ];
        ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="entry-meta">
                <h2 class="entry-meta__title"><?php the_title(); ?></h2>
                <div class="entry-meta__details">
                    <!-- Display custom fields, excluding 'Photo Image' -->
                    <?php foreach ($fields as $label => $value) : ?>
                        <?php if ($value && $label != 'Photo Image') : ?>
                            <p class="photo-labels"><?php echo $label; ?>: 
                                <?php 
                                if (is_array($value)) {
                                    foreach ($value as $item) {
                                        echo esc_html($item->name) . ' ';
                                    }
                                } else {
                                    echo esc_html($value);
                                }
                                ?>
                            </p>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </article>
        <article class="photo-display">
            <?php the_content(); ?>
        </article>
        <?php
        endwhile;
        endif;
        ?>
    </div>
    <div class="photo-contact-wrapper">
        <div class="sub-photo-container">
            <article class="contact-wrapper">
                <div class="cta-text">
                    <p>Cette photo vous intéresse ?</p>
                </div>
                <button class="btn-cta">
                    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="contact">Contact</a>
                </button>
            </article>
            <article class="preview-wrapper">
                <div class="content-block">
                    <!-- Thumbnail Image Row -->
                    <div class="thumbnail-row">
                        <img class="dynamic-thumbnail">
                    </div>
                    <!------- Loop through posts when clicking arrows ------->
                    <?php
                    // Attempt to get the previous and next posts
                    $prev_post = get_adjacent_post(false, '', true);
                    $next_post = get_adjacent_post(false, '', false);

                    // If there's no previous post, get the last post
                    if (!$prev_post) {
                        $last_post_args = array(
                            'posts_per_page' => 1,
                            'order' => 'DESC',
                            'orderby' => 'date'
                        );
                        $last_post = get_posts($last_post_args);
                        $prev_post = $last_post ? $last_post[0] : null;
                    }

                    // If there's no next post, get the first post
                    if (!$next_post) {
                        $first_post_args = array(
                            'posts_per_page' => 1,
                            'order' => 'ASC',
                            'orderby' => 'date'
                        );
                        $first_post = get_posts($first_post_args);
                        $next_post = $first_post ? $first_post[0] : null;
                    }
                    ?>
                    <!-- Navigation Arrows Row -->
                    <div class="navigation-row">
                         <?php
                            $args = array(
                                'post_type' => 'photo', // Change to your post type
                                'posts_per_page' => -1, // Get all posts
                                'order' => 'DESC', // 
                            );

                            $posts = get_posts($args);
                            $current_post_key = array_search(get_the_ID(), wp_list_pluck($posts, 'ID'));

                            // Determine previous and next post
                            $prev_post_key = $current_post_key - 1;
                            $next_post_key = $current_post_key + 1;

                            // If current post is the first, set $prev_post to the last post
                            if ($prev_post_key < 0) {
                                $prev_post = $posts[count($posts) - 1];
                            } else {
                                $prev_post = $posts[$prev_post_key];
                            }

                            // If current post is the last, set $next_post to the first post
                            if ($next_post_key >= count($posts)) {
                                $next_post = $posts[0];
                            } else {
                                $next_post = $posts[$next_post_key];
                            }
                        ?>

                        <!-- Left Arrow for Previous Post -->
                        <?php if ($prev_post): ?>
                            <a href="<?php echo get_permalink($prev_post->ID); ?>" class="prev-post" data-thumbnail="<?php echo get_the_post_thumbnail_url($prev_post->ID); ?>">
                                <img class="left-arrow" src="<?php echo get_template_directory_uri() . "/assets/images/nav/left-arrow.png"; ?>">
                            </a>
                        <?php endif; ?>

                        <!-- Right Arrow for Next Post -->
                        <?php if ($next_post): ?>
                            <a href="<?php echo get_permalink($next_post->ID); ?>" class="next-post" data-thumbnail="<?php echo get_the_post_thumbnail_url($next_post->ID); ?>">
                                <img class="right-arrow" src="<?php echo get_template_directory_uri() . "/assets/images/nav/right-arrow.png"; ?>">
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </article>
        </div>
    </div>
</section>
<!-- Related photos section -->
<section id="related-photos">
    <div class="gallery-photos__container">
        <h3 class="related-photos__title">Vous aimerez aussi</h3>
        <?php get_template_part('template-parts/photo-gallery'); ?>
    </div>
</section>
</main><!-- #site-content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
