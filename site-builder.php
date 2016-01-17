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
        'thumb' => '',
        'tpl' => '',
        'js' => '',
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






global $wp_sb_fields ;
if ( ! $wp_sb_fields ) {
    $wp_sb_fields =  array();
}




class WP_Site_Builder {

    public $blocks = array();

    function __construct() {
        add_action( 'init', array( $this, 'init' ) );
    }

    public function init(){
        if ( isset( $_GET['site_builder'] ) && $_GET['site_builder'] == 1 ) {
            add_action( 'template_include', array( $this, 'load_site_builder' ) );

            remove_all_actions('wp_head');
            remove_all_actions('wp_footer');

            // Load files
            $this->setup_fields();
            do_action( 'wp_sb_after_setup_fields' );


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


            global $wp_sb_fields;
            if ( is_array( $wp_sb_fields ) ) {
                foreach( $wp_sb_fields as $k => $f ){
                    if ( $f['js'] ){
                        // echo $f['js'];
                        wp_enqueue_script( 'site-builder-field-'.$k, $f['js'] , array( 'jquery' ) );
                    }
                }
            }


            wp_enqueue_script( 'site-builder-menu', WP_SITE_BUILDER_URL.'block-menu/block-menu.js', array( 'jquery' ) );
            wp_enqueue_script( 'site-builder', WP_SITE_BUILDER_URL.'assets/builder/js/builder.js', array( 'jquery' ) );
            wp_enqueue_script( 'site-builder-live-view', WP_SITE_BUILDER_URL.'assets/builder/js/live-view.js', array( 'jquery' ) );

            add_action( 'wp_footer', array( $this ,'load_panel' ) );
            add_action( 'wp_footer', array( $this ,'load_fields' ) );

            include WP_SITE_BUILDER_PATH.'config.php';

        }

    }

    function setup_fields() {

        global $wp_sb_fields;

        if ( ! function_exists( 'list_file' )  ) {
            require_once ABSPATH.'/wp-admin/includes/file.php';
        }

        $files =  list_files( WP_SITE_BUILDER_PATH.'fields', 1 );

        if ( $files ) {
            foreach( $files as $file ) {
                if ( is_file( $file ) ) {

                    $name = basename( $file );
                    if ( strtolower( substr( $name, -4 ) ) == '.php' ) {
                        $name =  str_replace( '.php', '', strtolower( $name ) );
                        $wp_sb_fields[ $name ]  = array(
                            'tpl' => $file,
                            'js' => is_file( WP_SITE_BUILDER_URL.'fields/'.$name.'.js' ) ? WP_SITE_BUILDER_URL.'fields/'.$name.'.js' : false
                        );
                    }

                } else {
                    $name = basename( $file );
                    $wp_sb_fields[ $name ]  = array(
                        'tpl' => $file."{$name}.php",
                        'js' => is_file( $file."{$name}.js" ) ? WP_SITE_BUILDER_URL."fields/{$name}/{$name}.js"  : false
                    );
                }

            }
        }

    }



    function load_fields(){
        global $wp_sb_fields;
        if ( is_array( $wp_sb_fields ) ) {
            foreach( $wp_sb_fields as $k => $f ){
                if ( $f['js'] ){
                    wp_enqueue_script( 'site-builder-field-'.$k, $f['js']  );
                }
                if (  $f['tpl'] ){
                    // echo $f['tpl']; die();
                    include_once $f['tpl'];
                }
            }
        }



    }




    function  load_site_builder( $file ){
        return dirname( __FILE__ ).'/template.php';
    }

    /**
     * Get url of any dir
     *
     * @param string $file full path of current file in that dir
     * @return string
     */
    function get_url( $file = '' ){
        if ( 'WIN' === strtoupper( substr( PHP_OS, 0, 3 ) ) ) {
            // Windows
            $content_dir = str_replace( '/', DIRECTORY_SEPARATOR, WP_CONTENT_DIR );
            $content_url = str_replace( $content_dir, WP_CONTENT_URL, trailingslashit( dirname( $file  ) ) );
            $url = str_replace( DIRECTORY_SEPARATOR, '/', $content_url );
        } else {
            $url = str_replace(
                array( WP_CONTENT_DIR, WP_PLUGIN_DIR ),
                array( WP_CONTENT_URL, WP_PLUGIN_URL ),
                trailingslashit( dirname( $file  ) )
            );
        }
        return set_url_scheme( $url );
    }


    function load_panel(){
        include WP_SITE_BUILDER_PATH.'panel/panel.php';
        include WP_SITE_BUILDER_PATH.'block-menu/block-menu.php';
    }

    static function get_block_tpl( $file ){

    }
}

new WP_Site_Builder();
