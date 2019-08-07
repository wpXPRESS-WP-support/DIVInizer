<?php
/**
 * DIVInizer Disable Featured Image Cropping
 * Disabled Divi's Featured Image Cropping
 *
 * @package  DIVInizer/DIVInizerDisableFeaturedImageCropping
 */

// exit when accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class DIVInizerDisableFeaturedImageCropping {

	public $options;

	/**
	 * DIVInizerFooterYearShortcode constructor.
	 */
	public function __construct() {
		add_filter( 'et_theme_image_sizes', array( $this, 'divinizer_remove_featured_post_cropping' ) );
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
	public function divinizer_remove_featured_post_cropping( $sizes ) {
		if ( isset( $sizes['1080x675'] ) ) {
			unset( $sizes['1080x675'] );
			$sizes['1080x9998'] = 'et-pb-post-main-image-fullwidth';
		}

		return $sizes;
	}

}

new DIVInizerDisableFeaturedImageCropping();
