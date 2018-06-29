<?php
/**
 * DIVInize Related Posts
 * adds related posts to single posts
 *
 * @package  DIVInize/DivinizeRelatedPosts
 */

// exit when accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class DivinizeRelatedPosts {
	
	/**
	 * constructor
	 */
	function __construct() {
		add_filter( 'the_content', array( $this, 'divinize_output_related_posts' ) );	
	}

	/**
	 * append related posts html to the content
	 *
	 * @return string
	 */
	function divinize_output_related_posts( $content ) {

		if ( is_singular('post') ) {
			global $post;
			$post_id = get_the_ID();
			$post_tags = wp_get_post_tags( $post->ID );
			$first_post_tag = $post_tags[0]->term_id;

			$query = new WP_Query(
				$args = [
					'tag__in' => array( $first_post_tag ),
					'post__not_in'   => array( $post_id ),
					'post_type'      => 'post',
					'posts_per_page' => '3',
					'orderby'        => 'rand'
				]
			);

			if ( $query->have_posts() ) :
				$html .= '<div class="divinize_related_posts"><h2 class="divinize_related_posts_title">';
				$html.= esc_html__( 'You Might Also Like:', 'divinize' ); 
				$html.= '</h2>';

				while ( $query->have_posts() ) : $query->the_post();
					$html .= '<div class="divinize_related_post"><a href="';
					$html .= get_the_permalink();
					$html .= '">';
					$html .= get_the_post_thumbnail();
					$html .= '</a><h4><a href="';
					$html .= get_the_permalink();
					$html .= '">';
					$html .= get_the_title();
					$html .= '</a></h4></div>';
				endwhile;

				$html .= '</div>';
				else:
				$html .= '<p class="divinize_no_related_posts">';
				$html .= esc_html__( 'No related posts!', 'divinize' );
				$html .= '</p>';
			endif;
			
			wp_reset_postdata();
		}
		return $content . $html;
	}
}

new DivinizeRelatedPosts();