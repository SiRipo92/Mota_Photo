<?php get_header(); ?>

<main id="site-content" role="main">

    <?php
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
    ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header><!-- .entry-header -->

                <div class="entry-content">
                    <?php
                    the_content();
                    ?>
                </div><!-- .entry-content -->

                <?php if ( get_edit_post_link() ) : ?>
                <footer class="entry-footer">
                    <?php
                    edit_post_link(
                        sprintf(
                            wp_kses(
                                /* translators: %s: Name of current post. Only visible to screen readers. */
                                __( 'Edit <span class="screen-reader-text">%s</span>', 'textdomain' ),
                                array(
                                    'span' => array(
                                        'class' => array(),
                                    ),
                                )
                            ),
                            get_the_title()
                        ),
                        '<span class="edit-link">',
                        '</span>'
                    );
                    ?>
                </footer><!-- .entry-footer -->
                <?php endif; ?>
            </article><!-- #post-<?php the_ID(); ?> -->

    <?php
        endwhile;
    endif;
    ?>

</main><!-- #site-content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
