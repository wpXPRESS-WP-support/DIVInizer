<?php
/**
 * DIVInize Pre-loader
 * hides the pages with a pre-loader until the page is fully loaded
 *
 * @package  DIVInize/DivinizePreloader
 */

// exit when accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class DivinizePreloader {
	
	/**
	 * constructor
	 */
	function __construct() {
		add_action( 'wp_head', array( $this, 'divinize_preloader_output' ) );
	}

	/**
	 * outputs preloader code
	 *
	 * @return string
	 */
	function divinize_preloader_output() {
		if ( ! is_admin() ) {
			echo '<style>.divinize-spinner{position:absolute;top:52%;left:0;right:0;margin:auto;width:40px;height:40px;border-top:5px double #000;border-radius:100%;animation:spin 2s infinite cubic-bezier(0.23, 0.3, 0.7, 0.4);}@keyframes spin {from{transform:rotate(0deg);}to{transform:rotate(360deg);}}#overlay{position:fixed;background:#fff;z-index:99999;height:100%;width:100%;}</style>
			<div id="overlay"><div class="divinize-spinner"></div></div>
			<script>(function($){$(window).on("load",function(){var de_overlay=$("#overlay");if(de_overlay.length){de_overlay.delay(200).fadeOut(500);}});})(jQuery);</script>';
		}
	}
}

new DivinizePreloader();