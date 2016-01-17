/**
 * Created by truongsa on 1/16/16.
 */

(function ( $ ) {

    $.fn.wp_sb_fields = function( options ) {

        return this.each(function() {
            // Do something to each element here.
            var $context = this;

            // Media upload
            var frame = wp.media({
                title: wp.media.view.l10n.addMedia,
                multiple: false,
                library: {type: 'image'},
                //button : { text : 'Insert' }
            });

            frame.on('close', function () {
                var selection = frame.state().get('selection');
            });


            $('.item-media', $context).each( function(){
                var _item = $( this );
                // when remove item
                $( '.remove-button', _item ).on( 'click', function( e ){
                    e.preventDefault();

                    $( '.image_id, .image_url', _item).val( '' );
                    $('.item-media', $context).css( 'background-image', 'none'  );
                    $( this).hide();
                    $('.upload-button', _item ).text( $('.upload-button', _item ).attr( 'data-add-txt' ) );
                    $( '.image_id', _item).trigger( 'change' );
                } );

                // when upload item
                $('.upload-button', _item ).on('click', function () {
                    var btn = $( this );

                    frame.on('select', function () {
                        // Grab our attachment selection and construct a JSON representation of the model.
                        var media_attachment = frame.state().get('selection').first().toJSON();
                        // media_attachment= JSON.stringify(media_attachment);

                        $( '.image_id', _item ).val(media_attachment.id);
                        var preview, img_url;
                        img_url = media_attachment.url;

                        $( '.current', _item ).removeClass( 'hide').addClass( 'show' );

                        $( '.image_url', _item ).val(img_url);
                        $('.item-media', $context).css( 'background-image', 'url("'+img_url+'")'  );
                        $( '.remove-button', _item).show();
                        $( '.image_id', _item).trigger( 'change' );
                        btn.text( btn.attr( 'data-change-txt' ) );

                    });

                    frame.open();

                });
            } );


            // Color input
            $('.input_color', $context ).each( function(){
                var input = $( this );
                input.wpColorPicker( {

                    change: function(event, ui ) {
                        input.val( ui.color.toString() ).trigger( 'change' );
                        //input.trigger( 'change' );
                    }

                } );
            } );

            //


        });

    };

}( jQuery ));


/* Modal Plugin */

(function ( $ ) {

    $.fn.wp_sb_modal = function( options ) {

        // This is the easiest way to have default options.
        var settings = $.extend( {
            data: {},
            template: '', // HTML/Underscore template
            append_to: ".wp-sb-builder-area",
            wrap: ".wp-sb-builder-content-wrap",
            open_trigger: "", // wp_sb_modal_content_open
            change_trigger: "", // wp_sb_modal_content_change
            save_trigger: "", // wp_sb_modal_content_save
            open_cb: function() { },
            change_cb: function() { },
            save_cb: function(){ },
            close_cb: function(){ }

        }, options );

        var wrap, append_to;
        if ( typeof settings.wrap !== "object" ){
            wrap = $( settings.wrap );
        } else {
            wrap = settings.wrap;
        }

        if ( typeof settings.append_to !== "object" ){
            append_to = $( settings.append_to );
        } else {
            append_to = settings.append_to;
        }

        /**
         * Function that loads the Mustache template
         */
        var repeaterTemplate = _.memoize(function () {
            var compiled,
            /*
             * Underscore's default ERB-style templates are incompatible with PHP
             * when asp_tags is enabled, so WordPress uses Mustache-inspired templating syntax.
             *
             * @see trac ticket #22344.
             */
                options = {
                    evaluate: /<#([\s\S]+?)#>/g,
                    interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
                    escape: /\{\{([^\}]+?)\}\}(?!\})/g,
                    variable: 'data'
                };

            return function ( data, html_template ) {
                compiled = _.template( html_template, null, options );
                return compiled( data );
            };
        });

        var template = repeaterTemplate();

        return this.each(function() {

            var modal = $( template( settings.data , settings.template ) );
            append_to.append( modal );

            var ww = wrap.width();
            var modal_w = $( '.modal-dialog', wrap ).width();
            $( '.modal-dialog', wrap ).css( { 'top': '30px', 'left': ( (  ww - modal_w  ) / 2) + 'px' } );

            $( '.modal-dialog', wrap ).draggable({
                containment: wrap,
                handle: ".modal-header, .modal-footer",
            }).resizable( {
                containment: wrap,
                start: function( event, ui ) {
                    var h = $( '.modal-header', ui.element ).outerHeight() + $( '.modal-footer', ui.element ).outerHeight();
                    $( '.modal-body-wrapper', ui.element ).height( ui.size.height - h );
                },
                resize: function( event, ui ) {
                    var h = $( '.modal-header', ui.element).outerHeight() + $( '.modal-footer', ui.element).outerHeight();
                    $( '.modal-body-wrapper', ui.element ).height( ui.size.height - h );
                }
            });

            // Set up fields
            modal.wp_sb_fields();

            //When open modal
            if ( settings.open_trigger !== "" ) {
                $( window ).trigger( settings.open_trigger, [ settings.data, modal ] );
            }
            if ( typeof settings.open_cb  == "function" ) {
                settings.open_cb( settings.data, modal );
            }

            // When close modal
            modal.on( 'click', '[data-dismiss="modal"]', function(){
                if ( typeof settings.close_cb  == "function" ) {
                    settings.close_cb( modal );
                }
                modal.remove();
            } );

            // When input inside changes
            modal.on( 'change', 'input, select, textarea' , function() {
                var data =  $( 'form', modal ).serializeObject();
                if ( settings.change_trigger !== "" ) {
                    $( window ).trigger( settings.change_trigger, [ data, modal ] );
                }
                if ( typeof settings.change_cb  == "function" ) {
                    settings.change_cb(  data, modal );
                }
            } );

            // When hit save change
            modal.on( 'click', '.wp-sb-modal-save', function( e ){
                e.preventDefault();
                var data =  $( 'form', modal ).serializeObject();
                if ( settings.save_trigger !== '' ){
                    $( window ).trigger( settings.save_trigger , [ data, modal ] );
                }

                if ( typeof settings.save_cb  == "function" ) {
                    settings.save_cb( data, modal );
                }

                modal.remove();
            } );


        });

    };

}( jQuery ));


