<script id="wp-sb-section-edit-menu" type="text/html">
    <div class="wp-sb-section-edit">
        <ul>
            <li class="remove-section">
                <span class="dashicons dashicons-trash"></span>
            </li>
            <li class="bg-image">
                <span class="dashicons dashicons-format-image"></span>
            </li>
            <li class="bg-color">
                <span class="dashicons dashicons-admin-appearance"></span>
            </li>
            <li class="typography">
                <span class="dashicons dashicons-editor-textcolor"></span>
            </li>
            <li class="text-align">
                <span class="dashicons dashicons-editor-alignleft"></span>
                <ul>
                    <li><span class="dashicons dashicons-editor-alignleft"></span></li>
                    <li><span class="dashicons dashicons-editor-aligncenter"></span></li>
                    <li><span class="dashicons dashicons-editor-alignright"></span></li>
                </ul>
            </li>
            <li class="section-move"><span class="wp-section-order dashicons dashicons-editor-code"></span></li>
        </ul>

    </div>
</script>


<script id="wp-sb-section-bg" type="text/html">
    <div class="wp-sb-modal modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><?php _e( "Settings", 'site-builder' );  ?></h4>
            </div>

            <div class="modal-body-wrapper">
                <div class="modal-body">

                    <input type="text" class="input_color">

                    <div class="item-media"><a href="#" class="upload-button">upload-button</a> </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php _e( 'Close', 'site-builder' ); ?></button>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</script>