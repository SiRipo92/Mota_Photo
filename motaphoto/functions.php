<?php
/**
* Theme Name: MotaPhoto
* Version: 1.0
* Author: Sierra Ripoche
* Description: MotaPhoto is designed as a photography portfolio theme for artist Nathalie Mota, who does event photography, portraits, and more. The theme is designed to be simple and clean, with a focus on the images. It includes a custom post type for photo galleries, and a custom taxonomy for categorizing photos. The theme is fully compatible with the site editor, and takes advantage of new design tools introduced in WordPress 6.4.
* Tested up to: 6.5
* Requires PHP: 7.0
* Version: 1.1
* License: GNU General Public License v2 or later
* License URI: http://www.gnu.org/licenses/gpl-2.0.html
* Tags: photography, responsive, custom-header, custom-menu, featured-images, future-blog, dynamic-filter
*/

// Load theme's styles and scripts

function add_motaphoto_styles(){
    // Load photo styles
    wp_enqueue_style('motaphoto_styles', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('motaphoto_custom_styles', get_template_directory_uri() . '/assets/css/custom.css');
    // Load Google Fonts
    wp_enqueue_style('motaphoto_gfonts', get_template_directory_uri(). '/assets/fonts/stylesheet.css');
    // Load jQuery & custom scripts
    wp_enqueue_script('jquery', array('jquery'), null, true);
    wp_enqueue_script('motaphoto_scripts', get_template_directory_uri() . '/js/index.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'add_motaphoto_styles');

// Insert custom post type for photo galleries
// Insert filter to add filter to nav menu to add custom cta contact modal