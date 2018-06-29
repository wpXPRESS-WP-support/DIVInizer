<?php
/**
 * DIVInize Single Post Pagination
 * adds a pagination to single posts
 *
 * @package  DIVInize/DivinizeiSinglePostPagination
 */

// exit when accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class DivinizeSinglePostPagination {

	/**
	 * constructor
	 */
	function __construct() {
		add_filter( 'the_content', array( $this, 'divinize_output_pagination' ) );	
	}

	/**
	 * append pagination html to the content
	 *
	 * @return string
	 */
	function divinize_output_pagination( $content ) {
		if ( is_singular('post') ) {
			$html .= '<div class="nav-single clearfix">';
				$html .= '<span class="nav-previous">';
				$html .= get_previous_post_link( '%link', '<span class="meta-nav">' . et_get_safe_localization( _x( '&larr;', 'Previous post link', 'divinize' ) ) . 
					'</span> %title' );
				$html .= '</span>';
			$html .= '<span class="nav-next">';
				$html .= get_next_post_link( '%link', '%title <span class="meta-nav">' . et_get_safe_localization( _x( '&rarr;', 'Next post link', 'divinize' ) ) . '</span>' );
			$html .= '</span></div><!-- .nav-single -->';
		}

		return $content . $html;
	}
}

new DivinizeSinglePostPagination();