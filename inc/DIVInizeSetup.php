<?php
/**
 * Expand Divi Setup
 * Setup plugin files
 *
 * @package  ExpandDiviSetup
 */

// exit when accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ExpandDiviSetup {
	public $options;

	/**
	 * constructor
	 */
	function __construct() {
		$this->options = get_option( 'expand_divi' );
	}

	/**
	 * register plugin setup functions
	 *
	 * @return void
	 */
	function expand_divi_register() {
		add_filter( "plugin_action_links_expand-divi/expand-divi.php", array( $this, 'expand_divi_add_settings_link' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'expand_divi_enqueue_admin_scripts' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'expand_divi_enqueue_frontend_scripts' ) );

		// require the dashbaord/menu files 
		require_once( EXPAND_DIVI_PATH . 'inc/dashboard/dashboard.php' );
		
		// require widgets classes
		require_once( EXPAND_DIVI_PATH . 'inc/widgets/ExpandDiviRecentPostsWidget.php' );
		require_once( EXPAND_DIVI_PATH . 'inc/widgets/ExpandDiviTwitterFeedWidget.php' );

		// require features classes
		if ( $this->expand_divi_check_field( $this->options['enable_preloader'] ) ) {
			require_once( EXPAND_DIVI_PATH . 'inc/features/ExpandDiviPreloader.php' );
		}
		if ( $this->expand_divi_check_field( $this->options['enable_post_tags'] ) ) {
			require_once( EXPAND_DIVI_PATH . 'inc/features/ExpandDiviSinglePostTags.php' );
		}
		if ( $this->expand_divi_check_field( $this->options['enable_author_box'] ) ) {
			require_once( EXPAND_DIVI_PATH . 'inc/features/ExpandDiviAuthorBox.php' );
		}
		if ( $this->expand_divi_check_field( $this->options['enable_single_post_pagination'] ) ) {
			require_once( EXPAND_DIVI_PATH . 'inc/features/ExpandDiviSinglePostPagination.php' );
		}
		if ( $this->expand_divi_check_field( $this->options['enable_related_posts'] ) ) {
			require_once( EXPAND_DIVI_PATH . 'inc/features/ExpandDiviRelatedPosts.php' );
		}
		if ( $this->expand_divi_check_field( $this->options['enable_archive_blog_styles'] ) ) {
			require_once( EXPAND_DIVI_PATH . 'inc/features/ExpandDiviArchiveBlogStyles.php' );
		}
		if ( $this->expand_divi_check_field( $this->options['remove_sidebar'] ) ) {
			require_once( EXPAND_DIVI_PATH . 'inc/features/ExpandDiviRemoveSidebar.php' );
		}
	}

	/**
	 * add setting link in plugins page
	 *
	 * @return array
	 */
	function expand_divi_add_settings_link( $links ) {
		$settings = esc_html__( 'Settings', 'expand-divi' );
   		$links[] = '<a href="tools.php?page=expand-divi">' . $settings . '</a>';
		return $links;
	}

	/**
	 * load admin styles and scripts
	 *
	 * @return void
	 */
	function expand_divi_enqueue_admin_scripts() {
		$screen = get_current_screen();

		if ($screen->base == 'tools_page_expand-divi') {
			wp_enqueue_style( 'expand-divi-admin-styles', EXPAND_DIVI_URL . 'assets/styles/admin-styles.css', array(), null );
			wp_enqueue_script( 'expand-divi-admin-scripts', EXPAND_DIVI_URL . 'assets/scripts/admin-scripts.js', array( 'jquery' ), null );
			wp_enqueue_script( 'jquery-form' );
		}
	}

	/**
	 * load frontend styles and scripts
	 *
	 * @return void
	 */
	function expand_divi_enqueue_frontend_scripts() {
		$classes = get_body_class();

		if ( in_array( 'expand-divi-blog-grid', $classes ) || is_active_widget( false, false, 'expand_divi_twitter_feed', true ) || is_active_widget( false, false, 'expand_divi_recent_posts_widget', true ) || ( ( is_singular( 'post' ) ) && ( ( $this->options["enable_author_box"] == 1 ) || ( $this->options["enable_single_post_pagination"] == 1 ) || ($this->options["enable_related_posts"] == 1 ) || ( $this->options["enable_post_tags"] == 1 ) ) ) ) {
			wp_enqueue_style( 'expand-divi-frontend-styles', EXPAND_DIVI_URL . 'assets/styles/frontend-styles.css' );
		}

		if ( is_singular( 'post' ) && ( $this->options["enable_post_tags"] == 1 ) && ( $this->options['post_tags_location'] == 0 ) ) {
			wp_enqueue_script( 'expand-divi-frontend-scripts', EXPAND_DIVI_URL . 'assets/scripts/frontend-scripts.js', array( 'jquery' ), null );
		}

		if ( $this->options["enable_fontawesome"] == 1 ) {
			wp_enqueue_style( 'expand-divi-fontawesome', EXPAND_DIVI_URL . 'assets/styles/font-awesome.min.css' );
		}
	}
     
	/**
	 * Check if the field is not empty and is enabled
	 *
	 * @return boolean
	 */
    function expand_divi_check_field( $field ) {
     	if ( ! empty( $field ) && $field !== '0' ) {
     		return true;
     	} else {
     		return false;
     	}
     }
}

if ( class_exists( 'ExpandDiviSetup' ) ) {
	$ExpandDiviSetup = new ExpandDiviSetup();
	$ExpandDiviSetup->expand_divi_register();
}