<?php
/**
 * Divinize Setup
 * Setup plugin files
 *
 * @package  DivinizeSetup
 */

// exit when accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class DivinizeSetup {
	public $options;

	/**
	 * constructor
	 */
	function __construct() {
		$this->options = get_option( 'divinize' );
	}

	/**
	 * register plugin setup functions
	 *
	 * @return void
	 */
	function divinize_register() {
		add_filter( "plugin_action_links_divinize/Divinize.php", array( $this, 'divinize_add_settings_link' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'divinize_enqueue_admin_scripts' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'divinize_enqueue_frontend_scripts' ) );

		// require the dashbaord/menu files 
		require_once( DIVINIZE_PATH . 'inc/dashboard/dashboard.php' );
		
		// require widgets classes
		require_once( DIVINIZE_PATH . 'inc/widgets/DivinizeRecentPostsWidget.php' );
		require_once( DIVINIZE_PATH . 'inc/widgets/DivinizeTwitterFeedWidget.php' );

		// require features classes
		if ( $this->divinize_check_field( $this->options['enable_preloader'] ) ) {
			require_once( DIVINIZE_PATH . 'inc/features/DivinizePreloader.php' );
		}
		if ( $this->divinize_check_field( $this->options['enable_post_tags'] ) ) {
			require_once( DIVINIZE_PATH . 'inc/features/DivinizeSinglePostTags.php' );
		}
		if ( $this->divinize_check_field( $this->options['enable_author_box'] ) ) {
			require_once( DIVINIZE_PATH . 'inc/features/DivinizeAuthorBox.php' );
		}
		if ( $this->divinize_check_field( $this->options['enable_single_post_pagination'] ) ) {
			require_once( DIVINIZE_PATH . 'inc/features/DivinizeSinglePostPagination.php' );
		}
		if ( $this->divinize_check_field( $this->options['enable_related_posts'] ) ) {
			require_once( DIVINIZE_PATH . 'inc/features/DivinizeRelatedPosts.php' );
		}
		if ( $this->divinize_check_field( $this->options['enable_archive_blog_styles'] ) ) {
			require_once( DIVINIZE_PATH . 'inc/features/DivinizeArchiveBlogStyles.php' );
		}
		if ( $this->divinize_check_field( $this->options['remove_sidebar'] ) ) {
			require_once( DIVINIZE_PATH . 'inc/features/DivinizeRemoveSidebar.php' );
		}
	}

	/**
	 * add setting link in plugins page
	 *
	 * @return array
	 */
	function divinize_add_settings_link( $links ) {
		$settings = esc_html__( 'Settings', 'divinize' );
   		$links[] = '<a href="tools.php?page=divinize">' . $settings . '</a>';
		return $links;
	}

	/**
	 * load admin styles and scripts
	 *
	 * @return void
	 */
	function divinize_enqueue_admin_scripts() {
		$screen = get_current_screen();

		if ($screen->base == 'tools_page_divinize') {
			wp_enqueue_style( 'divinize-admin-styles', DIVINIZE_URL . 'assets/styles/admin-styles.css', array(), null );
			wp_enqueue_script( 'divinize-admin-scripts', DIVINIZE_URL . 'assets/scripts/admin-scripts.js', array( 'jquery' ), null );
			wp_enqueue_script( 'jquery-form' );
		}
	}

	/**
	 * load frontend styles and scripts
	 *
	 * @return void
	 */
	function divinize_enqueue_frontend_scripts() {
		$classes = get_body_class();

		if ( in_array( 'divinize-blog-grid', $classes ) || is_active_widget( false, false, 'divinize_twitter_feed', true ) || is_active_widget( false, false, 'divinize_recent_posts_widget', true ) || ( ( is_singular( 'post' ) ) && ( ( $this->options["enable_author_box"] == 1 ) || ( $this->options["enable_single_post_pagination"] == 1 ) || ($this->options["enable_related_posts"] == 1 ) || ( $this->options["enable_post_tags"] == 1 ) ) ) ) {
			wp_enqueue_style( 'divinize-frontend-styles', DIVINIZE_URL . 'assets/styles/frontend-styles.css' );
		}

		if ( is_singular( 'post' ) && ( $this->options["enable_post_tags"] == 1 ) && ( $this->options['post_tags_location'] == 0 ) ) {
			wp_enqueue_script( 'divinize-frontend-scripts', DIVINIZE_URL . 'assets/scripts/frontend-scripts.js', array( 'jquery' ), null );
		}

		if ( $this->options["enable_fontawesome"] == 1 ) {
			wp_enqueue_style( 'divinize-fontawesome', DIVINIZE_URL . 'assets/styles/font-awesome.min.css' );
		}
	}
     
	/**
	 * Check if the field is not empty and is enabled
	 *
	 * @return boolean
	 */
    function divinize_check_field( $field ) {
     	if ( ! empty( $field ) && $field !== '0' ) {
     		return true;
     	} else {
     		return false;
     	}
     }
}

if ( class_exists( 'DivinizeSetup' ) ) {
	$DivinizeSetup = new DivinizeSetup();
	$DivinizeSetup->divinize_register();
}