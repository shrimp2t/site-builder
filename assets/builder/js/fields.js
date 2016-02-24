/**
 * Created by truongsa on 1/16/16.
 */

/**
 * Cookie
 *
 * @type {{set: Function, get: Function}}
 */
var wp_sb_cookie = {
    set : function( cname, cvalue, exdays ){
        var d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        var expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + "; " + expires;
    },
    get: function( cname ){
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i=0; i<ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1);
            if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
        }
        return "";
    },
};
// end cookies

(function( $ ) {

    window.wp_sb_live_css_data = window.wp_sb_live_css_data || {};
    window.wp_sb_render_css_code = window.wp_sb_render_css_code || {};

    window.wp_sb_live_css = {
        code: '',
        isANumber: function isANumber( n ) {
            var numStr = /^-?\d+\.?\d*$/;
            return numStr.test( n.toString() );
        },

        setupData: function( _data, unit ) {
            var that = this;
            if (  typeof _data !== "object" && typeof _data !== "array" ) {
                return _data;
            }

            if (  typeof unit == "undefined" ) {
                unit = 'px';
            }

            for (var key in _data ) {
                if (_data.hasOwnProperty(key)) {
                    var value =  _data[key];
                    if (  typeof value === 'string' ) {
                        if ( that.isANumber( value ) ) {
                            _data[ key ] = value+unit;
                        }
                    }
                }
            }

            return _data;
        },
        add: function ( id, selector, css , unit ) {
            var that = this;
            wp_sb_live_css_data[ id ] = { id: id, selector: selector, css: that.setupData( css , unit ) } ;
        },

        remove: function ( id ) {
            delete wp_sb_live_css_data[ id ];
        },

        render: function(){
            var css = this;
            var render_item = $( '<div class="wp_sb_css_render_test"></div>' );
            $( 'head').append('<style type="text/css" id="wp_sb_css_render_test_css">#wp_sb_css_render_test { display: none !important; }</style>');
            $( 'body').append( render_item );

            var data, item_code;
            css.code = '';
            for (var key in wp_sb_live_css_data ) {
                data = wp_sb_live_css_data[ key ];
                render_item.removeAttr('style');
                render_item.css( data.css );
                item_code = render_item.attr( 'style' ) || '';
                if ( item_code !== '' ) {
                    css.code +=' '+data.selector+'{ '+item_code+' }'+"\n";
                    window.wp_sb_render_css_code[ key ] = item_code;
                }
            }

            $( '#wp_sb_css_render_test, #wp_sb_css_render_test_css, #wp-sb-css-live-render').remove();
            $( 'head').append('<style type="text/css" id="wp-sb-css-live-render">'+css.code+'</style>');

        },
        get: function( key ){
            if ( typeof window.wp_sb_render_css_code[ key ] !== "undefined" ) {
                return window.wp_sb_render_css_code[ key ];
            }
            return '';
        },



    };

})(jQuery);

/*
jQuery( document ).ready( function( $ ){
    var css = {
        background: 'red',
        color: '#333',
        textAlign: 'center',
    };

    window.wp_sb_live_css.add('test_id', '.wp-sb-builder-area', css );
    window.wp_sb_live_css.render();

} );
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
            $('.input-color', $context ).each( function(){
                var input = $( this );
                input.colorpicker();
            } );



        });

    };

}( jQuery ));


/* Modal Plugin */

window.wp_sb_modal = window.wp_sb_modal || { width: 0, height: 0, left: 0, top: 0 };

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

            // Tabs setup
            var tabs =  $( '.nav-tabs', modal );
            if ( tabs.length > 0 ) {

                $( '.nav-item .nav-link', tabs).each( function () {

                    if ( $( this).hasClass( 'active' ) ) {
                        var tab_id = $( this).attr( 'data-tab-id' ) || '';
                        if ( tab_id != '' ) {
                            $( '.tab-content', modal).hide();
                            $( '.tab-content[data-tab-id="'+tab_id+'"]', modal ).show();
                        }
                    }

                    $( this).on( 'click', function( e ) {
                        e.preventDefault();
                        $( '.nav-item .nav-link', tabs).removeClass( 'active' );
                        $( this ).addClass( 'active' );
                        var tab_id = $( this).attr( 'data-tab-id' ) || '';
                        if ( tab_id != '' ) {
                            $( '.tab-content', modal).hide();
                            $( '.tab-content[data-tab-id="'+tab_id+'"]', modal ).show();
                        }
                    } );
                } );
            } // end tabs setup

            if ( window.wp_sb_modal.width <= 0 ) {
                window.wp_sb_modal.width = modal.width();
            }

            if ( window.wp_sb_modal.height <= 0 ) {
                window.wp_sb_modal.height = modal.outerHeight();
            }

            if ( window.wp_sb_modal.top <= 0 ) {
                window.wp_sb_modal.top = 30;
            }

            if ( window.wp_sb_modal.left <= 0 ) {
                var ww = wrap.width();
                var modal_w = $( '.modal-dialog', wrap ).width();
                window.wp_sb_modal.left = ( (  ww - modal_w  ) / 2) + wrap.offset().left ;
            }

            modal.width( window.wp_sb_modal.width );
            modal.css( { 'top': window.wp_sb_modal.top+'px', 'left': window.wp_sb_modal.left + 'px' } );

            var h = $( '.modal-header', modal ).outerHeight() + $( '.modal-footer', modal ).outerHeight();
            $( '.modal-body-wrapper', modal ).height( window.wp_sb_modal.height - h );
            modal.height( window.wp_sb_modal.height );


            $( '.modal-dialog', wrap ).draggable({
                containment: wrap,
                handle: ".modal-header, .modal-footer",
                drag: function( event, ui ) {
                    window.wp_sb_modal.top = ui.position.top;
                    window.wp_sb_modal.left = ui.position.left;
                }
            }).resizable( {
                containment: wrap,
                minWidth: 300,
                start: function( event, ui ) {
                    var h = $( '.modal-header', ui.element ).outerHeight() + $( '.modal-footer', ui.element ).outerHeight();
                    $( '.modal-body-wrapper', ui.element ).height( ui.size.height - h );

                    window.wp_sb_modal.width = ui.size.width;
                    window.wp_sb_modal.height = ui.size.height;
                },
                resize: function( event, ui ) {
                    var h = $( '.modal-header', ui.element ).outerHeight() + $( '.modal-footer', ui.element).outerHeight();
                    $( '.modal-body-wrapper', ui.element ).height( ui.size.height - h );

                    window.wp_sb_modal.width = ui.size.width;
                    window.wp_sb_modal.height = ui.size.height;
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
            modal.on( 'change changeColor keyup', 'input, select, textarea, .input-color' , function() {
                var data =  $( 'form', modal ).serializeObject();
                if ( settings.change_trigger !== "" ) {
                    $( window ).trigger( settings.change_trigger, [ data, modal ] );
                }
                if ( typeof settings.change_cb  == "function" ) {
                    settings.change_cb( data, modal );
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


