<?php
// Get the header
get_header();

?>

<main id="site-content" role="main">
    <section id="hero-header">
    <?php
        $landscape_photos = get_landscape_photos();
        // Check if 'query_args' is the only key in $landscape_photos, indicating no photos were found
        if (isset($landscape_photos['query_args'])) {
            // Handle the case when no photos are found. For example, use a default image.
            $random_photo_url = get_template_directory_uri() . '/assets/images/nathalie-11.jpeg';
        } else {
            // Proceed as before if photos are found
            $random_photo_url = !empty($landscape_photos) ? $landscape_photos[array_rand($landscape_photos)] : get_template_directory_uri() . '/assets/images/nathalie-11.jpeg'; // Fallback to default image
            // Check if $random_photo_url is an array and extract the URL string if necessary
            if (is_array($random_photo_url)) {
                $random_photo_url = $random_photo_url['url'] ?? get_template_directory_uri() . '/assets/images/nathalie-11.jpeg';
            }
        }
        ?>
        <div class="hero-banner" >
            <h1>Photographe Event</h1>
        </div>
    </section>
    <section class="photo-catalogue">
        <div class="photo-filters">
            <div class="filters-options">
                <?php 
                    $categories = get_terms(array(
                        'taxonomy' => 'categorie',
                        'hide_empty' => false,
                    ));

                    $formats = get_terms(array(
                        'taxonomy' => 'format',
                        'hide_empty' => false,
                    ));
                ?>
                <!-- Category Filter -->
                <div class="dropdown category-menu">
                    <button class="dropbtn">Catégories
                        <span class="arrow">&#8964;</span>
                    </button>
                    <div class="dropdown-content">
                        <ul>
                            <li data-value="" class="hidden-label">Catégories</li> <!-- Reset option -->
                            <?php foreach ($categories as $category): ?>
                                <li data-value="<?php echo esc_attr($category->slug); ?>"><?php echo esc_html($category->name); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <!-- Format Filter -->
                <div class="dropdown format-menu">
                    <button class="dropbtn">Formats
                        <span class="arrow">&#8964;</span>
                    </button>
                    <div class="dropdown-content">
                        <ul>
                            <li data-value="" class="hidden-label">Formats</li> <!-- Reset option -->
                            <?php foreach ($formats as $format): ?>
                                <li data-value="<?php echo esc_attr($format->slug); ?>"><?php echo esc_html($format->name); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="sorting-options">
                <!-- Sorting Options -->
                <div class="dropdown sorting-menu" id="sort_order">
                    <button class="dropbtn">Trier par  
                        <span class="arrow">&#8964;</span>
                    </button>
                    <div class="dropdown-content">
                        <ul>
                            <li data-value="" class="hidden-label">Trier par</li> <!-- Reset option -->
                            <li data-value="asc">À partir des plus anciennes</li>
                            <li data-value="desc">À partir des plus récentes</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!------------- Gallery Photos Container --------------------->
            <!------------- Gallery Photos Container --------------------->
        <div id="posts-container" class="gallery-photos__container">
            <?php get_template_part('template-parts/photo-gallery'); ?>
        </div>
        <div class="load-more">
            <button id="btn-load-more">Charger plus</button>
        </div>
    </section>
</main><!-- #site-content -->

<?php
// Get the sidebar and footer
get_sidebar();
get_footer();
?>