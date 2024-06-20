<?php get_header(); ?>

<main id="site-content" role="main">

    <?php
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
            // Get custom fields using ACF functions
            $fields = [
                'Reference' => get_field('Reference'),
                'Photo Image' => get_field('photo_image'),
                'Catégorie' => get_the_terms(get_the_ID(), 'categorie'),
                'Format' => get_the_terms(get_the_ID(), 'format'),
                'Type' => get_field('Type'),
                'Année' => get_the_date('Y')
            ];
    ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header><!-- .entry-header -->

                <div class="entry-content">
                    <?php foreach ($fields as $label => $value) : ?>
                        <?php if ($value) : ?>
                            <?php if ($label == 'Photo Image') : ?>
                                <div class="photo-image">
                                    <img src="<?php echo esc_url($value['url']); ?>" alt="<?php echo esc_attr($value['alt']); ?>">
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

                    <?php the_content(); ?>
                </div><!-- .entry-content -->

                <footer class="entry-footer">
                </footer><!-- .entry-footer -->
            </article><!-- #post-<?php the_ID(); ?> -->

            <?php
            // If comments are open or there is at least one comment, load the comment template.
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;
            ?>

    <?php
        endwhile;
    endif;
    ?>

</main><!-- #site-content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>