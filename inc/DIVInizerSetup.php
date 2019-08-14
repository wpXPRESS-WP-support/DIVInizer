<?php
/**
 * DIVInizer Setup
 * Setup plugin files
 *
 * @package  DIVInizerSetup
 */

// exit when accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class DIVInizerSetup {
	public $options;

	/**
	 * constructor
	 */
	public function __construct() {
		$this->options = get_option( 'divinizer' );
	}

	/**
	 * register plugin setup functions
	 *
	 * @return void
	 */
	public function divinizer_register() {
		add_filter( 'plugin_action_links_DIVInizer/divinizer.php', array( $this, 'divinizer_add_settings_link' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'divinizer_enqueue_admin_scripts' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'divinizer_enqueue_frontend_scripts' ) );

		// require the dashboard/menu files
		require_once DIVINIZER_PATH . 'inc/dashboard/dashboard.php';

		// require widgets classes
		require_once DIVINIZER_PATH . 'inc/widgets/DIVInizerRecentPostsWidget.php';
		require_once DIVINIZER_PATH . 'inc/widgets/DIVInizerTwitterFeedWidget.php';

		// require features classes
		if ( $this->divinizer_check_field( $this->options['enable_post_tags'] ) ) {
			require_once DIVINIZER_PATH . 'inc/features/DIVInizerSinglePostTags.php';
		}
		if ( isset( $this->options['enable_author_box'] ) && $this->divinizer_check_field( $this->options['enable_author_box'] ) ) {
			require_once DIVINIZER_PATH . 'inc/features/DIVInizerAuthorBox.php';
		}
		if ( isset( $this->options['enable_single_post_pagination'] ) && $this->divinizer_check_field( $this->options['enable_single_post_pagination'] ) ) {
			require_once DIVINIZER_PATH . 'inc/features/DIVInizerSinglePostPagination.php';
		}
		if ( $this->divinizer_check_field( $this->options['enable_related_posts'] ) ) {
			require_once DIVINIZER_PATH . 'inc/features/DIVInizerRelatedPosts.php';
		}
		if ( isset( $this->options['enable_archive_blog_styles'] ) && $this->divinizer_check_field( $this->options['enable_archive_blog_styles'] ) ) {
			require_once DIVINIZER_PATH . 'inc/features/DIVInizerArchiveBlogStyles.php';
		}
		if ( $this->divinizer_check_field( $this->options['remove_sidebar'] ) ) {
			require_once DIVINIZER_PATH . 'inc/features/DIVInizerRemoveSidebar.php';
		}
		if ( isset( $this->options['enable_lightbox_everywhere'] ) && $this->divinizer_check_field( $this->options['enable_lightbox_everywhere'] ) ) {
			require_once DIVINIZER_PATH . 'inc/features/DIVInizerLightBoxEverywhere.php';
		}
		if ( isset( $this->options['enable_year_shortcode'] ) && $this->divinizer_check_field( $this->options['enable_year_shortcode'] ) ) {
			require_once DIVINIZER_PATH . 'inc/features/DIVInizerFooterYearShortcode.php';
		}
		if ( isset( $this->options['featured_image_cropping'] ) && ! $this->divinizer_check_field( $this->options['featured_image_cropping'] ) ) {
			require_once DIVINIZER_PATH . 'inc/features/DIVInizerDisableFeaturedImageCropping.php';
		}

	}

	/**
	 * add setting link in plugins page
	 *
	 * @return array
	 */
	public function divinizer_add_settings_link( $links ) {
		$settings = esc_html__( 'Settings', 'divinizer' );
		$links[]  = '<a href="admin.php?page=divinizer">' . $settings . '</a>';

		return $links;
	}

	/**
	 * load admin styles and scripts
	 *
	 * @return void
	 */
	public function divinizer_enqueue_admin_scripts() {
		$screen = get_current_screen();

		if ( $screen->base === 'divi_page_divinizer' ) {
			wp_enqueue_style( 'divinizer-admin-styles', DIVINIZER_URL . 'assets/styles/admin-styles.css', array(), null );
			wp_enqueue_script( 'divinizer-admin-scripts', DIVINIZER_URL . 'assets/scripts/admin-scripts.js', array( 'jquery' ), null );
			wp_enqueue_script( 'jquery-form' );
		}
	}

	/**
	 * load frontend styles and scripts
	 *
	 * @return void
	 */
	public function divinizer_enqueue_frontend_scripts() {

		if ( $this->enable_stylesheet() ) {
			wp_enqueue_style( 'divinizer-frontend-styles', DIVINIZER_URL . 'assets/styles/frontend-styles.css', array(), DIVINIZER_VERSION );
		}

		if ( is_singular( 'post' ) && ( 1 === $this->options['enable_post_tags'] ) && ( 0 === $this->options['post_tags_location'] ) ) {
			wp_enqueue_script( 'divinizer-frontend-scripts', DIVINIZER_URL . 'assets/scripts/frontend-scripts.js', array( 'jquery' ), DIVINIZER_VERSION, true );
		}

		/*
		if ( $this->options["enable_fontawesome"] == 1 ) {
			wp_enqueue_style( 'divinizer-fontawesome', DIVINIZER_URL . 'assets/styles/font-awesome.min.css' );
		}
		*/
	}

	public function enable_stylesheet() {
		$classes = get_body_class();

		if ( in_array( 'divinizer-blog-grid', $classes, true ) ) {
			return true;
		}

		if ( in_array( 'divinizer-sidebar-global-remove', $classes, true ) ) {
			return true;
		}

		if ( in_array( 'divinizer-sidebar-posts-remove', $classes, true ) ) {
			return true;
		}

		if ( in_array( 'divinizer-sidebar-archive-remove', $classes, true ) ) {
			return true;
		}

		if ( is_active_widget( false, false, 'divinizer_twitter_feed', true ) ) {
			return true;
		}

		if ( is_active_widget( false, false, 'divinizer_recent_posts_widget', true ) ) {
			return true;
		}

		if ( ! is_singular( 'post' ) ) {
			return false;
		}

		if ( 1 === $this->options['enable_author_box'] ) {
			return true;
		}
		if ( 1 === $this->options['enable_single_post_pagination'] ) {
			return true;
		}
		if ( 1 === $this->options['enable_related_posts'] ) {
			return true;
		}
		if ( 1 === $this->options['enable_post_tags'] ) {
			return true;
		}

		return false;
	}

	/**
	 * Check if the field is not empty and is enabled
	 *
	 * @return boolean
	 */
	public function divinizer_check_field( $field ) {
		if ( ! empty( $field ) && $field !== '0' ) {
			return true;
		} else {
			return false;
		}
	}
}

if ( class_exists( 'DIVInizerSetup' ) ) {
	$DIVInizerSetup = new DIVInizerSetup();
	$DIVInizerSetup->divinizer_register();
}
