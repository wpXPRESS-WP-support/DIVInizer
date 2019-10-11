<?php
/**
 * DIVInizer Remove Sidebar
 * removes the sidebar from posts, archive pages or globally
 *
 * @package  DIVInizer/DIVInizerRemoveSidebar
 */

// exit when accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class DIVInizerRemoveSidebar {

	/**
	 * Options array
	 *
	 * @var mixed|void
	 */
	public $options;

	/**
	 * constructor
	 */
	public function __construct() {
		$this->options = get_option( 'divinizer' );
		add_filter( 'body_class', array( $this, 'divinizer_remove_sidebar' ) );
	}

	/**
	 * adds to the body_class if option is enabled
	 *
	 * @return array
	 */
	public function divinizer_remove_sidebar( $classes ) {
		switch ( $this->options['remove_sidebar'] ) {
			case '1':
				if ( is_category() || is_tag() || is_author() || is_search() || ( ! is_front_page() && is_home() ) || is_single() ) {
					$classes[] = 'divinizer-sidebar-global-remove';
				}
				break;
			case '2':
				if ( is_single() ) {
					$classes[] = 'divinizer-sidebar-global-remove';
				}
				break;
			case '3':
				if ( is_category() || is_tag() || is_author() || is_search() || ( ! is_front_page() && is_home() ) ) {
					$classes[] = 'divinizer-sidebar-archive-remove';
				}
				break;
		}

		return $classes;
	}
}

new DIVInizerRemoveSidebar();
