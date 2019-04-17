<?php
/**
 * DIVInizer Lightbox
 * opens all images in posts or pages in a lightbox
 *
 * @package  DIVInizer/DIVInizerLightBoxEverywhere
 */

// exit when accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class DIVInizerLightBoxEverywhere {

	/**
	 * constructor
	 */
	function __construct() {
		add_action( 'wp_footer', array( $this, 'divinizer_lightbox') );	
	}

	/**
	 * append script to page/post
	 *
	 * @return string
	 */
	function divinizer_lightbox() {
		if ( is_singular() ) {
				?><script>(function($){
	$(document).ready(function(){
		$('.entry-content a').find('img').parent('a').addClass('et_pb_lightbox_image');
	});
})(jQuery)</script><?php
		}
	}
		
}

new DIVInizerLightBoxEverywhere();