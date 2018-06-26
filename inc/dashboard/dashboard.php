<?php 
/**
 * DIVInize Dashboard
 * Setup dashboard sections and fields
 *
 * @package  DIVInizeDashboard
 */

// exit when accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class DIVInizeDashboard {
    private $divinize_sections;
    private $divinize_fields;

    function __construct() {
        // the sections array
        $this->divinize_sections = [
            'general' => [
                'title' => ''
            ]
        ];

        // the fields array
        $this->divinize_fields = [
            'enable_preloader' => [
                'title'    => 'Pre-loader',
                'type'     => 'select',
                'section'  => 'general', 
                'default'  => 0,
                'children' => ['Disabled', 'Enabled']
            ], 
            'enable_fontawesome' => [
                'title'    => 'Fontawesome',
                'type'     => 'select',
                'section'  => 'general', 
                'default'  => 0,
                'children' => ['Disabled', 'Enabled']
            ],           
            'enable_author_box' => [
                'title'    => 'Author Box',
                'type'     => 'select',
                'section'  => 'general', 
                'default'  => 0,
                'children' => ['Disabled', 'Enabled']
            ],
            'enable_single_post_pagination' => [
                'title'    => 'Single Post Pagination',
                'type'     => 'select',
                'section'  => 'general', 
                'default'  => 0,
                'children' => ['Disabled', 'Enabled']
            ],
            'enable_related_posts' => [
                'title'    => 'Related Posts',
                'type'     => 'select',
                'section'  => 'general', 
                'default'  => 0,
                'children' => ['Disabled', 'Enabled']
            ],
            'enable_post_tags' => [
                'title'    => 'Post Tags',
                'type'     => 'select',
                'section'  => 'general', 
                'default'  => 0,
                'children' => ['Disabled', 'Above Content', 'Below Content']
            ],
            'enable_archive_blog_styles' => [
                'title'    => 'Archive Blog Styles',
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

        add_action( 'admin_menu', array( $this, 'add_divinize_menu' ) );
        add_action( 'admin_init', array( $this, 'register_dashboard' ) );
    }

    function add_divinize_menu() {
        add_submenu_page( 'tools.php', esc_html__( 'DIVInize', 'divinize' ), esc_html__( 'DIVInize', 'divinize' ), 'manage_options', 'divinize', =erray( $this, 'divinize_dashboard_output' ) );
    }
    
    function divinize_dashboard_output() {
        // check if the user is admin
        if ( ! current_user_can('manage_options') ) {
            wp_die( esc_html__( 'You do not have permission to access this page!', 'divinize' ) );
        } ?>

        <!-- dashboard interface -->
        <div id="divinize_wrap">
            <h1><?php esc_html_e( 'DIVInize Options', 'divinize' ); ?></h1>
            <?php settings_errors(); ?>

            <form method="post" action="options.php" id="divinize_form">
                <div class="divinize_sections_wrap">
                <?php
                    settings_fields( 'divinize' );
                    do_settings_sections( 'divinize' );
                ?>
                </div>
                <?php submit_button(); ?>
                <div id="divinize_save"></div>

            </form>
        </div>
    <?php
    }

    function register_dashboard() {
        register_setting( 'divinize', 'divinize', 'divinize_dashboard_validate' );

        foreach ($this->divinize_sections as $id => $value) {
            add_settings_section( $id, $value['title'], array($this, 'divinize_section_callback'), 'divinize');
        }

        foreach ($this->divinize_fields as $id => $value) {
            add_settings_field( $id, esc_html__( $value['title'], 'divinize' ), array($this, 'divinize_field_callback'), 'divinize', $value['section'], $id );
        }
    }

    function divinize_dashboard_validate( $input ) {
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

    function divinize_field_sanitize( $key ) {
        return $this->divinize_fields[ $key ]['sanitize'];
    }

    // callback of add_settings_section()
    function divinize_section_callback( $args ) {
        return null;
    }

    // set the field's default value, used when no value is retrieved from DB
    function divinize_default_id( $id ) {
        return $this->divinize_fields[ $id ]['default'];
    }

    // callback of add_settings_field(), outputs the fields
    function divinize_field_callback( $id ) {
        $option = get_option( 'divinize' );
        $id_field = isset( $option[ $id ] ) ? $option[ $id ] : $this->divinize_default_id( $id );
        
        // output the field HTML according to de_field type
        switch ( $this->divinize_fields[ $id ]['type'] ) {
            case 'select':
                echo '<select name="divinize[' . $id . ']">';
                for ( $i = 0; $i < sizeof( $this->divinize_fields[ $id ]['children'] ); $i++ ) {
                    echo "<option value='" . $i ."' " . selected( $id_field, $i, false ) . ">";
                    esc_html_e( $this->divinize_fields[ $id ]['children'][ $i ], 'divinize' );
                    echo "</option>";
                }
                echo '</select>';
            break;
        }
    }
}

new DIVInizeDashboard();