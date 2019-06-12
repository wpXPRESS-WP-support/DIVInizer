<?php
/**
 * DIVInizer Footer Year Shortcode
 * Parse Divi footer content and replace [year] with the current year
 *
 * @package  DIVInizer/DIVInizerFooterYearShortcode
 */

// exit when accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class DIVInizerFooterYearShortcode {

	public $options;

	/**
	 * DIVInizerFooterYearShortcode constructor.
	 */
	public function __construct() {
		add_filter( 'et_get_option_et_divi_custom_footer_credits', array( $this, 'divinizer_maybe_render_year_shortcode' ) );
	}

	/**
	 * Replace any instances of [year] with the current year
	 *
	 * Hooked into the et_get_option_et_divi_custom_footer_credits filter
	 *
	 * @param $footer_content
	 *
	 * @return mixed
	 */
	public function divinizer_maybe_render_year_shortcode( $footer_content ) {
		return str_replace( '[year]', date( 'Y' ), $footer_content );
	}

}

new DIVInizerFooterYearShortcode();
