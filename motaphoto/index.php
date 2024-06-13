<?php get_header(); ?>

<main id="site-content" role="main">

    <?php if ( have_posts() ) : ?>

        <header class="page-header">
            <h1 class="page-title"><?php single_post_title(); ?></h1>
        </header><!-- .page-header -->

        <?php
        // Start the loop.
        while ( have_posts() ) : the_post();
        ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php
                    if ( is_singular() ) :
                        the_title( '<h1 class="entry-title">', '</h1>' );
                    else :
                        the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
                    endif;
                    ?>
                </header><!-- .entry-header -->

                <div class="entry-content">
                    <?php
                    the_content(
                        sprintf(
                            /* translators: %s: Name of current post. Only visible to screen readers. */
                            __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'textdomain' ),
                            get_the_title()
                        )
                    );
                    ?>
                </div><!-- .entry-content -->

                <footer class="entry-footer">
                    <?php
                    // Display post meta information (categories, tags, etc.)
                    echo get_the_date();
                    echo ' | ';
                    echo get_the_author();
                    ?>
                </footer><!-- .entry-footer -->
            </article><!-- #post-<?php the_ID(); ?> -->

        <?php
        // End the loop.
        endwhile;

        // Display navigation to next/previous set of posts, when applicable.
        the_posts_navigation();

    // If no content, include the "No posts found" template.
    else :
        get_template_part( 'template-parts/content', 'none' );

    endif;
    ?>

</main><!-- #site-content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
