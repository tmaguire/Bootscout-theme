<?php
/*
 * Navbar walker nav menu
 */

class b4st_walker_nav_menu extends Walker_Nav_menu {

	function start_lvl( &$output, $depth = 0, $args = array() ){ // ul
		$indent = str_repeat("\t",$depth); // indents the outputted HTML
		$submenu = ($depth > 0) ? ' sub-menu' : '';
		// if menu is a sub menu then add class dropdown-menu-sub
		$output .= ( $depth > 0 ) ? "\n$indent<ul class=\"dropdown-menu$submenu depth_$depth dropdown-menu-sub\">\n" : "\n$indent<ul class=\"dropdown-menu$submenu depth_$depth\">\n";
	}

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ){ // li a span

		$indent = ( $depth ) ? str_repeat("\t",$depth) : '';
		$options = get_option('scout_theme_options');

		$li_attributes = '';
		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		$classes[] = ($args->walker->has_children) ? 'dropdown' : '';
		$classes[] = ($item->current || $item->current_item_ancestor) ? 'active' : '';
		$classes[] = 'nav-item';
		$classes[] = 'nav-item-' . $item->ID;
		if( $depth && $args->walker->has_children ){
			$classes[] = 'dropdown-menu-right dropdown-submenu';
		}

		$class_names =  join(' ', apply_filters('nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = ' class="' . esc_attr($class_names) . '"';

		$id = apply_filters('nav_menu_item_id', 'menu-item-'.$item->ID, $item, $args);
		$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li ' . $id . $value . $class_names . $li_attributes . '>';

		$attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
		$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr($item->target) . '"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
		$attributes .= ! empty( $item->url ) ? ' href="' . esc_attr($item->url) . '"' : '';

		$link_text_colour = get_navbar_text_colour($options['navColour']);

		$attributes .= ( $args->walker->has_children ) ? ' class="link-text-'.$link_text_colour.' nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"' : ' class="link-text-'.$link_text_colour.' nav-link"';


		$item_output = $args->before;
		// style link depending if link is just a link, opens a menu or opens a sub menu
		if ($depth > 0) {
			// get bg colour of menu items on focus
			$focus_colour = get_navbar_reverse_colour($options['navColour']);

			if ($args->walker->has_children != true) {
				$item_output .= '<a class="dropdown-item dropdown-item-scout-'. $focus_colour .'"' . $attributes . '>';
			} else {
				# This menu item will act as a dropdown and a link
				$item_output .= '<a class="dropdown-item dropdown-item-scout-'. $focus_colour .' dropdown-toggle"' . (! empty( $item->url ) ? ' href="' . esc_attr($item->url) . '"' : '') . '>';
			}

		} else {
			$item_output .= '<a' . $attributes . '>';
		}
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters ( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

	}

}

/*
Register Navbar
*/

register_nav_menu('navbar', __('Navbar', 'b4st'));


function get_navbar_text_colour($navColour) {
	if ($navColour == 'teal') {
		return 'white';
	} else if ($navColour == 'red') {
		return 'white';
	} else if ($navColour == 'pink') {
		return 'grey-80';
	} else if ($navColour == 'green') {
		return 'white';
	} else if ($navColour == 'navy') {
		return 'white';
	} else if ($navColour == 'blue') {
		return 'white';
	} else if ($navColour == 'yellow') {
		return 'grey-80';
	} else if ($navColour == 'white') {
		return 'grey-80';
	} else if ($navColour == 'black') {
		return 'white';
	} else {  // navbar colour is either not set or purple
		return 'white';
	}
}
