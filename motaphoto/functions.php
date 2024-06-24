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
?>

<?php 
/* 
******************* Add theme stylesheets and scripts 
*/

function add_motaphoto_styles(){
    wp_enqueue_style('motaphoto-styles', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('motaphoto-custom-styles', get_template_directory_uri() . '/assets/css/custom.css');
}
add_action('wp_enqueue_scripts', 'add_motaphoto_styles');

function add_motaphoto_scripts() {
    wp_enqueue_script('jquery', array('jquery'), null, true);
    wp_enqueue_script('motaphoto-custom-script', get_template_directory_uri() . '/assets/js/index.js', array('jquery'), null, true);

    wp_enqueue_script('photo-navigation', get_template_directory_uri() . '/assets/js/photo-navigation.js', array('jquery'), null, true);
    wp_localize_script('photo-navigation', 'myScriptData', array(
        'ajaxurl' => admin_url('admin-ajax.php') 
    ));

    // Assuming you're on a single custom post type page
    if (is_singular('photo')) {
        $referenceID = get_field('Reference', get_the_ID());
        wp_localize_script('motaphoto-custom-script', 'customData', array('referenceID' => $referenceID));
    } else {
        wp_localize_script('motaphoto-custom-script', 'customData', array('referenceID' => ''));
    }
}
add_action('wp_enqueue_scripts', 'add_motaphoto_scripts');

// Include custom AJAX handlers
require_once get_template_directory() . '/inc/ajax-handlers.php';

/*
******************* Add theme support for custom header
*/
// Custom Logo Setup
function motaphoto_custom_logo_setup() {
	$defaults = array(
		'height'               => 'auto',
		'width'                => 'auto',
		'flex-height'          => true,
		'flex-width'           => true,
		'header-text'          => array( 'site-title', 'site-description' ),
		'unlink-homepage-logo' => true, 
	);
	add_theme_support( 'custom-logo', $defaults );
    $custom_logo_id = get_theme_mod( 'custom-logo' );
    $image = wp_get_attachment_image_src( $custom_logo_id , 'small' );
    echo $image;
}
add_action( 'after_setup_theme', 'motaphoto_custom_logo_setup' );
add_theme_support( 'custom-logo' );
/*
******************* Add theme menus
*/

// Add theme support for custom header
add_action( 'after_setup_theme', 'motaphoto_theme_setup' );

function motaphoto_theme_setup() {
    add_theme_support('menus');
}
add_action('init', 'motaphoto_theme_setup');

// Register custom navigation menus
function register_motaphoto_menus() {
    register_nav_menus(
        array(
            'primary' => __('Primary Menu'),
            'footer' => __('Footer Menu'),
            'mobile' => __('Mobile Menu')
        )
    );
}
add_action('after_setup_theme', 'register_motaphoto_menus');

/*
*******************   Load Nav-Walker menus.php file
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Include the custom walker file
require get_template_directory() . '/inc/menus.php';

// Register Nav Walker
function register_navwalker(){
    if ( ! file_exists( get_template_directory() . '/inc/menus.php' ) ) {
        return;
    }

    require_once get_template_directory() . '/inc/menus.php';
}
add_action( 'after_setup_theme', 'register_navwalker' );