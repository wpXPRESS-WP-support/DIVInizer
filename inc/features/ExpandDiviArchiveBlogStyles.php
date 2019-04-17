<?php
/**
 * Expand Divi Archive Blog Styles
 * adds blog styles to the arrchive pages
 *
 * @package  ExpandDivi/ExpandDiviArchiveBlogStyles
 */

// exit when accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ExpandDiviArchiveBlogStyles {

	/**
	 * constructor
	 */
	function __construct() {
		add_filter( 'body_class', array( $this, 'expand_divi_add_style_class' ) );	
	}

	/**
	 * adds to the body_class if option is enabled
	 *
	 * @return array
	 */
	function expand_divi_add_style_class( $classes ) {

		if ( is_category() || is_tag() || is_author() || is_search() || ( ! is_front_page() && is_home() ) ) {
			$classes[] = 'expand-divi-blog-grid';
		}

    	return $classes;
	}
}

new ExpandDiviArchiveBlogStyles();