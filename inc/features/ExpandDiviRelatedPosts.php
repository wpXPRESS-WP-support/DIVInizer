<?php
/**
 * Expand Divi Related Posts
 * adds related posts to single posts
 *
 * @package  ExpandDivi/ExpandDiviRelatedPosts
 */

// exit when accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ExpandDiviRelatedPosts {
	
	/**
	 * constructor
	 */
	function __construct() {
		add_filter( 'the_content', array( $this, 'expand_divi_output_related_posts' ) );	
	}

	/**
	 * append related posts html to the content
	 *
	 * @return string
	 */
	function expand_divi_output_related_posts( $content ) {

		if ( is_singular('post') ) {
			global $post;
			$post_id = get_the_ID();
			$terms = get_the_terms( $post_id, 'post_tag' );

			$term_ids = array();
			if ( is_array( $terms ) ) {
				foreach ( $terms as $term ) {
					$term_ids[] = $term->term_id;
				}
			}

			$query = new WP_Query( array(
				'tax_query'      => array(
					array(
						'taxonomy' => 'post_tag',
						'field'    => 'id',
						'terms'    => $term_ids,
						'operator' => 'IN',
					),
				),
				'post_type'      => 'post',
				'posts_per_page' => '3',
				'orderby'        => 'rand',
				'post__not_in'   => array( $post_id ),
			) );

			if ( $query->have_posts() ) :
				$html = '<div class="expand_divi_related_posts"><h2 class="expand_divi_related_posts_title">';
				$html.= esc_html__( 'You Might Also Like:', 'expand-divi' ); 
				$html.= '</h2>';

				while ( $query->have_posts() ) : $query->the_post();
					$html .= '<div class="expand_divi_related_post"><a href="';
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
				$html = '<p class="expand_divi_no_related_posts">';
				$html .= esc_html__( 'No related posts!', 'expand-divi' );
				$html .= '</p>';
			endif;
			
			wp_reset_postdata();

			return $content . $html;
		} else {
			return $content;
		}
	}
}

new ExpandDiviRelatedPosts();