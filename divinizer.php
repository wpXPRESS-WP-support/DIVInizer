<?php
/**
 * Plugin Name: DIVInizer
 * Plugin URI: http://divi-expand.wp-skill.com/
 * Description: A plugin that adds more functionlity to the Divi theme
 * Version: 0.1.2
 * Author: Jonathan Bossenger
 * Text Domain: divinizer
 * License: GPLv2 or later
 * @package DIVInizer
 *
 * This software is forked from the original [Expand Divi](https://wordpress.org/plugins/expand-divi/) plugin (c) Faycal Boutam
 * Lightbox functionality forked from [Surbma - Divi Lightbox] (https://wordpress.org/plugins/surbma-divi-lightbox/) plugin (c) Surbma
 */

/*
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// exit when accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * Simple error log
 */
function divinizer_debug( $message, $data = '' ) {
	if ( ! defined( 'DIVINIZER_DEBUG' ) || ! DIVINIZER_DEBUG ) {
		return;
	}
	$log_dir = trailingslashit( plugin_dir_path( __FILE__ ) ) . 'log/';
	if ( ! is_dir( $log_dir ) ) {
		mkdir( $log_dir );
	}
	$file = $log_dir . date( 'Y-m-d' ) . '.log';
	if ( ! is_file( $file ) ) {
		file_put_contents( $file, '' );
	}
	if ( ! empty( $data ) ) {
		$message = array( $message => $data );
	}
	$data_string = print_r( $message, true ) . "\n";
	file_put_contents( $file, $data_string, FILE_APPEND );
}

define( 'DIVINIZER_DEBUG', true );

// define plugin url constant
if ( ! defined( 'DIVINIZER_URL' ) ) {
	define( 'DIVINIZER_URL', plugin_dir_url( __FILE__ ) );
}

// define plugin path constant
if ( ! defined( 'DIVINIZER_PATH' ) ) {
	define( 'DIVINIZER_PATH', plugin_dir_path( __FILE__ ) );
}

// require setup class
require_once DIVINIZER_PATH . 'inc/DIVInizerSetup.php';

// localization
function divinizer_localization() {
	load_plugin_textdomain( 'divinizer', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
}

add_action( 'init', 'divinizer_localization' );
