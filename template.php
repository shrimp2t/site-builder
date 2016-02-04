<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width">
    <title><?php _e(  'Template Builder', 'site-builder' ); ?></title>
    <?php
   // wp_print_scripts();
   // wp_print_styles();
    wp_head();
    ?>
</head>
<body>

<div class="wp-sb-builder-content-wrap">
    <div class="wp-sb-builder-area">
        <?php

        $data_blocks = get_option( 'site_builder' );
        global $wp_sb_elements;

        if ( is_array( $data_blocks ) && ! empty( $data_blocks ) ) {
            foreach ( $data_blocks as $block ) {
                if ( isset( $block['tag'] ) ) {
                    if ( isset ( $wp_sb_elements[ $block['tag'] ] ) ) {
                        if ( file_exists( $wp_sb_elements[ $block['tag'] ]['tpl'] ) ) {
                            //var_dump( $block );
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

       ?>
    </div>
</div>

<?php wp_footer(); ?>
</body>
</html>