<?php
/**
 * DIVInizer Related Posts
 * adds related posts to single posts
 *
 * @package  DIVInizer/DIVInizerRelatedPosts
 */

// exit when accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class DIVInizerRelatedPosts {

	private $type = '';

	/**
	 * constructor
	 */
	public function __construct() {
		$options = get_option( 'divinizer' );
		// Checking against integers because the options are saved from the field select array keys, not the values
		// 1 = Tags and 2 = Categories
		$this->type = ( 2 === intval( $options['enable_related_posts'] ) ) ? 'categories' : 'tags';
		add_filter( 'the_content', array( $this, 'divinizer_output_related_posts' ) );
	}

	/**
	 * Built the WP_Query object based on the type stored on the class
	 *
	 * @return WP_Query
	 */
	public function build_related_query() {
		$taxonomy = 'post_tag';
		if ( 'categories' === $this->type ) {
			$taxonomy = 'category';
		}

		$post_id = get_the_ID();
		$terms   = get_the_terms( $post_id, $taxonomy );

		$term_ids = array();
		if ( is_array( $terms ) ) {
			foreach ( $terms as $term ) {
				$term_ids[] = $term->term_id;
			}
		}

		$query = new WP_Query(
			array(
				'tax_query'      => array(
					array(
						'taxonomy' => $taxonomy,
						'field'    => 'id',
						'terms'    => $term_ids,
						'operator' => 'IN',
					),
				),
				'post_type'      => 'post',
				'posts_per_page' => '3',
				'orderby'        => 'rand',
				'post__not_in'   => array( $post_id ),
			)
		);

		return $query;
	}

	/**
	 * append related posts html to the content
	 *
	 * @return string
	 */
	public function divinizer_output_related_posts( $content ) {

		if ( is_singular( 'post' ) ) {

			$query = $this->build_related_query();

			if ( ( $query->have_posts() ) ) {
				$html = '<div class="divinizer_related_posts"><h2 class="divinizer_related_posts_title">';
				$html .= esc_html__( 'You Might Also Like:', 'divinizer' );
				$html .= '</h2>';

				while ( $query->have_posts() ) {
					$query->the_post();
					$html .= '<div class="divinizer_related_post"><a href="';
					$html .= get_the_permalink();
					$html .= '">';
					$html .= get_the_post_thumbnail();
					$html .= '</a><h4><a href="';
					$html .= get_the_permalink();
					$html .= '">';
					$html .= get_the_title();
					$html .= '</a></h4></div>';
				}

				$html .= '</div>';
			} else {
				$html = '<p class="divinizer_no_related_posts">';
				$html .= esc_html__( 'No related posts!', 'divinizer' );
				$html .= '</p>';
			}

			wp_reset_postdata();

			return $content . $html;
		} else {
			return $content;
		}
	}
}

new DIVInizerRelatedPosts();
