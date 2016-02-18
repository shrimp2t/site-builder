<script type="text/html" id="wp-sb-field-typography-tpl">
    <div class="wp-sb-modal modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><?php _e( "Typography", 'site-builder' );  ?></h4>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-tab-id="general" href="#">General</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-tab-id="design" href="#">Design</a>
                    </li>
                </ul>
            </div>
            <div class="modal-body-wrapper">
                <div class="modal-body">

                    <form class="fake-form">

                        <div class="tab-content" data-tab-id="general">
                            <fieldset class="form-group">
                                <label ><?php _e( 'Content', 'site-builder' ); ?></label>
                                <textarea class="form-control" name="label" rows="3">{{ data.label }}</textarea>
                            </fieldset>
                        </div>

                        <div class="tab-content" data-tab-id="design">
                            <fieldset class="form-group">
                                <label>Font name</label>
                                <select name="font-family" class="form-control">
                                    <option>Georgia</option>
                                    <option>Times</option>
                                    <option>Arial</option>
                                    <option>Helvetica</option>
                                    <option>Impact</option>
                                    <option>Tahoma</option>
                                </select>
                            </fieldset>
                            <fieldset class="form-group">
                                <label>Font Weight</label>
                                <select name="font-weight" class="form-control">
                                    <option value="normal">normal</option>
                                    <option value="bold">bold</option>
                                    <option value="bolder">bolder</option>
                                    <option value="lighter">lighter</option>
                                    <option value="100">100</option>
                                    <option value="200">200</option>
                                    <option value="300">300</option>
                                    <option value="400">400</option>
                                    <option value="500">500</option>
                                    <option value="600">600</option>
                                    <option value="700">700</option>
                                    <option value="800">800</option>
                                    <option value="900">900</option>
                                    <option value="initial">initial</option>
                                </select>
                            </fieldset>

                            <fieldset class="form-group">
                                <label>Font style</label>
                                <select name="font-style" class="form-control">
                                    <option value="normal">normal</option>
                                    <option value="italic">italic</option>
                                    <option value="oblique">oblique</option>
                                    <option value="initial">initial</option>
                                </select>
                            </fieldset>
                            <fieldset class="form-group">
                                <label>Font Size</label>
                                <input type="text" class="form-control" name="font-size">
                            </fieldset>
                            <fieldset class="form-group">
                                <label>Line Height</label>
                                <input name="line-height" type="text" class="form-control">
                            </fieldset>

                            <fieldset class="form-group">
                                <label>Letter spacing</label>
                                <input name="letter-spacing" type="text" class="form-control">
                            </fieldset>

                            <fieldset class="form-group">
                                <label><?php _e( 'Color', 'site-builder' );  ?></label>
                                <div class="input-group input-color">
                                    <input type="text" name="color" value="{{ data.color }}" class="form-control">
                                    <span class="input-group-addon"><i></i></span>
                                </div>
                            </fieldset>
                        </div>

                    </form>

                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->

</script>