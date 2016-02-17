/*!
 * jQuery serializeObject - v0.2 - 1/20/2010
 * http://benalman.com/projects/jquery-misc-plugins/
 *
 * Copyright (c) 2010 "Cowboy" Ben Alman
 * Dual licensed under the MIT and GPL licenses.
 * http://benalman.com/about/license/
 */

// Whereas .serializeArray() serializes a form into an array, .serializeObject()
// serializes a form into an (arguably more useful) object.


(function($,undefined){
    '$:nomunge'; // Used by YUI compressor.

    $.fn.serializeObject = function(){
        var obj = {};

        $.each( this.serializeArray(), function(i,o){
            var n = o.name,
                v = o.value;

            obj[n] = obj[n] === undefined ? v
                : $.isArray( obj[n] ) ? obj[n].concat( v )
                : [ obj[n], v ];
        });

        return obj;
    };

})(jQuery);


//--------------------------------------------

(function ( $ ) {

    $.fn.wp_sb_block_builder = function(  ) {

        return this.each( function() {
            // Do something to each element here.
            var $context = $( this );
            var that = this;
            that.settings = $context.attr( 'data-settings' ) || '{}';
            that.settings =  JSON.parse( that.settings );
            //console.log(  that );
            that.values = $context.attr( 'data-values' ) || '{}';
            that.values =  JSON.parse( that.values );
            //that.values = { 'tag': that.settings.tag ,  'fields': {}, 'settings': {} };
            that.values = $.extend( {}, { 'tag': that.settings.tag , 'fields': {}, 'settings': {} }, that.values );

            /**
             * Function that loads the Mustache template
             */
            that.repeaterTemplate = _.memoize(function () {
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

                return function ( data, html ) {
                    compiled = _.template( html, null, options);
                    return compiled( data );
                };
            });
            that.template = that.repeaterTemplate();

            that.updateDataInline =  function( $element, field , key ){
                if ( field.type === 'inline' ) {
                    that.updateData( 'fields', key, $element.text() );
                }
            };

            that.updateData =  function( type, key ,value ){
                if ( typeof that.values[ type ] === "undefined" ) {
                    that.values[ type ] = {};
                }
                that.values[ type ][ key ] = value;
               // console.log( JSON.stringify( that.values ));
                $context.attr( 'data-values', JSON.stringify( that.values ) );
                $context.trigger( 'change' );
            };

            that.getValue = function( type , key ) {
                that.values = $context.attr( 'data-values' ) || '{}';
                that.values = JSON.parse( that.values );

                if ( typeof that.values[ type ] !== "undefined" ) {
                    if ( typeof that.values[ type ][ key ] !== "undefined" ) {
                        return that.values[ type ][ key ];
                    }
                }

                if ( typeof that.values[ type ] !== "undefined" ) {
                    return that.values[ type ][ key ];
                }
                return false;
            };

            that.field_settings = function(){

                if( typeof that.settings.fields !== "undefined" ){
                    _.each( that.settings.fields, function( field, key ){
                        var element =  $( '[data-section-id="' + that.settings.tag + '"][data-content="'+key+'"]', $context );
                        var data =  that.values['fields'][ key ] || {};
                        if ( typeof window.wp_sb_fields[ field.type ] !== "undefined" ) {
                            if( typeof window.wp_sb_fields[ field.type ].init === "function" ) {
                                window.wp_sb_fields[ field.type ].init( {
                                    data: data,
                                    key: key,
                                    element: element,
                                    field: field,
                                    section: $context,
                                    control: that,
                                } );
                            }
                        }

                    } );
                }

            };


            that.element_modal = function( element, field, key, default_values ){

                var data =  that.values['fields'][ key ];
                if (  typeof data === "undefined" ) {
                    data = default_values;
                }

                var html = {};

                if ( $( '#wp-sb-field-'+field.type+'-tpl' ).length > 0 ) {
                    html = $( '#wp-sb-field-'+field.type+'-tpl').html();
                }

                $( 'body' ).wp_sb_modal( {
                    data: data,
                    template: html, // HTML/Underscore template
                    append_to: ".wp-sb-builder-area",
                    wrap: ".wp-sb-builder-content-wrap",
                    change_trigger: "wp_sb_section_bg_change",
                    save_trigger: "wp_sb_modal_content_save",
                    open_cb: function( data, modal ) {

                        if ( typeof window.wp_sb_fields[ field.type ] !== "undefined" ) {
                            if( typeof window.wp_sb_fields[ field.type].open ==="function" ) {
                                window.wp_sb_fields[ field.type].open( {
                                    data: data,
                                    key: key,
                                    element: element,
                                    modal: modal,
                                    section: $context,
                                    control: that,
                                } );
                            }
                        }

                    },
                    change_cb: function( data, modal ) {

                        if ( typeof window.wp_sb_fields[ field.type ] !== "undefined" ) {
                            if( typeof window.wp_sb_fields[ field.type].change ==="function" ) {
                                window.wp_sb_fields[ field.type].change( {
                                    data: data,
                                    key: key,
                                    element: element,
                                    modal: modal,
                                    section: $context,
                                    control: that,
                                } );
                            }
                        }
                    },
                    save_cb: function( data, modal ){

                        if ( typeof window.wp_sb_fields[ field.type ] !== "undefined" ) {
                            if( typeof window.wp_sb_fields[ field.type ].save === "function" ) {
                                window.wp_sb_fields[ field.type ].save( {
                                    data: data,
                                    key: key,
                                    element: element,
                                    modal: modal,
                                    section: $context,
                                    control: that,
                                } );
                            }
                        }

                    },
                    close_cb: function( modal ){

                        if ( typeof window.wp_sb_fields[ field.type ] !== "undefined" ) {
                            if( typeof window.wp_sb_fields[ field.type].open ==="function" ) {
                                window.wp_sb_fields[ field.type].open( {
                                    data: data,
                                    key: key,
                                    element: element,
                                    modal: modal,
                                    section: $context,
                                    control: that,
                                } );
                            }
                        }

                    },
                } );

            };

            //Add section block settings
            var $block_menu = $( that.template( that.settings.settings, $( '#wp-sb-section-edit-menu').html() ) );
            $context.append( $block_menu );
            $context.on( 'click', function(){
                $( '.wp-sb-builder-area .section').removeClass( 'section-editing' );
                $context.addClass( 'section-editing' );
            } );


            // When settings click
            $block_menu.on( 'click', '.block-settings' ,function( e ) {
                e.preventDefault();
                var $menu = $( this );
                if ( $menu.hasClass( 'opened' ) ) {
                    return ;
                }
                $menu.addClass( 'opened' );

                var _type = $( this).attr( 'data-block-type' ) || '';
                var _cb = $( this).attr( 'data-block-cb' ) || '';

                var element = $( this );

                var data =   that.getValue( 'settings', _cb ) ;
                if (  typeof data === "undefined" ) {
                    data = that.settings.settings[ _type ] || {};
                }
                // console.log( _cb );
                var cb = false;
                if ( _cb === '' ) {
                    _cb = 'design' ;
                    data = that.getValue( 'settings' ) ;
                    _type = 'modal';
                }

                if ( typeof window.wp_sb_block_fields[ _cb ] !== "undefined" ) {
                    cb = window.wp_sb_block_fields[ _cb ];
                }

                if ( _type === 'modal' ) {
                    $( 'body' ).wp_sb_modal( {
                        data: data,
                        template: $( '#wp-sb-block-menu-'+_cb ).html(), // HTML/Underscore template
                        append_to: ".wp-sb-builder-area",
                        wrap: ".wp-sb-builder-content-wrap",
                        change_trigger: "wp_sb_section_bg_change",
                        save_trigger: "wp_sb_modal_content_save",
                        open_cb: function( data, modal ) {
                            if ( typeof cb.open !== "undefined" ) {
                                cb.open( {
                                    data: data,
                                    modal: modal,
                                    element: element,
                                    section: $context,
                                    control: that,
                                } );
                            }
                        },
                        change_cb: function( data, modal ) {

                            if ( typeof cb.change !== "undefined" ) {
                                cb.change( {
                                    data: data,
                                    modal: modal,
                                    element: element,
                                    section: $context,
                                    control: that,
                                } );
                            }

                        },
                        save_cb: function( data, modal ){
                            if ( typeof cb.save !== "undefined" ) {
                                cb.save( {
                                    data: data,
                                    modal: modal,
                                    element: element,
                                    section: $context,
                                    control: that,
                                } );
                            }

                            $menu.removeClass( 'opened' );
                        },
                        close_cb: function( modal ){
                            if ( typeof cb.close !== "undefined" ) {
                                cb.save( {
                                    modal: modal,
                                    element: element,
                                    section: $context,
                                    control: that,
                                } );
                            }

                            $menu.removeClass( 'opened' );
                        },
                    } );
                } else {
                    if ( typeof cb === "function" ) {
                        cb({
                            data: data,
                            element: element,
                            section: $context,
                            control: that,
                        } );
                    }
                }

            } );


            that.field_settings();


            return this;

        });

    };

}( jQuery ));



//--------------------------------------------

(function ( $ ) {

    $.fn.wp_sb_builder = function( options ) {

        options = $.extend({
            value_field: "#wb-sb-template-content",
            containment: ".wp-sb-builder-content-wrap",
        }, options );


        var value_field, area;
        if ( typeof options.value_field !== "object" ){
            value_field = $( options.value_field );
        } else {
            value_field = options.value_field;
        }


        return this.each( function() {

            area =  $( this );

            function update_builder_data(){
                var data = {};
                $( ' >.section ', area ).each( function( index ){
                    var _data = $( this ).attr( 'data-values' ) || '{}';
                    data[ index ] = JSON.parse( _data );
                } );
                value_field.val( JSON.stringify( data ) );
            }

            update_builder_data();

            $( '>.section', area ).each( function(){
                $( this).wp_sb_block_builder(  );
                $( this ).bind( 'change', function(){
                    update_builder_data();
                } );
            } );

            area.bind( 'change', function(){
                update_builder_data();
            } );

            // when remove section
            area.on( 'click', '.section .remove-section', function( e ){
                e.preventDefault();
                $( this).parents( '.section').remove();
                area.trigger( 'change' );
            } );


            area.sortable({
                //placeholder: "section-placeholder",
                containment: options.containment,
                //handle: ".handle",
                //helper: "clone",
                change: function( event, ui ) {
                    update_builder_data();
                },
                update: function( event, ui ) {
                    update_builder_data();
                },
                handle: '.wp-section-order'
            });

            return this;

        } );
    };

}( jQuery ));




jQuery( document ).ready( function( $ ){


    $( '.wp-sb-builder-area' ).wp_sb_builder();

    // Add elemnt
    $( '.wp-sb-element').on( 'click', function( e ){
        e.preventDefault();
        var el_id =  $( this).attr( 'data-el-id' ) || '';
        var section = {};
        if ( el_id !== '' ){
            section = $( $( '#wp_sb_tpl_block_'+el_id).html() );
        }

        $( '.wp-sb-builder-area').append( section );
        section.wp_sb_block_builder();
        $( '.wp-sb-builder-area').trigger( 'change' );

    } );

    var panel = $( '.wp-sb-panel');

    $( '.wp-sb-collapse-sidebar').on( 'click', function( e ){
        e.preventDefault();
        $( 'body' ).toggleClass( 'wp-sb-sidebar-collapse' );
    } );


    $( '.wp-sb-section').each( function(){
        var section = $( this );

        section.on( 'click', '.wp-sb-section-title' , function( e ){
            e.preventDefault();
            panel.css( 'overflow', 'hidden');
            section.addClass( 'open' );
            panel.toggleClass( 's-open' );
            var h = $( '.wp-sb-actions').height() + $( '.wp-sb-e-section-title').height();
            $( '.wp-sb-elements-wrap', section ).height( $( window).height() - h );

            setTimeout( function(){
                panel.removeAttr( 'style' );
            }, 500 );

        } );

        section.on( 'click', '.wp-sb-e-section-back', function( e ){
            e.preventDefault();
            section.removeClass( 'open' );
            panel.removeClass( 's-open' );
        } );

        $( window).resize( function(){
            var h = $( '.wp-sb-actions').height() + $( '.wp-sb-e-section-title').height();
            $( '.wp-sb-elements-wrap', section ).height( $( window).height() - h );
        });

    } );


    // When save
    $( '.wp-sb-save').on( 'click', function( e ){
        e.preventDefault();

        var data = {
            'action': 'wp_save_site_builder',
            'builder_content': $( '#wb-sb-template-content').val()
        };

        $.ajax( {
            url: wpSiteBuilder.ajax_url,
            data: data,
            type: 'post',
            success: function(){

            }
        } );


    } );


} );
