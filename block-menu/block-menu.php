<script id="wp-sb-section-edit-menu" type="text/html">
    <div class="wp-sb-section-edit">
        <ul>
            <li class="remove-section">
                <span class="dashicons dashicons-trash"></span>
            </li>
            <?php /*
            <# if ( typeof data.bg !== "undefined"  ){ #>
            <li class="block-settings" data-block-cb="bg" data-block-type="modal">
                <span class="dashicons dashicons-format-image"></span>
            </li>
            <# } #>

            <# if ( typeof data.bg !== "box"  ){ #>
            <li  class="block-settings" data-block-cb="box" data-block-type="modal">
                <span class="dashicons dashicons-admin-appearance"></span>
            </li>
            <# } #>

            <# if ( typeof data.bg !== "typography"  ){ #>
            <li  class="block-settings" data-block-cb="typography" data-block-type="modal" class="typography">
                <span class="dashicons dashicons-editor-textcolor"></span>
            </li>
            <# } #>

            <# if ( typeof data.align !== "undefined"  ){ #>
            <li class="text-align">
                <span class="dashicons dashicons-editor-alignleft"></span>
                <ul>
                    <li class="block-settings" data-block-cb="align" data-block-type="inline" data-value="left"><span class="dashicons dashicons-editor-alignleft"></span></li>
                    <li class="block-settings" data-block-cb="align" data-block-type="inline" data-value="center"><span class="dashicons dashicons-editor-aligncenter"></span></li>
                    <li class="block-settings" data-block-cb="align" data-block-type="inline" data-value="right"><span class="dashicons dashicons-editor-alignright"></span></li>
                </ul>
            </li>
            <# } #>
            */ ?>

            <li class="block-settings block-design">
                <span class="dashicons dashicons-edit"></span>
            </li>

            <?php do_action( 'wp_sb_more_block_settings' ); ?>
            <li class="section-move"><span class="wp-section-order dashicons dashicons-editor-code"></span></li>
        </ul>

    </div>
</script>




<script id="wp-sb-block-menu-design" type="text/html">
    <div class="wp-sb-modal modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><?php _e( "Design", 'site-builder' );  ?></h4>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-tab-id="bg" href="#">Background</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-tab-id="content" href="#">Content</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-tab-id="typography" href="#">Typography</a>
                    </li>
                </ul>
            </div>

            <div class="modal-body-wrapper">
                <div class="modal-body">

                    <form>
                        <div class="tab-content" data-tab-id="bg">

                            <label><?php _e( 'Background color', 'site-builder' );  ?></label>
                            <div class="input-group input-color">
                                <input type="text" name="bg_color" value="{{ data.bg_color }}" class="form-control">
                                <span class="input-group-addon"><i></i></span>
                            </div>

                            <fieldset class="form-group">
                                <label><?php _e( 'Background image', 'site-builder' );  ?></label>
                                <div class="item-media" style="background-image: url('{{ data.img_url }}');">
                                    <input type="hidden" class="image_url" value="{{ data.img_url }}" name="img_url">
                                    <input type="hidden" class="image_id" value="{{ data.img_id }}" name="img_id">
                                    <span class="upload-button dashicons dashicons-format-image"></span>
                                    <span class="remove-button dashicons dashicons-no-alt"></span>
                                </div>
                            </fieldset>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="parallax" value="1"> <?php _e( 'Enable Parallax background' ); ?>
                                </label>
                            </div>
                        </div>

                        <div class="tab-content" data-tab-id="content">

                            <label><?php _e( 'Background color', 'site-builder' );  ?></label>
                            <div class="input-group input-color">
                                <input type="text" name="content_bg_color" value="{{ data.bg_color }}" class="form-control">
                                <span class="input-group-addon"><i></i></span>
                            </div>

                            <fieldset class="form-group">
                                <label><?php _e( 'Background opacity', 'site-builder' );  ?></label>
                                <input type="number" name="content_opacity" value="{{ data.opacity }}" step="0.05" max="1" min="0" class="form-control">
                            </fieldset>

                            <label><?php _e( 'Text color', 'site-builder' );  ?></label>
                            <div class="input-group input-color">
                                <input type="text" name="content_text_color" value="{{ data.bg_color }}" class="form-control">
                                <span class="input-group-addon"><i></i></span>
                            </div>

                        </div>

                        <div data-tab-id="typography" class="tab-content">

                            <h1>typography setting here</h1>

                        </div>



                    </form>

                </div>
            </div>
            <?php /*
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php _e( 'Close', 'site-builder' ); ?></button>
            </div>
            */ ?>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</script>



















<script id="wp-sb-block-menu-bg" type="text/html">
    <div class="wp-sb-modal modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><?php _e( "Background Settings", 'site-builder' );  ?></h4>
            </div>

            <div class="modal-body-wrapper">
                <div class="modal-body">

                    <form>
                        <fieldset class="form-group">
                            <label><?php _e( 'Background color', 'site-builder' );  ?></label>
                            <input type="text" name="bg_color" value="{{ data.bg_color }}" class=" input_color">
                            <small class="text-muted">We'll never share your email with anyone else.</small>
                        </fieldset>

                        <fieldset class="form-group">
                            <label><?php _e( 'Background image', 'site-builder' );  ?></label>
                            <div class="item-media" style="background-image: url('{{ data.img_url }}');">
                                <input type="hidden" class="image_url" value="{{ data.img_url }}" name="img_url">
                                <input type="hidden" class="image_id" value="{{ data.img_id }}" name="img_id">
                                <span class="upload-button dashicons dashicons-format-image"></span>
                                <span class="remove-button dashicons dashicons-no-alt"></span>
                            </div>
                        </fieldset>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="parallax" value="1"> <?php _e( 'Enable Parallax background' ); ?>
                            </label>
                        </div>
                    </form>

                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php _e( 'Close', 'site-builder' ); ?></button>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</script>


<script id="wp-sb-block-menu-box" type="text/html">
    <div class="wp-sb-modal modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><?php _e( "Content Settings", 'site-builder' );  ?></h4>
            </div>

            <div class="modal-body-wrapper">
                <div class="modal-body">

                    <form>
                        <fieldset class="form-group">
                            <label><?php _e( 'Background color', 'site-builder' );  ?></label>
                            <input type="text" name="bg_color" value="{{ data.bg_color }}" class="input_color">
                        </fieldset>

                        <fieldset class="form-group">
                            <label><?php _e( 'Background opacity', 'site-builder' );  ?></label>
                            <input type="number" name="opacity" value="{{ data.opacity }}" step="0.05" max="1" min="0" class="form-control">
                        </fieldset>

                        <fieldset class="form-group">
                            <label><?php _e( 'Text color', 'site-builder' );  ?></label>
                            <input type="text" name="text_color" value="{{ data.text_color }}" class="input_color">
                        </fieldset>

                    </form>

                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php _e( 'Close', 'site-builder' ); ?></button>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</script>