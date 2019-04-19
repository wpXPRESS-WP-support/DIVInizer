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
	public function __construct() {
		add_action( 'wp_footer', array( $this, 'divinizer_lightbox' ) );
	}

	/**
	 * append script to page/post
	 *
	 * @return string
	 */
	public function divinizer_lightbox() {
		?>
		<script type="text/javascript">
			(function ($) {
				$(document).ready(function () {
					$('.entry-content a').children('img').parent('a').addClass(function () {
						return (($(this).attr("href").split("?", 1)[0].match(/\.(jpeg|jpg|gif|png)$/) != null) ? "et_pb_lightbox_image" : "");
					});
				});
			})(jQuery)
		</script>
		<?php
	}
}

new DIVInizerLightBoxEverywhere();
