<?php
/**
 * DIVInize Lightbox
 * Adds Divi's native lightbox effect to images.
 *
 * @package  DIVInize/DivinizeLightbox
 */

// exit when accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class DivinizeLightbox {
	
	/**
	 * constructor
	 */
	function __construct() {
		add_action( 'wp_footer', array( $this, 'divinize_lightbox_js') );
	}
	/**
	 *
	 *
	 * @return string
	 */
	function divinize_lightbox_js() {
		?><script type="text/javascript">(function($){$(document).ready(function(){$('.entry-content a').children('img').parent('a').addClass(function(){return(($(this).attr("href").split("?",1)[0].match(/\.(jpeg|jpg|gif|png)$/) != null) ? "et_pb_lightbox_image" : "");});});})(jQuery)</script>
		<?php
	}
}

new DivinizeLightbox();