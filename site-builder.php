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

global $wp_sb_sections, $wp_sb_fields, $wp_sb_elements;
if ( ! $wp_sb_fields ) {
    $wp_sb_fields =  array();
}


class WP_Site_Builder {

    public $blocks = array();

    function __construct() {
        add_action( 'init', array( $this, 'init' ) );
        add_action( 'wp_ajax_wp_save_site_builder', array( $this, 'save' ) );
    }

    /**
     * Save builder data
     */
    function save(){
        $data =  $_POST['builder_content'];
        $data = stripslashes_deep( $data );
        update_option( 'site_builder', json_decode( $data, true ) );
        die( 'site_builder_saved' );
    }

    function init_setup(){
        // Load files
        $this->setup_fields();
        do_action( 'wp_sb_after_setup_fields' );

        /**
         *  Load elements function file
         */
        global $wp_sb_elements;
        foreach ( $wp_sb_elements as $e ){
            if ( isset ( $e['function'] ) && is_file( $e['function'] ) ) {
                include_once $e['function'];
            }
        }
    }

    /**
     * Setup builder
     */
    public function init(){

        include WP_SITE_BUILDER_PATH.'inc/functions.php';
        include WP_SITE_BUILDER_PATH.'config.php';

        include WP_SITE_BUILDER_PATH.'inc/func-template.php';
        include WP_SITE_BUILDER_PATH.'inc/class-template.php';

        if ( isset( $_GET['site_viewer'] ) && $_GET['site_viewer'] == 1 ) {
            add_action( 'template_include', array( $this, 'load_view_template' ) );

            $this->init_setup();
            add_action( 'wp', array( $this, 'load_view_scripts' ) );

            // Load template
            $template_id = false;
            $tpl = wp_sb_setup_template( $template_id );

            add_action( 'wp_head', array( $tpl, 'print_css' ) );
            add_action( 'wp_footer', array( $tpl, 'print_js' ), 15 );
        }

        if ( isset( $_GET['site_builder'] ) && $_GET['site_builder'] == 1 ) {
            add_action( 'template_include', array( $this, 'load_edit_template' ) );
            define( 'WP_SB_EDITING', 1 );

            remove_all_actions('wp_head');
            remove_all_actions('wp_footer');

            $this->init_setup();

            add_action( 'wp_head', 'wp_print_scripts' );
            add_action( 'wp_head', 'wp_print_styles' );
            add_action( 'wp_footer', 'wp_print_styles', 80 );
            add_action( 'wp_footer', 'wp_print_scripts', 80 );

            add_filter('show_admin_bar', '__return_false');

            add_action( 'wp', array( $this, 'load_edit_scripts' ) );

            add_action( 'wp_footer', array( $this ,'load_panel' ) );
            add_action( 'wp_footer', array( $this ,'load_fields' ) );
            /**
             * Load elements template
             */
            add_action( 'wp_footer', array( 'WP_SB_Template' ,'load_builder_elements' ) );

            // Load template
            $template_id = false;
            $tpl = wp_sb_setup_template( $template_id );

            add_action( 'wp_head', array( $tpl, 'print_css' ) );
            add_action( 'wp_footer', array( $tpl, 'print_js' ), 15 );


        }

    }

    function load_view_scripts(){
        wp_enqueue_style( 'bootstrap', WP_SITE_BUILDER_URL.'assets/bootstrap/scss/bootstrap.css' );
        wp_enqueue_style( 'builder-frontend', WP_SITE_BUILDER_URL.'assets/frontend/css/frontend.css' );
        wp_enqueue_script('jquery');
        wp_enqueue_script( 'parallax', WP_SITE_BUILDER_URL.'assets/frontend/js/parallax.js', array( 'jquery' ), false, true );
        wp_enqueue_script( 'builder-frontend', WP_SITE_BUILDER_URL.'assets/frontend/js/frontend.js', array( 'jquery' ), true, true );

    }

    function load_edit_scripts(){

        wp_enqueue_style( 'bootstrap', WP_SITE_BUILDER_URL.'assets/bootstrap/scss/bootstrap.css' );
        wp_enqueue_style( 'dashicons' );
        wp_enqueue_style( 'jquery-ui',  WP_SITE_BUILDER_URL.'assets/builder/css/jquery-ui.css' );
        wp_enqueue_style( 'site-builder', WP_SITE_BUILDER_URL.'assets/builder/css/builder.css' );
        //wp_enqueue_style( 'bootstrap', WP_SITE_BUILDER_URL.'assets/bootstrap/css/bootstrap.min.css' );
        wp_enqueue_style( 'bootstrap-colorpicker', WP_SITE_BUILDER_URL.'assets/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css' );
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

        /// tinyMCE editor
        /*
        wp_enqueue_script( 'media-upload' );
        wp_enqueue_script( 'wplink' );
        wp_enqueue_script( 'wpdialogs-popup' );

        // http://wordpress.stackexchange.com/questions/70548/load-tinymce-wp-editor-via-ajax
        wp_editor( '', 'custom_editor_id' );


        $container_selectors = apply_filters( 'black_studio_tinymce_container_selectors', array(  'div.widget', 'div.widget-inside' ) );
        $data = array(
            'container_selectors' => implode( ', ', $container_selectors ),
            'activate_events' => array(),
            'deactivate_events' => array(),
            // translators: error message shown when a duplicated widget ID is detected
            'error_duplicate_id' => __( 'ERROR: Duplicate widget ID detected. To avoid content loss, please create a new widget with the same content and then delete this one.', 'black-studio-tinymce-widget' )
        );

        do_action( 'wp_enqueue_editor', array( 'tinymce' => true ) );
        wp_enqueue_script( 'site-builder-tinymce', WP_SITE_BUILDER_URL.'assets/builder/js/tinymce.js', array( 'jquery', 'editor', 'quicktags' ), false, true );
        wp_localize_script( 'jquery', 'bstw_data', $data );
        */
        /// END tinyMCE editor


        wp_enqueue_script( 'bootstrap-colorpicker', WP_SITE_BUILDER_URL.'assets/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js' );
        wp_enqueue_script( 'site-builder-fields', WP_SITE_BUILDER_URL.'assets/builder/js/fields.js', array( 'jquery' ) );

        global $wp_sb_sections;
        wp_localize_script( 'jquery', 'wpSiteBuilder', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'sections' => $wp_sb_sections,
        ) );


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

    }

    /**
     * Load Fields Setup
     */
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

                } else { // folder field
                    $name = basename( $file );
                    $wp_sb_fields[ $name ]  = array(
                        'tpl' =>  is_file( $file."settings.php" ) ?  $file."settings.php" : false,
                        'js' => is_file( $file."admin.js" ) ? WP_SITE_BUILDER_URL."fields/{$name}/admin.js"  : false
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
                if ( file_exists( $f['tpl'] ) ){
                    // echo $f['tpl']; die();
                    include_once $f['tpl'];
                }
            }
        }
    }

    function load_edit_template( $file ){
        return WP_SITE_BUILDER_PATH.'template.php';
    }

    function load_view_template( $file ){
        return WP_SITE_BUILDER_PATH.'view.php';
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

}

new WP_Site_Builder();
