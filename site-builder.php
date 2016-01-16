<?php
/*
Plugin Name: WP Site Builder
Plugin URI: http://shrimp2t.com/product-layouts
Description: A Mega menu builder for Visual Composer
Version: 1.0.0
Author: Shrimp2t
Author URI: http://shrimp2t.com
*/

define( 'WP_SITE_BUILDER_URL', trailingslashit( plugins_url('', __FILE__) ) );
define( 'WP_SITE_BUILDER_PATH', trailingslashit( plugin_dir_path( __FILE__) ) );

/*
if ( ! current_user_can( 'customize' ) ) {

    //wp_die(
     //   '<h1>' . __( 'Cheatin&#8217; uh?' ) . '</h1>' .
     //   '<p>' . __( 'You are not allowed to customize the appearance of this site.' ) . '</p>',
     //   403
    //);
    //
}
*/

global $wp_sb_sections;

/**
 *
 * priority
 * @param $section_id
 * @param $element_id
 * @param $settings
 */
function wp_sb_register_element( $section_id, $element_id, $settings ){
    if ( ! is_array( $settings ) ) {
        $settings = array();
    }
    $settings = wp_parse_args( $settings, array(
        'title' => $element_id,
        'priority' => '',
    ) );
    global $wp_sb_sections;
    if ( ! isset( $wp_sb_sections[ $section_id ] ) ) {
        wp_sb_register_section( $section_id, array() );
    }

    $wp_sb_sections[ $section_id ][ 'elements' ][ $element_id ] =  $settings;

}

/**
 *
 * priority
 * @param $section_id
 * @param $settings
 */
function wp_sb_register_section( $section_id, $settings ){
    global $wp_sb_sections;
    if ( ! is_array( $settings ) ) {
        $settings = array();
    }
    $settings = wp_parse_args( $settings, array(
        'title' => $section_id,
        'priority' => '',
        'elements' => array(),
    ) );
    $wp_sb_sections[ $section_id ] = $settings;

}









class WP_Site_Builder {
    function __construct() {
        add_action( 'init', array( $this, 'init' ) );
    }

    public function init(){
        if ( isset( $_GET['site_builder'] ) && $_GET['site_builder'] == 1 ) {
            add_action( 'template_include', array( $this, 'load_site_builder' ) );

            remove_all_actions('wp_head');
            remove_all_actions('wp_footer');

            add_action( 'wp_head', 'wp_print_scripts' );
            add_action( 'wp_head', 'wp_print_styles' );
            add_action( 'wp_footer', 'wp_print_styles' );

            add_filter('show_admin_bar', '__return_false');

            wp_enqueue_style( 'dashicons' );
            wp_enqueue_style( 'jquery-ui',  WP_SITE_BUILDER_URL.'assets/builder/css/jquery-ui.css' );
            wp_enqueue_style( 'site-builder', WP_SITE_BUILDER_URL.'assets/builder/css/builder.css' );
            //wp_enqueue_style( 'bootstrap', WP_SITE_BUILDER_URL.'assets/bootstrap/css/bootstrap.min.css' );
            wp_enqueue_style( 'bootstrap', WP_SITE_BUILDER_URL.'assets/bootstrap/scss/bootstrap.css' );

            wp_enqueue_style( 'wp-color-picker' );

            wp_enqueue_media();


            wp_enqueue_script( 'jquery' );
            wp_enqueue_script( 'query-ui-core' );
            wp_enqueue_script( 'jquery-ui-widget' );
            wp_enqueue_script( 'jquery-ui-draggable' );
            wp_enqueue_script( 'jquery-ui-sortable' );
            wp_enqueue_script( 'jquery-ui-droppable' );
            wp_enqueue_script( 'jquery-ui-resizable' );
            wp_enqueue_script( 'json2' );
            wp_enqueue_script( 'underscore' );

            wp_enqueue_script(
                'iris',
                admin_url( 'js/iris.min.js' ),
                array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ),
                false,
                1
            );
            wp_enqueue_script(
                'wp-color-picker',
                admin_url( 'js/color-picker.min.js' ),
                array( 'iris' ),
                false,
                1
            );

            $colorpicker_l10n = array(
                'clear' => __( 'Clear' ),
                'defaultString' => __( 'Default' ),
                'pick' => __( 'Select Color' )
            );
            wp_localize_script( 'wp-color-picker', 'wpColorPickerL10n', $colorpicker_l10n );


            wp_enqueue_script( 'site-builder-fields', WP_SITE_BUILDER_URL.'assets/builder/js/fields.js', array( 'jquery' ) );
            wp_enqueue_script( 'site-builder', WP_SITE_BUILDER_URL.'assets/builder/js/builder.js', array( 'jquery' ) );
            wp_enqueue_script( 'site-builder-live-view', WP_SITE_BUILDER_URL.'assets/builder/js/live-view.js', array( 'jquery' ) );

            add_action( 'wp_footer', array( $this ,'load_panel' ) );


            include WP_SITE_BUILDER_PATH.'config.php';

        }

    }

    function  load_site_builder( $file ){
        return dirname( __FILE__ ).'/template.php';
    }

    function load_panel(){
        include WP_SITE_BUILDER_PATH.'panel/panel.php';
        include WP_SITE_BUILDER_PATH.'fields.php';
    }
}

new WP_Site_Builder();
