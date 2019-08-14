<?php
/**
 * DIVInizer Dashboard
 * Setup dashboard sections and fields
 *
 * @package  DIVInizerDashboard
 */

// exit when accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class DIVInizerDashboard {
	private $divinizer_sections;
	private $divinizer_fields;

	public function __construct() {
		// the sections array
		$this->divinizer_sections = [
			'general' => [
				'title' => '',
			],
		];

		// the fields array
		$this->divinizer_fields = [
			/*'enable_fontawesome'            => [
				'title'    => 'Fontawesome',
				'type'     => 'select',
				'section'  => 'general',
				'default'  => 0,
				'children' => [ 'Disabled', 'Enabled' ],
			],*/
			'enable_author_box'             => [
				'title'    => 'Author Box',
				'type'     => 'checkbox',
				'section'  => 'general',
				'default'  => 0,
				//'children' => [ 'Disabled', 'Enabled' ],
			],
			'enable_single_post_pagination' => [
				'title'    => 'Single Post Pagination',
				'type'     => 'checkbox',
				'section'  => 'general',
				'default'  => 0,
				//'children' => [ 'Disabled', 'Enabled' ],
			],
			'enable_related_posts'          => [
				'title'    => 'Related Posts',
				'type'     => 'select',
				'section'  => 'general',
				'default'  => 0,
				'children' => [ 'Disabled', 'Tags', 'Categories' ],
			],
			'enable_post_tags'              => [
				'title'    => 'Post Tags',
				'type'     => 'select',
				'section'  => 'general',
				'default'  => 0,
				'children' => [ 'Disabled', 'Above Content', 'Below Content' ],
			],
			'enable_lightbox_everywhere'    => [
				'title'    => 'Lightbox for posts and pages',
				'type'     => 'checkbox',
				'section'  => 'general',
				'default'  => 0,
				//'children' => [ 'Disabled', 'Enabled' ],
			],
			'enable_archive_blog_styles'    => [
				'title'    => 'Archive Blog Styles',
				'type'     => 'select',
				'section'  => 'general',
				'default'  => 0,
				'children' => [ 'Disabled', 'Grid' ],
			],
			'remove_sidebar'                => [
				'title'    => 'Remove Sidebar',
				'type'     => 'select',
				'section'  => 'general',
				'default'  => 0,
				'children' => [ 'Disabled', 'Globally', 'Posts Only', 'Archive Pages Only' ],
			],
			'enable_year_shortcode'         => [
				'title'    => 'Footer year shortcode',
				'type'     => 'checkbox',
				'section'  => 'general',
				'default'  => 0,
				//'children' => [ 'Disabled', 'Enabled' ],
			],
			'featured_image_cropping'       => [
				'title'    => 'Featured Image Cropping',
				'type'     => 'checkbox',
				'section'  => 'general',
				'default'  => 1,
				//'children' => [ 'Disabled', 'Enabled' ],
			],
		];

		add_action( 'admin_menu', array( $this, 'add_divinizer_menu' ), 11 );
		add_action( 'admin_init', array( $this, 'register_dashboard' ) );
	}

	public function add_divinizer_menu() {
		add_submenu_page(
			'et_divi_options',
			esc_html__( 'DIVInizer', 'divinizer' ),
			esc_html__( 'DIVInizer', 'divinizer' ),
			'manage_options',
			'divinizer',
			array(
				$this,
				'divinizer_dashboard_output',
			)
		);
	}

	public function divinizer_dashboard_output() {
		// check if the user is admin
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have permission to access this page!', 'divinizer' ) );
		} ?>

		<!-- dashboard interface -->
		<div id="divinizer_wrap" class="divinizer-settings">
			<h1><?php esc_html_e( 'DIVInizer Options', 'divinizer' ); ?></h1>
			<h2>How it Works: the below settings are applied to posts and pages that do not use the Divi Builder. For example, if you prefer to blog using the WordPress Classic Editor or new Block Editor, these settings will be applied to those posts.</h2>
			<?php settings_errors(); ?>
			<form method="post" action="options.php" id="divinizer_form">
				<div class="divinizer_sections_wrap">
					<?php
					settings_fields( 'divinizer' );
					do_settings_sections( 'divinizer' );
					?>
				</div>
				<?php submit_button(); ?>
				<div id="divinizer_save"></div>
			</form>
		</div>
		<div id="divinizer_sidebar" class="divinizer-settings">
			<h1><?php esc_html_e( 'Need Help With Divi?', 'divinizer' ); ?></h1>
			<h1><?php esc_html_e( 'Site Maintenance Too Much Hassle?', 'divinizer' ); ?></h1>
			<img src="<?php echo DIVINIZER_URL ?>/assets/images/WordXpress-logo-med.png">
			<p class="large">Check out WordXpress!</p>
			<p class="large"><i><strong>We make your life easier</strong> by supporting and maintaining your Divi + WordPress website.</i></p>
			<ul class="large">
				<li>Save time with content edits, updates, changes and support by Divi experts.</li>
				<li>Increase leads and sales with premium SEO and review marketing plugins.</li>
				<li>Add peace of mind with backups, monitoring, security, and more.</li>
			</ul>
			<p>Features Include</p>
			<ul>
				<li>A team of experts in both Divi & WordPress helping you.</li>
				<li>Those same experts making changes & edits for you.</li>
				<li>Maintenance, updates, backups, and monitoring.</li>
				<li>Thousands of dollars of premium plugins & services.</li>
			</ul>
			<a href="https://wordx.press/divi-support-maintenance/" target="_blank" class="button button-primary">Learn More</a>
			<p>Do you build Divi websites? If so, join our <a href="https://wordx.press/affiliate-area/" target="_blank">Affiliate Program</a> to get paid for ensuring your clients are taken care of after you’ve finished the design.</p>
		</div>
		<?php
	}

	public function register_dashboard() {
		register_setting( 'divinizer', 'divinizer', 'divinizer_dashboard_validate' );

		foreach ( $this->divinizer_sections as $id => $value ) {
			add_settings_section( $id, $value['title'], array( $this, 'divinizer_section_callback' ), 'divinizer' );
		}

		foreach ( $this->divinizer_fields as $id => $value ) {
			add_settings_field( $id, esc_html__( $value['title'], 'divinizer' ), array(
				$this,
				'divinizer_field_callback'
			), 'divinizer', $value['section'], $id );
		}
	}

	public function divinizer_dashboard_validate( $input ) {
		$output = [];

		foreach ( $input as $key => $value ) {
			$field_sanitize = de_field_sanitize( $key );

			switch ( $field_sanitize ) {
				case 'default':
					$output[ $key ] = strip_tags( stripslashes( $input[ $key ] ) );
					break;
				case 'full':
					$output[ $key ] = esc_url_raw( strip_tags( stripslashes( $input[ $key ] ) ) );
					break;
				default:
					$output[ $key ] = $input[ $key ];
					break;
			}
		}

		return $output;
	}

	public function divinizer_field_sanitize( $key ) {
		return $this->divinizer_fields[ $key ]['sanitize'];
	}

	// callback of add_settings_section()
	public function divinizer_section_callback( $args ) {
		return null;
	}

	// set the field's default value, used when no value is retrieved from DB
	public function divinizer_default_id( $id ) {
		return $this->divinizer_fields[ $id ]['default'];
	}

	// callback of add_settings_field(), outputs the fields
	public function divinizer_field_callback( $id ) {
		$option   = get_option( 'divinizer' );
		$id_field = isset( $option[ $id ] ) ? $option[ $id ] : $this->divinizer_default_id( $id );

		// output the field HTML according to de_field type
		switch ( $this->divinizer_fields[ $id ]['type'] ) {
			case 'select':
				echo '<select name="divinizer[' . $id . ']">';
				for ( $i = 0; $i < sizeof( $this->divinizer_fields[ $id ]['children'] ); $i ++ ) {
					echo "<option value='" . $i . "' " . selected( $id_field, $i, false ) . ">";
					esc_html_e( $this->divinizer_fields[ $id ]['children'][ $i ], 'divinizer' );
					echo "</option>";
				}
				echo '</select>';
				if ( isset( $this->divinizer_fields[ $id ]['description'] ) ) {
					echo '&nbsp;<p>' . $this->divinizer_fields[ $id ]['description'] . '</p>';
				}
				break;
			case 'checkbox':
				echo '<input type="checkbox" name="divinizer[' . $id . ']" value="1" ' . checked( 1, $id_field, false ) . '>';
				if ( isset( $this->divinizer_fields[ $id ]['description'] ) ) {
					echo '&nbsp;<p>' . $this->divinizer_fields[ $id ]['description'] . '</p>';
				}
				break;
		}
	}
}

new DIVInizerDashboard();
