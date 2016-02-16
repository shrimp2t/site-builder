<?php
global $section_values, $current_section, $section_settings;

?>
<div class="section"<?php wp_sb_editing_section( ); ?>>
    <div class="container">
        <h1<?php wp_sb_editing_field( 'title' ); ?>><?php echo esc_html( wp_sb_get_field_value( 'title' ) ); ?></h1>
        <p<?php wp_sb_editing_field( 'tagline' ); ?>><?php echo esc_html( wp_sb_get_field_value( 'tagline' )); ?></p>
        <div<?php wp_sb_editing_field( 'contents' ); ?>>
            <?php

            $contents = wp_sb_get_field_value( 'contents' );

            $backup_values =  $section_values;
            $backup_section =  $current_section;
            $backup_settings =  $section_settings;

            // var_dump( $current_section );

            global $wp_sb_elements;
           // var_dump( $contents );
            foreach ( $contents as $_block ) {

                if ( ! isset ( $_block['tag'] ) ) {
                    continue;
                }

                $GLOBALS['current_section']  =  $wp_sb_elements[ $_block['tag'] ];
                $GLOBALS['section_values']   =  $_block['fields'];
                $GLOBALS['section_settings'] =  $_block['settings'];

                if ( isset ( $wp_sb_elements[ $_block['tag'] ] ) ) {
                    wp_sb_setup_section_data( array(
                        'fields' => $wp_sb_elements[ $_block['tag'] ]['fields'],
                        'settings' => $wp_sb_elements[ $_block['tag'] ]['settings']
                    ) );
                    include $wp_sb_elements[ $_block['tag'] ]['tpl'];
                }

            }

            $current_section  =  $backup_section;
            $section_values  =  $backup_values;
            $section_settings =  $backup_settings;


            ?>
        </div>
    </div>
</div>
