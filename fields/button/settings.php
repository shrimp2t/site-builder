<script type="text/html" id="wp-sb-field-button-tpl">
    <div class="wp-sb-modal modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><?php _e( "Button settings", 'site-builder' );  ?></h4>
            </div>
            <div class="modal-body-wrapper">
                <div class="modal-body">

                    <form class="fake-form">
                        <fieldset class="form-group">
                            <label ><?php _e( 'Label', 'site-builder' ); ?></label>
                            <input type="text" name="label" class="form-control" value="{{ data.label }}" placeholder="<?php esc_attr_e( 'Button label', 'site-builder' ); ?>">
                            <small class="text-muted"><?php _e( 'Button label', 'site-builder' ); ?></small>
                        </fieldset>

                        <fieldset class="form-group">
                            <label><?php _e( 'URL', 'site-builder' ); ?></label>
                            <input type="text" name="url" value="{{ data.url }}" data-attr="href" class="form-control"  placeholder="<?php esc_attr_e( 'Link', 'site-builder' ); ?>">
                            <small class="text-muted"><?php _e( 'Custom button url' ); ?></small>
                        </fieldset>

                        <fieldset class="form-group">
                            <label for=""><?php _e( 'Button style', 'site-builder' ); ?></label>

                            <div class="form-control">
                                <!-- Provides extra visual weight and identifies the primary action in a set of buttons -->
                                <div class="checkbox buttons-select row">
                                    <div class="col col-md-6">
                                        <label>
                                            <input type="radio" <# if ( ! data.button_style || data.button_style === 'btn-primary' || data.button_style == '' ) { #> checked="checked" <# } #> name="button_style" value="btn-primary"> <span class="btn btn-primary">Primary</span>
                                        </label>
                                        <label>
                                            <input type="radio" <# if ( data.button_style === 'btn-secondary' ) { #> checked="checked" <# } #> name="button_style" value="btn-secondary">  <span  class="btn btn-secondary">Secondary</span>
                                        </label>
                                        <label>
                                            <input type="radio" <# if ( data.button_style === 'btn-success' ) { #> checked="checked" <# } #> name="button_style" value="btn-success">   <span class="btn btn-success">Success</span>
                                        </label>
                                        <label>
                                            <input type="radio" <# if ( data.button_style === 'btn-info' ) { #> checked="checked" <# } #> name="button_style" value="btn-info">   <span class="btn btn-info">Info</span>
                                        </label>

                                        <label>
                                            <input type="radio" <# if ( data.button_style === 'btn-warning' ) { #> checked="checked" <# } #>  name="button_style" value="btn-warning">  <span class="btn btn-warning">Warning</span>
                                        </label>

                                        <label>
                                            <input type="radio" <# if ( data.button_style === 'btn-danger' ) { #> checked="checked" <# } #>  name="button_style" value="btn-danger">  <span class="btn btn-danger">Danger</span>
                                        </label>

                                        <label>
                                            <input type="radio" <# if ( data.button_style === 'btn-link' ) { #> checked="checked" <# } #>  name="button_style" value="btn-link">  <span class="btn btn-link">Link</span>
                                        </label>
                                    </div>

                                    <div class="col col-md-6">
                                        <label>
                                            <input type="radio" <# if ( data.button_style === 'btn-primary-outline' ) { #> checked="checked" <# } #>  name="button_style" value="btn-primary-outline">   <span  class="btn btn-primary-outline">Primary</span>
                                        </label>

                                        <label>
                                            <input type="radio" <# if ( data.button_style === 'btn-secondary-outline' ) { #> checked="checked" <# } #>  name="button_style" value="btn-secondary-outline">   <span  class="btn btn-secondary-outline">Secondary</span>
                                        </label>

                                        <label>
                                            <input type="radio" <# if ( data.button_style === 'btn-success-outline' ) { #> checked="checked" <# } #>  name="button_style" value="btn-success-outline">    <span class="btn btn-success-outline">Success</span>
                                        </label>
                                        <label>
                                            <input type="radio" <# if ( data.button_style === 'btn-info-outline' ) { #> checked="checked" <# } #>  name="button_style" value="btn-info-outline">    <span class="btn btn-info-outline">Info</span>
                                        </label>

                                        <label>
                                            <input type="radio" <# if ( data.button_style === 'btn-warning-outline' ) { #> checked="checked" <# } #>  name="button_style" value="btn-warning-outline">   <span class="btn btn-warning-outline">Warning</span>
                                        </label>

                                        <label>
                                            <input type="radio" <# if ( data.button_style === 'btn-danger-outline' ) { #> checked="checked" <# } #>  name="button_style" value="btn-danger-outline">   <span  class="btn btn-danger-outline">Danger</span>
                                        </label>
                                    </div>

                                </div>

                                <!-- Secondary, outline button -->
                            </div>

                        </fieldset>
                        <fieldset class="form-group">
                            <label><?php _e( 'Button Size', 'site-builder' ); ?></label>
                            <select name="size" class="form-control">
                                <option <# if ( data.size === 'btn-medium' ) { #> selected="selected" <# } #> value="btn-medium"><?php _e( 'Medium', 'site-builder' ) ?></option>
                                <option <# if ( data.size === 'btn-lg' ) { #> selected="selected" <# } #> value="btn-lg"><?php _e( 'Large', 'site-builder' ) ?></option>
                                <option <# if ( data.size === 'btn-sm' ) { #> selected="selected" <# } #>  value="btn-sm"><?php _e( 'Small', 'site-builder' ) ?></option>
                            </select>
                        </fieldset>
                        <fieldset class="form-group">
                            <label><?php _e( 'Link Target', 'site-builder' ); ?></label>
                            <select data-attr="target" name="target" class="form-control">
                                <option value=""><?php _e( 'Current window', 'site-builder' ); ?></option>
                                <option <# if ( data.size === '_bank' ) { #> selected="selected" <# } #> value="_bank"><?php _e( 'New window', 'site-builder' ); ?></option>
                            </select>
                        </fieldset>

                    </form>


                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->

</script>