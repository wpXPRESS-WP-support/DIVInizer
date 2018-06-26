<?php
/**
 * Plugin Name: DIVInize
 * Plugin URI: https://wordx.pres/divinize/
 * Description: Adds more functionality to Divi Theme
 * Version: 1.0
 * Author: WordXpress
 * Text Domain: DIVInize
 * License: GPLv2 or later
 * @package DIVInize
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

// define plugin url constant
if ( ! defined( 'DIVINIZE_URL' ) ) {
	define( 'DIVINIZE_URL', plugin_dir_url( __FILE__ ) );
}

// define plugin path constant
if ( ! defined( 'DIVINIZE_PATH' ) ) {
	define( 'DIVINIZE_PATH', plugin_dir_path( __FILE__ ) );
}

// require setup class
require_once( DIVINIZE_PATH . 'inc/DIVInizeSetup.php' );

// localization
function divinize_localization() {
	load_plugin_textdomain( 'divinize', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
}
add_action('init', 'divinize_localization');