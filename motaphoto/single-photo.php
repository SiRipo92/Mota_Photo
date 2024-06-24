<?php get_header(); ?>

<main id="site-content" role="main">
<section id="photo-page">
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

            <!-- Display custom fields -->
                <?php foreach ($fields as $label => $value) : ?>
                    <?php if ($value) : ?>
                        <?php if ($label == 'Photo Image') : ?>
                            <div class="photo-image">
                                <?php if (is_array($value) && isset($value['url'])) : ?>
                                    <img src="<?php echo esc_url($value['url']); ?>" alt="<?php echo esc_attr($value['alt'] ?? ''); ?>">
                                <?php else : ?>
                                    <!-- Assuming $value is a string URL here -->
                                    <img src="<?php echo esc_url($value); ?>" alt="">
                                <?php endif; ?>
                            </div>
                        <?php elseif (is_array($value)) : ?>
                            <p><?php echo $label; ?>: 
                                <?php foreach ($value as $item) {
                                    echo esc_html($item->name) . ' ';
                                } ?>
                            </p>
                        <?php else : ?>
                            <p><?php echo $label; ?>: <?php echo esc_html($value); ?></p>
                        <?php endif; ?>
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
</section>

<!-- Contact section and thumbnail page navigation -->
<section class="photo-contact">
    <div class="after-photo-container">
        <article class="cta-text">
            <p>Cette photo vous intéresse ?</p>
            <button class="btn-cta">Contact</button>
        </article>
        <article class="photo-slider">
            <div class="photo-slider-container">
            <?php
                $next_post = get_adjacent_post(true, '', false, 'photo');
                $prev_post = get_adjacent_post(true, '', true, 'photo');

                // Optimize fetching the first or last post if next or previous doesn't exist
                if (!$next_post) {
                    $next_posts = get_posts([
                        'post_type' => 'photo',
                        'posts_per_page' => 1,
                        'order' => 'ASC'
                    ]);
                    if (!empty($next_posts)) {
                        $next_post = array_shift($next_posts);
                    }
                }

                if (!$prev_post) {
                    $prev_posts = get_posts([
                        'post_type' => 'photo',
                        'posts_per_page' => 1,
                        'order' => 'DESC'
                    ]);
                    if (!empty($prev_posts)) {
                        $prev_post = array_shift($prev_posts);
                    }
                }

                // Ensure next and previous posts are found before attempting to use them
                if ($next_post) {
                    $next_url = get_permalink($next_post->ID);
                    $thumbnail_url = get_the_post_thumbnail_url($next_post->ID, 'thumbnail');
                    if (!empty($thumbnail_url)): ?>
                        <img class="photo-thumbnail" src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_attr(get_the_title($next_post->ID)); ?>" data-current-post-id="<?php echo esc_attr($next_post->ID); ?>">
                    <?php else: ?>
                        <p>No more photos available.</p>
                    <?php endif;
                }

                if ($prev_post) {
                    $prev_url = get_permalink($prev_post->ID);
                    // Additional logic for $prev_post if needed
                }
                ?>
                <div class="slider-controls">
                    <?php if ($prev_post): ?>
                        <a href="<?php echo esc_url($prev_url); ?>" class="prev-photo" role="navigation" aria-label="Previous Photo">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/nav/left-arrow.png" alt="Previous">
                        </a>
                    <?php endif; ?>
                    <?php if ($next_post): ?>
                        <a href="<?php echo esc_url($next_url); ?>" class="next-photo" role="navigation" aria-label="Next Photo">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/nav/right-arrow.png" alt="Next">
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </article>
    </div>
</section>

<!-- Related photos section -->
<?php get_template_part('template-parts/related-photos'); ?>
</main><!-- #site-content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
