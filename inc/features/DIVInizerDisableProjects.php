<?php
/**
 * DIVInizer Disable Projects
 * Disables the Projects CPT
 *
 * @package  DIVInizer/DIVInizerDisableProjects
 */

// exit when accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class DIVInizerDisableProjects {

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
		add_action( 'init', array( $this, 'unregister_projects' ), 10 );
	}

	/**
	 * adds to the body_class if option is enabled
	 *
	 * @return array
	 */
	public function unregister_projects() {
		unregister_post_type( 'project' );
		unregister_taxonomy( 'project_category' );
		unregister_taxonomy( 'project_tag' );
	}
}

new DIVInizerDisableProjects();
