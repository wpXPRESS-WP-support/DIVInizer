<?php
/**
 * DIVInize Archive Blog Styles
 * adds blog styles to the arrchive pages
 *
 * @package  DIVInize/DivinizeArchiveBlogStyles
 */

// exit when accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class DivinizeArchiveBlogStyles {

	/**
	 * constructor
	 */
	function __construct() {
		add_filter( 'body_class', array( $this, 'divinize_add_style_class' ) );	
	}

	/**
	 * adds to the body_class if option is enabled
	 *
	 * @return array
	 */
	function divinize_add_style_class( $classes ) {

		if ( is_category() || is_tag() || is_author() || is_search() || ( ! is_front_page() && is_home() ) ) {
			$classes[] = 'divinize-blog-grid';
		}

    	return $classes;
	}
}

new DivinizeArchiveBlogStyles();