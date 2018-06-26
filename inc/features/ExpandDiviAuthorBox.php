<?php
/**
 * Expand Divi Author Box
 * adds the author box in single posts
 *
 * @package  ExpandDivi/ExpandDiviAuthorBox
 */

// exit when accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ExpandDiviAuthorBox {

	/**
	 * constructor
	 */
	function __construct() {
		add_filter( 'the_content', array( $this, 'expand_divi_output_author_box' ) );	
	}

	/**
	 * append author box html to the content
	 *
	 * @return string
	 */
	function expand_divi_output_author_box( $content ) {
		if ( is_singular('post') ) {
			$de_author_name = get_the_author();
			$de_author_id = get_the_author_meta('ID');
			$de_author_avatar = get_avatar( $de_author_id );
			$de_author_description = get_the_author_meta('description');

			$content .= '<div class="expand_divi_author_box">';
				$content .= '<div class="expand_divi_author_avatar">' . $de_author_avatar . '</div>';
				$content .= '<div class="expand_divi_author_bio_wrap">';
					$content .= '<h3 class="expand_divi_author_name">' . $de_author_name . '</h3>';
					$content .= '<div class="expand_divi_author_bio">' . $de_author_description . '</div>';
				$content .= '</div>';
			$content .= '</div>';
		}

		return $content;
	}
}

new ExpandDiviAuthorBox();