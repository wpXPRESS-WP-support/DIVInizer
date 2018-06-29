<?php
/**
 * DIVInize Single Post Tags
 * adds tags to single posts
 *
 * @package  DIVInize/DivinizeSinglePostTags
 */

// exit when accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class DivinizeSinglePostTags {
	public $options;

	/**
	 * constructor
	 */
	function __construct() {
		$this->options = get_option( 'divinize' );
		add_filter( 'the_content', array( $this, 'divinize_output_single_post_tags' ) );
	}

	/**
	 * adds tags html to the content
	 *
	 * @return string
	 */
	public function divinize_output_single_post_tags( $content ) {
		if ( is_singular('post') ) {
			$the_tags = get_the_tags();

			if ( ( $this->options['enable_post_tags'] == 1 ) && ! empty( $the_tags ) ) {
				$tags_above = '<div class="divinize-above-tags">| ';
				
				foreach ( $the_tags as $tag ) {
					$tags_above .=  ' <a href="';
					$tags_above .= get_tag_link($tag->term_id);
					$tags_above .= '">';
					$tags_above .= $tag->name;
					$tags_above .= '</a>';
				}

				$tags_above .= '</div>';
				$output = $tags_above . $content;

			} else if ( ( $this->options['enable_post_tags'] == 2 ) && ! empty( $the_tags ) ) {
				$tags_below = '<div class="divinize-below-tags">' . esc_html__( 'Tags:', 'divinize' );

				foreach ( $the_tags as $tag ) {
					$tags_below .=  ' <a href="';
					$tags_below .= get_tag_link($tag->term_id);
					$tags_below .= '">';
					$tags_below .= $tag->name;
					$tags_below .= '</a>';
				}

				$tags_below .= '</div>';

				$output = $content . $tags_below;
			}
			return $output;
		} else {
			return $content;
		}
	}
}

new DivinizeSinglePostTags();