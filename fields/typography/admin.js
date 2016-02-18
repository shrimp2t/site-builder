/**
 * Created by truongsa on 1/16/16.
 */

(function( $ ) {

    window.wp_sb_fields = window.wp_sb_fields || {};

    wp_sb_fields[ 'typography' ]  = {
        init: function( field ){

            field.element.on( 'click', function( e ) {
                e.preventDefault();
                data_default = field.element.attr('data-default') || '{}';
                data_default = JSON.parse(data_default);
                data_default['label'] = field.element.html();
                field.control.element_modal( field.element, field.field, field.key, data_default );
            });
        },
        open:  function( field  ){
            // data, element, modal, section
            //console.log( field );
        },
        change:  function( field  ){
            // data, element, modal, section
            field.element.html( field.data.label );

            // Update data
            field.control.updateData( 'fields', field.key, field.data );

        },
        save: function( field ){
            // data, element, modal , section
            field.element.html( field.data.label );

            // Update data
            field.control.updateData( 'fields', field.key, field.data );

        },
        close: function( field ){
            //  data, element, modal , section
        },

    };

})(jQuery);