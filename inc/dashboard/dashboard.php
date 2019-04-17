<?php 
/**
 * Expand Divi Dashboard
 * Setup dashboard sections and fields
 *
 * @package  ExpandDiviDashboard
 */

// exit when accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class ExpandDiviDashboard {
    private $expand_divi_sections;
    private $expand_divi_fields;

    function __construct() {
        // the sections array
        $this->expand_divi_sections = [
            'general' => [
                'title' => ''
            ]
        ];

        // the fields array
        $this->expand_divi_fields = [
            'enable_preloader' => [
                'title'    => 'Enable Pre-loader',
                'type'     => 'select',
                'section'  => 'general', 
                'default'  => 0,
                'children' => ['Disabled', 'Enabled']
            ], 
            'enable_fontawesome' => [
                'title'    => 'Enable Fontawesome',
                'type'     => 'select',
                'section'  => 'general', 
                'default'  => 0,
                'children' => ['Disabled', 'Enabled']
            ],           
            'enable_author_box' => [
                'title'    => 'Enable Author Box',
                'type'     => 'select',
                'section'  => 'general', 
                'default'  => 0,
                'children' => ['Disabled', 'Enabled']
            ],
            'enable_single_post_pagination' => [
                'title'    => 'Enable Single Post Pagination',
                'type'     => 'select',
                'section'  => 'general', 
                'default'  => 0,
                'children' => ['Disabled', 'Enabled']
            ],
            'enable_related_posts' => [
                'title'    => 'Enable Related Posts',
                'type'     => 'select',
                'section'  => 'general', 
                'default'  => 0,
                'children' => ['Disabled', 'Enabled']
            ],
            'enable_post_tags' => [
                'title'    => 'Enable Post Tags',
                'type'     => 'select',
                'section'  => 'general', 
                'default'  => 0,
                'children' => ['Disabled', 'Above Content', 'Below Content']
            ],
            'enable_lightbox_everywhere' => [
                'title'    => 'Enable Lightbox for posts and pages',
                'type'     => 'select',
                'section'  => 'general',
                'default'  => 0,
                'children' => ['Disabled', 'Enabled']
            ],
            'enable_archive_blog_styles' => [
                'title'    => 'Enable Archive Blog Styles',
                'type'     => 'select',
                'section'  => 'general', 
                'default'  => 0,
                'children' => ['Disabled', 'Grid']
            ],
            'remove_sidebar' => [
                'title'    => 'Remove Sidebar',
                'type'     => 'select',
                'section'  => 'general', 
                'default'  => 0,
                'children' => ['Disabled', 'Globally', 'Posts Only', 'Archive Pages Only']
            ]
        ];

		add_action( 'admin_menu', array( $this, 'add_expand_divi_menu' ) );
        add_action( 'admin_init', array( $this, 'register_dashboard' ) );
    }

    function add_expand_divi_menu() {
		add_submenu_page( 'tools.php', esc_html__( 'Expand Divi', 'expand-divi' ), esc_html__( 'Expand Divi', 'expand-divi' ), 'manage_options', 'expand-divi', array( $this, 'expand_divi_dashboard_output' ) );
	}
    
    function expand_divi_dashboard_output() {
        // check if the user is admin
        if ( ! current_user_can('manage_options') ) {
            wp_die( esc_html__( 'You do not have permission to access this page!', 'expand-divi' ) );
        } ?>

        <!-- dashboard interface -->
        <div id="expand_divi_wrap">
            <h1><?php esc_html_e( 'Expand Divi Options', 'expand-divi' ); ?></h1>
            <?php settings_errors(); ?>

            <form method="post" action="options.php" id="expand_divi_form">
                <div class="expand_divi_sections_wrap">
                <?php
                    settings_fields( 'expand_divi' );
                    do_settings_sections( 'expand-divi' );
                ?>
                </div>
                <?php submit_button(); ?>
                <div id="expand_divi_save"></div>

            </form>
        </div>
    <?php
    }

    function register_dashboard() {
        register_setting( 'expand_divi', 'expand_divi', 'expand_divi_dashboard_validate' );

        foreach ($this->expand_divi_sections as $id => $value) {
            add_settings_section( $id, $value['title'], array($this, 'expand_divi_section_callback'), 'expand-divi');
        }

        foreach ($this->expand_divi_fields as $id => $value) {
            add_settings_field( $id, esc_html__( $value['title'], 'expand-divi' ), array($this, 'expand_divi_field_callback'), 'expand-divi', $value['section'], $id );
        }
    }

    function expand_divi_dashboard_validate( $input ) {
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

    function expand_divi_field_sanitize( $key ) {
        return $this->expand_divi_fields[ $key ]['sanitize'];
    }

    // callback of add_settings_section()
    function expand_divi_section_callback( $args ) {
        return null;
    }

    // set the field's default value, used when no value is retrieved from DB
    function expand_divi_default_id( $id ) {
        return $this->expand_divi_fields[ $id ]['default'];
    }

    // callback of add_settings_field(), outputs the fields
    function expand_divi_field_callback( $id ) {
        $option = get_option( 'expand_divi' );
        $id_field = isset( $option[ $id ] ) ? $option[ $id ] : $this->expand_divi_default_id( $id );
        
        // output the field HTML according to de_field type
        switch ( $this->expand_divi_fields[ $id ]['type'] ) {
            case 'select':
                echo '<select name="expand_divi[' . $id . ']">';
                for ( $i = 0; $i < sizeof( $this->expand_divi_fields[ $id ]['children'] ); $i++ ) {
                    echo "<option value='" . $i ."' " . selected( $id_field, $i, false ) . ">";
                    esc_html_e( $this->expand_divi_fields[ $id ]['children'][ $i ], 'expand-divi' );
                    echo "</option>";
                }
                echo '</select>';
            break;
        }
    }
}

new ExpandDiviDashboard();