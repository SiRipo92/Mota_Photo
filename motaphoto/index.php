<?php
// Get the header
get_header();


// Function to generate dropdown filter menus
function generate_dropdown($items, $label, $taxonomy) {
    ?>
    <div class="dropdown <?php echo $taxonomy; ?>-menu">
        <button class="dropbtn"><?php echo $label; ?>
            <span class="arrow">&#8964;</span>
        </button>
        <div class="dropdown-content">
            <ul class="dropdown-<?php echo $taxonomy; ?>">
                <li data-value="" class="hidden-label"><?php echo $label; ?></li> <!-- Reset option -->
                <?php foreach ($items as $item): ?>
                    <li data-value="<?php echo esc_attr($item->slug); ?>"><?php echo esc_html($item->name); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <?php
}

// Get categories and formats
$categories = get_terms(array(
    'taxonomy' => 'categorie',
    'hide_empty' => false,
));

$formats = get_terms(array(
    'taxonomy' => 'format',
    'hide_empty' => false,
));

?>

<main id="site-content" role="main">
    <section id="hero-header">
        <div class="hero-banner"> 
            <?php // Custom banner code is in 'inc/custom-banner.php' ?>
            <h1>Photographe Event</h1>
        </div>
    </section>
    <section class="photo-catalogue">
        <div class="photo-filters">
            <div class="filters-options">
                <!-- Category Filter -->
                <?php generate_dropdown($categories, 'Catégories', 'category'); ?>

                <!-- Format Filter -->
                <?php generate_dropdown($formats, 'Formats', 'format'); ?>
            </div>
            <div class="sorting-options">
                <!-- Sorting Options -->
                <div class="dropdown sorting-menu" id="sort_order">
                    <button class="dropbtn">Trier par  
                        <span class="arrow">&#8964;</span>
                    </button>
                    <div class="dropdown-content">
                        <ul class="dropdown-sorting">
                            <li data-value="" class="hidden-label">Trier par</li> <!-- Reset option -->
                            <li data-value="asc">À partir des plus anciennes</li>
                            <li data-value="desc">À partir des plus récentes</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
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