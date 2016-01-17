<?php

$categories = array(
    'header'  =>__( 'Header', 'site-builder' ),
    'content' =>__( 'Content', 'site-builder' ),
    'videos'  =>__( 'Video', 'site-builder' ),
    'team'    =>__( 'Team', 'site-builder' ),
);
global $wp_sb_sections;

?>
<input  type="hidden" id="wb-sb-template-content">
<div class="wp-sb-panel">
    <div class="wp-sb-actions">
        <a class="wp-sb-close"  href="#"></a>
        <a class="wp-sb-save" href="#"><?php _e( 'Save', 'site-builder' ); ?></a>
    </div>

    <div class="wp-sb-panel-content">
        <div class="wp-sb-sections">
            <?php foreach( $wp_sb_sections as $k => $section ){ ?>
                <div class="wp-sb-section">
                    <h3 class="wp-sb-section-title"><?php echo esc_html( $section['title'] ); ?></h3>
                    <div class="wp-sb-elements">

                        <div class="wp-sb-e-section-title">
                            <button class="wp-sb-e-section-back"></button>
                            <h3>
							    <span class="customize-action"><?php _e( 'Section', 'site-builder' ); ?></span><?php  echo esc_html( $section['title'] ); ?>
                            </h3>
                        </div>

                        <div class="wp-sb-elements-wrap">
                            <?php foreach( $section['elements'] as $el_id => $el ) { ?>
                                <div class="wp-sb-element" data-el-id="<?php echo esc_attr( $el_id ); ?>">
                                    <?php if ( $el['thumb'] ) { ?>
                                    <img src="<?php echo esc_url( $el['thumb'] ); ?>" alt="">
                                    <?php } ?>

                                    <?php echo esc_html( $el['title'] ); ?>
                                    <script id="<?php echo esc_attr( 'wp_sb_tpl_block_'.$el_id ); ?>" type="text/html">
                                        <?php
                                            if ( file_exists( $el['tpl'] ) ) {
                                                include $el['tpl'];
                                            }
                                        ?>
                                    </script>
                                </div>
                            <?php } ?>
                            <div class="fix-height"></div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>



</div>

<a href="#" class="wp-sb-collapse-sidebar" aria-label="Expand Sidebar">
    <span class="wp-sb-sidebar-arrow"></span>
    <span class="wp-sb-sidebar-label">Collapse</span>
</a>

