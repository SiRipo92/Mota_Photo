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
    <section class="photo-gallery">
        <div class="photo-filters">
            <div class="photo-filters__container">
                <!------------- Sort by Category Dropdown --------------------->
                <select class="category-menu">
                    <option value="" selected disabled>Catégories</option>
                    <?php
                    // Initialize $terms as an empty array
                    $terms = [];

                    // Attempt to retrieve terms from a custom taxonomy
                    $retrieved_terms = get_terms([
                        'taxonomy' => 'categorie',
                        'hide_empty' => false, // Set to true to hide categories with no posts
                    ]);

                    // Check if the retrieval was successful and update $terms if so
                    if (!is_wp_error($retrieved_terms) && !empty($retrieved_terms)) {
                        $terms = $retrieved_terms;
                    }

                    // Iterate over $terms to populate the dropdown
                    foreach ($terms as $term) {
                        echo "<option value='{$term->slug}'>{$term->name}</option>";
                    }
                    ?>
                </select>

                <!------------- Sort by Formats Dropdown    --------------------->
                <select class="format-menu">
                    <option value="" selected disabled>Formats</option>
                    <?php
                    // Initialize $formats as an empty array
                    $formats = [];

                    // Attempt to retrieve formats from the custom taxonomy 'format'
                    $retrieved_formats = get_terms([
                        'taxonomy' => 'format',
                        'hide_empty' => false, // Set to true to hide formats with no posts
                    ]);

                    // Check if the retrieval was successful and update $formats if so
                    if (!is_wp_error($retrieved_formats) && !empty($retrieved_formats)) {
                        $formats = $retrieved_formats;
                    }

                    // Iterate over $formats to populate the dropdown
                    foreach ($formats as $format) {
                        echo "<option value='{$format->slug}'>{$format->name}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="year-sortby__container">
                <select class="year-sortby">
                    <option value="" selected disabled>Trier par</option>
                    <?php

                    // Custom query to fetch all years from the database
                    global $wpdb;
                    $years = $wpdb->get_col("SELECT DISTINCT YEAR(post_date) AS year FROM $wpdb->posts WHERE post_type = 'photo' AND post_status = 'publish' ORDER BY post_date DESC");
                    
                    // Iterate over the years to populate the dropdown
                    foreach ($years as $year) {
                        echo "<option value='{$year}'>{$year}</option>";
                    
                    }
                    ?>
                </select>
            </div>
        </div>
        <!------------- Gallery Photos Container --------------------->
        <div id="posts-container" class="gallery-photos__container">
            <?php get_template_part('template-parts/photo-gallery-index');
                ?>
        </div>
        <div class="load-more">
            <button id="load-more-button">Load More</button>
        </div>
    </section>
</main><!-- #site-content -->

<?php
// Get the sidebar and footer
get_sidebar();
get_footer();
?>