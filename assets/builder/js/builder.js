/**
 * jQuery serializeObject
 * @copyright 2014, macek <paulmacek@gmail.com>
 * @link https://github.com/macek/jquery-serialize-object
 * @license BSD
 * @version 2.5.0
 */
!function(e,i){if("function"==typeof define&&define.amd)define(["exports","jquery"],function(e,r){return i(e,r)});else if("undefined"!=typeof exports){var r=require("jquery");i(exports,r)}else i(e,e.jQuery||e.Zepto||e.ender||e.$)}(this,function(e,i){function r(e,r){function n(e,i,r){return e[i]=r,e}function a(e,i){for(var r,a=e.match(t.key);void 0!==(r=a.pop());)if(t.push.test(r)){var u=s(e.replace(/\[\]$/,""));i=n([],u,i)}else t.fixed.test(r)?i=n([],r,i):t.named.test(r)&&(i=n({},r,i));return i}function s(e){return void 0===h[e]&&(h[e]=0),h[e]++}function u(e){switch(i('[name="'+e.name+'"]',r).attr("type")){case"checkbox":return"on"===e.value?!0:e.value;default:return e.value}}function f(i){if(!t.validate.test(i.name))return this;var r=a(i.name,u(i));return l=e.extend(!0,l,r),this}function d(i){if(!e.isArray(i))throw new Error("formSerializer.addPairs expects an Array");for(var r=0,t=i.length;t>r;r++)this.addPair(i[r]);return this}function o(){return l}function c(){return JSON.stringify(o())}var l={},h={};this.addPair=f,this.addPairs=d,this.serialize=o,this.serializeJSON=c}var t={validate:/^[a-z_][a-z0-9_]*(?:\[(?:\d*|[a-z0-9_]+)\])*$/i,key:/[a-z0-9_]+|(?=\[\])/gi,push:/^$/,fixed:/^\d+$/,named:/^[a-z0-9_]+$/i};return r.patterns=t,r.serializeObject=function(){return new r(i,this).addPairs(this.serializeArray()).serialize()},r.serializeJSON=function(){return new r(i,this).addPairs(this.serializeArray()).serializeJSON()},"undefined"!=typeof i.fn&&(i.fn.serializeObject=r.serializeObject,i.fn.serializeJSON=r.serializeJSON),e.FormSerializer=r,r});


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
            that.values = $.extend( {}, { 'tag': that.settings.tag ,  'fields': {}, 'settings': {} }, that.values );

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
                if ( typeof that.values[ type ] == "undefined" ) {
                    that.values[ type ] = {};
                }
                that.values[ type ][ key ] = value;
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
                return false;
            };

            that.field_settings = function(){

                if( typeof that.settings.fields !== "undefined" ){
                    _.each( that.settings.fields, function( field, key ){
                        console.log( field );
                        console.log( key );
                        console.log( '----' );
                        var element =  $( '[data-content="'+key+'"]', $context );

                        switch ( field.type ) {
                            case 'inline':

                                element.on( 'click', function( e ){
                                    e.preventDefault();
                                    element.attr( 'contenteditable', 'true' );
                                } );

                                element.on( 'blur keyup', function( e ){
                                    e.preventDefault();
                                    that.updateDataInline( element, field, key );
                                } );
                                break;
                            default :
                                element.on( 'click', function( e ){
                                    e.preventDefault();
                                    if ( element.attr( 'data-open-modal' ) !== 'y' ) {
                                        data_default = element.attr( 'data-default' ) || '{}';
                                        data_default = JSON.parse( data_default );
                                        data_default['label']  = element.text();
                                        data_default['target'] = element.attr( 'target' ) || '';
                                        data_default['url'] = element.attr( 'href' ) || '#';
                                        that.element_modal( element , field, key, data_default  );
                                    }
                                } );

                                break;
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
            $context.append( that.template( that.settings.settings, $( '#wp-sb-section-edit-menu').html()  ));
            $context.on( 'click', function(){
                $( '.wp-sb-builder-area .section').removeClass( 'section-editing' );
                $context.addClass( 'section-editing' );
            } );

            // When settings click
            $context.on( 'click', '.wp-sb-section-edit .block-settings' ,function( e ) {
                e.preventDefault();
                var _type = $( this).attr( 'data-block-type' ) || '';
                var _cb = $( this).attr( 'data-block-cb' ) || '';
                var element = $( this );

                var data =   that.getValue( 'settings', _cb ) ;
                if (  typeof data === "undefined" ) {
                    data = that.settings.settings[ _type ] || {};
                }

                var cb = false;
                if ( _cb === '' ) {
                    return ;
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
                $( '.section', area ).each( function( index ){
                    var _data = $( this).attr( 'data-values' ) || '{}';
                    data[ index ] = JSON.parse( _data );
                } );
                value_field.val( JSON.stringify( data ) );
            }

            $( '.section', area ).each( function(){
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
