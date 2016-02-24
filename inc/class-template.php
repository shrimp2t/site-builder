<?php

class WP_SB_Template {
    protected $css;
    protected $js;
    protected $data;
    protected $html;

    function __construct( $template_id = false ){
        global $WP_SB_Template;
        $WP_SB_Template =  $this;
        $this->get_data();
        $this->render();
    }

    function get_data(){
        $this->data = get_option( 'site_builder' );
    }

    function print_css(){
        global $wp_sb_tpl_css;
        if ( ! empty( $wp_sb_tpl_css ) ) {
            echo '<style type="text/css" class="wp-sb-tpl-css">'."\n".join( "\t\n", $wp_sb_tpl_css )."\n".'</style>'."\n";
        }
    }

    function print_js(){
        global $wp_sb_tpl_js;
        if ( ! empty( $wp_sb_tpl_js ) ) {
            echo '<script type="text/javascript" class="wp-sb-tpl-js">'."\n".join( "\t\n", $wp_sb_tpl_js )."\n".'</script>'."\n";
        }
    }

    function print_template(){
        echo $this->html;
    }

    function add_css( $selector, $css ){
        if ( ! isset( $GLOBALS['wp_sb_tpl_css'] ) || ! is_array ( $GLOBALS['wp_sb_tpl_css'] ) ) {
            $GLOBALS['wp_sb_tpl_css'] = array();
        }
        $GLOBALS['wp_sb_tpl_css'][]= $selector.'{ '.$css.' }';
    }

    function add_js( $code ){
        if ( ! isset( $GLOBALS['wp_sb_tpl_js'] ) || ! is_array ( $GLOBALS['wp_sb_tpl_js'] ) ) {
            $GLOBALS['wp_sb_tpl_js'] = array();
        }
        $GLOBALS['wp_sb_tpl_js'][]= $code;
    }

    function render(){
        ob_start();
        $old_content =  ob_get_clean();
        ob_start();

        global $wp_sb_elements;

        if ( is_array( $this->data ) && ! empty( $this->data ) ) {
            foreach ( $this->data as $block ) {
                if ( isset( $block['tag'] ) ) {
                    if ( isset ( $wp_sb_elements[ $block['tag'] ] ) ) {
                        if ( file_exists( $wp_sb_elements[ $block['tag'] ]['tpl'] ) ) {

                            $GLOBALS['current_section']  =  $wp_sb_elements[ $block['tag'] ];
                            $GLOBALS['section_values']   =  $block['fields'];
                            $GLOBALS['section_settings'] =  $block['settings'];

                            wp_sb_setup_section_data( array(
                                    'fields' => $wp_sb_elements[ $block['tag'] ]['fields'],
                                    'settings' => $wp_sb_elements[ $block['tag'] ]['settings'] )
                            );

                            include $wp_sb_elements[ $block['tag'] ]['tpl'];
                        }
                    }
                }
            }
        }

        $this->html = ob_get_clean();
        if ( $old_content ) {
            echo $old_content;
        }
    }


    static function load_builder_elements(){
        global  $wp_sb_elements;
        if ( is_array( $wp_sb_elements ) ) {
            foreach( $wp_sb_elements as $id => $item ){
                $GLOBALS['current_section']  =  $item;
                $GLOBALS['section_values']   =  array();
                $GLOBALS['section_settings'] =  array();
                wp_sb_setup_section_data( array(
                        'fields'   => $item['fields'],
                        'settings' => $item['settings'] )
                );
                ?>
                <script id="<?php echo esc_attr( 'wp_sb_tpl_block_'.$id ); ?>" type="text/html">
                    <?php
                    if ( file_exists( $item['tpl'] ) ) {
                        include $item['tpl'];
                    }
                    ?>
                </script>
                <?php
            }
        }
    }


}


$GLOBALS['WP_SB_Template'] = false;

function wp_sb_setup_template( $template_id = false ) {
    global $WP_SB_Template;

    if ( ! $WP_SB_Template instanceof WP_SB_Template ) {
        $WP_SB_Template = new WP_SB_Template( $template_id );
    }

    return $WP_SB_Template;
}

function wp_sb_template( $template_id = false ){
    global $WP_SB_Template;
    if ( ! $WP_SB_Template instanceof WP_SB_Template ) {
        $WP_SB_Template = new WP_SB_Template( $template_id );
    }
    return $WP_SB_Template;
}