<?php
/**
 * Starts the element output.
 *
 * @since 3.0.0
 * @since 4.4.0 The {@see 'nav_menu_item_args'} filter was added.
 * @since 5.9.0 Renamed `$item` to `$data_object` and `$id` to `$current_object_id`
 *              to match parent class for PHP 8 named parameter support.
 *
 * @see Walker::start_el()
 *
 * @param string   $output            Used to append additional content (passed by reference).
 * @param WP_Post  $data_object       Menu item data object.
 * @param int      $depth             Depth of menu item. Used for padding.
 * @param stdClass $args              An object of wp_nav_menu() arguments.
 * @param int      $current_object_id Optional. ID of the current menu item. Default 0.
 */
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Motaphoto_Nav_Walker extends Walker_Nav_Menu {
	// Add classes to ul sub-menus
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"sub-menu\">\n";
    }
	// Add classes to li items and links
    public function start_el( &$output, $data_object, $depth = 0, $args = array(), $current_object_id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        $class_names = $value = '';

        $classes = empty( $data_object->classes ) ? array() : (array) $data_object->classes;
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $data_object, $args, $depth ) );
        $class_names = ' class="' . esc_attr( $class_names ) . '"';

        $output .= $indent . '<li' . $class_names .'>';

        $atts = array();
        $atts['title']  = ! empty( $data_object->attr_title ) ? $data_object->attr_title : '';
        $atts['target'] = ! empty( $data_object->target )     ? $data_object->target     : '';
        $atts['rel']    = ! empty( $data_object->xfn )        ? $data_object->xfn        : '';
        $atts['href']   = ! empty( $data_object->url )        ? $data_object->url        : '';

        // Add aria-current attribute
        $atts['aria-current'] = $data_object->current ? 'page' : '';

        // Add title attribute if the link opens in a new tab
        if ( '_blank' === $data_object->target && empty( $data_object->xfn ) ) {
            $atts['title'] = $data_object->title . __( ' (s\'ouvre dans un nouvel onglet)', 'text-domain' );
        }

        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $data_object, $args, $depth );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }
        // Add classes to links
        $item_output = is_object($args) && property_exists($args, 'before') ? $args->before : '';
        $item_output .= '<a'. $attributes .'>';
        $item_output .= is_object($args) && property_exists($args, 'link_before') ? $args->link_before : '';
        $item_output .= apply_filters( 'the_title', $data_object->title, $data_object->ID );
        $item_output .= is_object($args) && property_exists($args, 'link_after') ? $args->link_after : '';
        $item_output .= '</a>';
        $item_output .= is_object($args) && property_exists($args, 'after') ? $args->after : '';

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $data_object, $depth, $args );
    }
}