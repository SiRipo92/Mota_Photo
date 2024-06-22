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
<section class="photo-contact">
    <div class="after-photo-container">
        <article class="cta-text">
            <p>Cette photo vous intéresse ?</p>
            <button class="btn-cta" data-reference="<?php echo esc_attr($fields['Référence']); ?>">Contact</button>
        </article>
        <article class="photo-slider">
            <div class="photo-slider-container">
            <?php
                $next_photo = get_next_post();


                if (!empty($thumbnail_url)) {
                    echo '<img class="photo-thumbnail" src="' . $thumbnail_url . '" >';
                } ; 
            ?>
                <img class="photo-thumbnail" src="" >
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/nav/left-arrow.png" alt="left-arrow">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/nav/right-arrow.png" alt="right-arrow">
            </div>
        </article>
    </div>
</section>
</main><!-- #site-content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>