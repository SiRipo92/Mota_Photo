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

                <footer class="entry-footer">
                    <span class="posted-on"><?php echo get_the_date(); ?></span>
                    <span class="byline"> by <?php the_author(); ?></span>
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