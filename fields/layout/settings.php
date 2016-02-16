<?php
global $wp_sb_sections;


?><script type="text/html" id="wp-sb-field-layout-tpl">
    <div class="wp-sb-modal modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><?php _e( "Layout", 'site-builder' );  ?></h4>
            </div>
            <div class="modal-body-wrapper">
                <div class="modal-body">
                    <form class="fake-form">
                        <?php foreach( $wp_sb_sections as $k => $section ){ ?>
                            <div class="wp-sb-section">
                                <h3 class="wp-sb-section-title"><?php echo esc_html( $section['title'] ); ?></h3>
                                <div class="wp-sb-elements">
                                    <div class="wp-sb-e-section-title">
                                        <span class="wp-sb-e-section-title"><?php _e( 'Section', 'site-builder' ); ?></span><?php  echo esc_html( $section['title'] ); ?>
                                    </div>

                                    <div class="wp-sb-elements-wrap">
                                        <?php foreach( $section['elements'] as $el_id => $el ) {

                                            if ( $el['type'] != 'content' && $el['type'] != 'sidebar' ) {
                                                continue;
                                            }

                                            ?>
                                            <div class="wp-sb-element" data-el-id="<?php echo esc_attr( $el_id ); ?>">
                                                <?php if ( $el['thumb'] ) { ?>
                                                    <img src="<?php echo esc_url( $el['thumb'] ); ?>" alt="">
                                                <?php } ?>
                                                <?php
                                                echo esc_html( $el['title'] );
                                                ?>
                                            </div>
                                        <?php } ?>
                                        <div class="fix-height"></div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php _e( 'Close', 'site-builder' ); ?></button>
                <button type="button" class="btn btn-primary wp-sb-modal-save"><?php _e( 'Save', 'site-builder' ); ?></button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->

</script>


<script type="text/html" id="wp-sb-field-layout-toolbar-tpl">
    <div class="layout-tool-bar">
        <ul class="">
            <li class="add-item"><span class="dashicons dashicons-plus"></span></li>
        </ul>
    </div>
</script>