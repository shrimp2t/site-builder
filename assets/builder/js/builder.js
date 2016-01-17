/**
 * jQuery serializeObject
 * @copyright 2014, macek <paulmacek@gmail.com>
 * @link https://github.com/macek/jquery-serialize-object
 * @license BSD
 * @version 2.5.0
 */
!function(e,i){if("function"==typeof define&&define.amd)define(["exports","jquery"],function(e,r){return i(e,r)});else if("undefined"!=typeof exports){var r=require("jquery");i(exports,r)}else i(e,e.jQuery||e.Zepto||e.ender||e.$)}(this,function(e,i){function r(e,r){function n(e,i,r){return e[i]=r,e}function a(e,i){for(var r,a=e.match(t.key);void 0!==(r=a.pop());)if(t.push.test(r)){var u=s(e.replace(/\[\]$/,""));i=n([],u,i)}else t.fixed.test(r)?i=n([],r,i):t.named.test(r)&&(i=n({},r,i));return i}function s(e){return void 0===h[e]&&(h[e]=0),h[e]++}function u(e){switch(i('[name="'+e.name+'"]',r).attr("type")){case"checkbox":return"on"===e.value?!0:e.value;default:return e.value}}function f(i){if(!t.validate.test(i.name))return this;var r=a(i.name,u(i));return l=e.extend(!0,l,r),this}function d(i){if(!e.isArray(i))throw new Error("formSerializer.addPairs expects an Array");for(var r=0,t=i.length;t>r;r++)this.addPair(i[r]);return this}function o(){return l}function c(){return JSON.stringify(o())}var l={},h={};this.addPair=f,this.addPairs=d,this.serialize=o,this.serializeJSON=c}var t={validate:/^[a-z_][a-z0-9_]*(?:\[(?:\d*|[a-z0-9_]+)\])*$/i,key:/[a-z0-9_]+|(?=\[\])/gi,push:/^$/,fixed:/^\d+$/,named:/^[a-z0-9_]+$/i};return r.patterns=t,r.serializeObject=function(){return new r(i,this).addPairs(this.serializeArray()).serialize()},r.serializeJSON=function(){return new r(i,this).addPairs(this.serializeArray()).serializeJSON()},"undefined"!=typeof i.fn&&(i.fn.serializeObject=r.serializeObject,i.fn.serializeJSON=r.serializeJSON),e.FormSerializer=r,r});


//--------------------------------------------

var WP_PB = function( $context ){
    var $ = jQuery;
    var that = this;
    that.settings = $context.attr( 'data-settings' ) || '{}';
    that.settings =  JSON.parse( that.settings );
    //console.log(  that );
    that.values = { 'tag': that.settings.tag ,  'fields': {}, 'settings': {} };

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

        return function ( data, template_id ) {
            compiled = _.template( $( template_id ) .first().html(), null, options);
            return compiled( data );
        };
    });

    that.template = that.repeaterTemplate();


    that.updateData =  function( $element, field , key ){

        if ( field.type === 'inline' ) {
            that.values['fields'][ key ] = $element.text();
            $context.attr( 'data-values', JSON.stringify( that.values ) );
            $context.trigger( 'change' );
        }

    };

    that.updateDataKey =  function( $element, key ,value ){
        that.values['fields'][ key ] = value;
        $context.attr( 'data-values', JSON.stringify( that.values ) );
        $context.trigger( 'change' );
    };


    that.updateDataSettings =  function( key ,value ){
        that.values['settings'][ key ] = value;
        $context.attr( 'data-values', JSON.stringify( that.values ) );
        $context.trigger( 'change' );
    };




    that.field_settings = function(){

        if( typeof that.settings.fields !== "undefined" ){
            _.each( that.settings.fields, function( field, key ){
                //console.log( field );
                var element =  $( '[data-content="'+key+'"]', $context );

                switch ( field.type ) {
                    case 'inline':

                            element.on( 'click', function( e ){
                                e.preventDefault();
                                element.attr( 'contenteditable', 'true' );
                            } );

                            element.on( 'blur keyup', function( e ){
                                e.preventDefault();
                                that.updateData( element, field, key );
                            } );
                        break;
                    case 'button':
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
                            element: element,
                            modal: modal,
                            section: $context,
                        } );
                    }
                }

            },
            change_cb: function( data, modal ) {

                if ( typeof window.wp_sb_fields[ field.type ] !== "undefined" ) {
                    if( typeof window.wp_sb_fields[ field.type].change ==="function" ) {
                        window.wp_sb_fields[ field.type].change( {
                            data: data,
                            element: element,
                            modal: modal,
                            section: $context,
                        } );
                    }
                }

            },
            save_cb: function( data, modal ){

                if ( typeof window.wp_sb_fields[ field.type ] !== "undefined" ) {
                    if( typeof window.wp_sb_fields[ field.type ].save === "function" ) {
                        window.wp_sb_fields[ field.type ].save( {
                            data: data,
                            element: element,
                            modal: modal,
                            section: $context,
                        } );
                    }
                }

                /*
                if ( field.type === 'button' ) {
                    element.text( data.label );
                    element.attr( 'href',  data.url );
                    element.attr( 'target',  data.target );

                    var classes = [ 'btn' ];

                    if ( typeof data.button_style !== "undefined" ) {
                        classes.push( data.button_style );
                    }

                    if ( typeof data.size !== "undefined" ) {
                        classes.push( data.size );
                    }
                    element.attr( 'class', '' );
                    element.addClass( classes.join(' ') );
                }
                */

            },
            close_cb: function( modal ){

                if ( typeof window.wp_sb_fields[ field.type ] !== "undefined" ) {
                    if( typeof window.wp_sb_fields[ field.type].open ==="function" ) {
                        window.wp_sb_fields[ field.type].open( {
                            data: data,
                            element: element,
                            modal: modal,
                            section: $context,
                        } );
                    }
                }

            },
        } );


    };

    that.when_focus = function(){
        $context.append( $( '#wp-sb-section-edit-menu').html() );
        $context.on( 'click', function(){
            $( '.wp-sb-builder-area .section').removeClass( 'section-editing' );
            $context.addClass( 'section-editing' );
        } );
    };


    // When settings bg
    $context.on( 'click', '.wp-sb-section-edit .bg' ,function( e ) {
        e.preventDefault();

        var data =  that.values['settings']['bg'];
        if (  typeof data === "undefined" ) {
            data = that.settings.settings.bg;
        }

        $( 'body' ).wp_sb_modal( {
            data: data,
            template: $( '#wp-sb-section-bg').html(), // HTML/Underscore template
            append_to: ".wp-sb-builder-area",
            wrap: ".wp-sb-builder-content-wrap",
            change_trigger: "wp_sb_section_bg_change",
            save_trigger: "wp_sb_modal_content_save",
            change_cb: function( data , _modal ) {
                $context.css( { 'background-color': data.bg_color , 'background-image': 'url("'+data.img_url+'")' } );
            },
            save_cb: function(){ },
            close_cb: function(){ },
        } );

    } );


    // When Content box change
    $context.on( 'click', '.wp-sb-section-edit .box' ,function( e ) {
        e.preventDefault();
        var data =  that.values['settings']['content_box'];
        if (  typeof data === "undefined" ) {
            data = that.settings.settings.content_box;
        }

        $( 'body' ).wp_sb_modal( {
            data: data,
            template: $( '#wp-sb-section-content-box').html(), // HTML/Underscore template
            append_to: ".wp-sb-builder-area",
            wrap: ".wp-sb-builder-content-wrap",
            change_trigger: "wp_sb_section_content_box_change",
            save_trigger: "wp_sb_modal_content_save",
            change_cb: function() { },
            save_cb: function(){ },
            close_cb: function(){ },
        } );

    } );

    // When click to text align icon
    $context.on( 'click', '.wp-sb-section-edit .text-align li' ,function( e ) {
        e.preventDefault();
        var value = $( this ).attr( 'data-value' );
        that.updateDataSettings( 'align', value );
        $( window ).trigger( 'wp_sb_section_align_change', [ value, $context, 'align' ] );
    });




    that.field_settings();
    that.when_focus();

};


//--------------------------------------------




jQuery( document ).ready( function( $ ){

    function update_builder_data(){
        var data = {};
        $( '.wp-sb-builder-area .section').each( function( index ){
            var _data = $( this).attr( 'data-values' ) || '{}';
            data[ index ] = JSON.parse( _data );
        } );
        $( '#wb-sb-template-content').val( JSON.stringify( data ) );
    }

    //---------------
    $( '.wp-sb-builder-area .section').each( function(){
        new WP_PB( $( this ) );
        $( this ).bind( 'change', function(){
            update_builder_data();
        } );
    } );

    $( '.wp-sb-builder-area' ).bind( 'change', function(){
        update_builder_data();
    } );


    $( '.wp-sb-builder-area').sortable({
        //placeholder: "section-placeholder",
        containment: $( '.wp-sb-builder-content-wrap'),
        //handle: ".handle",
        //helper: "clone",
        change: function( event, ui ) {
            update_builder_data();
        },
        handle: '.wp-section-order'
    });

    //---------------






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
            $( '.wp-sb-elements-wrap', section).height( $( window).height() - h );

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

} );
