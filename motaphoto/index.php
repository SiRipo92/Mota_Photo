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
    <section class="content">
    </section>
</main><!-- #site-content -->

<?php
// Get the sidebar and footer
get_sidebar();
get_footer();
?>