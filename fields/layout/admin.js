/**
 * Created by truongsa on 1/16/16.
 */

(function( $ ) {

    window.wp_sb_fields = window.wp_sb_fields || {};

    wp_sb_fields[ 'layout' ]  = {
        update_data: function( field ){
            var values =  {};
            $( ' > .section', field.element ).each( function( index ) {
                values[ index ] = JSON.parse( $( this).attr( 'data-values' ) || '{}' );
            } );

            // Update data
            field.control.updateData( 'fields', field.key, values );

        },
        init: function( field ){
            var that = this;

            field.element.wrap("<div class='layout-wrapper'></div>" );
            that.wrapper = field.element.parent();

            var toolbar = $( '#wp-sb-field-layout-toolbar-tpl').html();
            that.wrapper.prepend( toolbar );
            that.wrapper.on( 'click', '.add-item', function( e ) {
                e.preventDefault();
                field.control.element_modal( field.element, field.field, field.key, {} );

            });

            // wp_sb_block_builder
            $( ' > .section', field.element ).wp_sb_block_builder();

            field.element.sortable({
                //placeholder: "section-placeholder",
                containment: field.element,
                //handle: ".handle",
                change: function( event, ui ) {
                    that.update_data( field );
                },
                update: function( event, ui ) {
                    that.update_data( field );
                },
                handle: '.wp-section-order'
            });

            that.update_data( field );
            $( ' > .section', field.element ).on( 'change', function(){
                that.update_data( field );
            } );

        },
        open:  function( field ){
            var that = this;
            // data, element, modal, section
            field.modal.on( 'click', '.wp-sb-element', function( e ){
                // Add elemnt
                e.preventDefault();
                var el_id =  $( this).attr( 'data-el-id' ) || '';
                var section = {};
                if ( el_id !== '' ){
                    section = $( $( '#wp_sb_tpl_block_'+el_id).html() );
                }

                field.element.append( section );
                section.wp_sb_block_builder();
                //section.wp_sb_fields();
                section.on( 'change', function(){
                    that.update_data( field );
                } );

                that.update_data( field );

                field.modal.remove();

            } );
            // wpSiteBuilder
        },
        change:  function( field  ){
            // data, element, modal, section

        },
        save: function( field ){
            // data, element, modal , section

            //field.element.addClass( classes.join(' ') );
            // Update data
            field.control.updateData( 'fields', field.key, field.data );
        },
        close: function( field ){
            //  data, element, modal , section
        },

    };

})(jQuery);