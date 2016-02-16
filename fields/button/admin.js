/**
 * Created by truongsa on 1/16/16.
 */

(function( $ ) {

    window.wp_sb_fields = window.wp_sb_fields || {};

    wp_sb_fields[ 'button' ]  = {
        init: function( field ){
            field.element.on( 'click', function( e ) {
                e.preventDefault();
                data_default = field.element.attr('data-default') || '{}';
                data_default = JSON.parse(data_default);
                data_default['label'] = field.element.text();
                data_default['target'] = field.element.attr('target') || '';
                data_default['url'] = field.element.attr('href') || '#';
                field.control.element_modal( field.element, field.field, field.key, data_default );
            });
        },
        open:  function( field  ){
            // data, element, modal, section
        },
        change:  function( field  ){
            // data, element, modal, section

        },
        save: function( field ){
            // data, element, modal , section

            field.element.text( field.data.label );
            field.element.attr( 'href',  field.data.url );
            field.element.attr( 'target',  field.data.target );

            var classes = [ 'btn' ];

            if ( typeof field.data.button_style !== "undefined" ) {
                classes.push( field.data.button_style );
            }

            if ( typeof field.data.size !== "undefined" ) {
                classes.push( field.data.size );
            }

            field.element.attr( 'class', '' );
            field.element.addClass( classes.join(' ') );

            // Update data
            field.control.updateData( 'fields', field.key, field.data );

        },
        close: function( field ){
            //  data, element, modal , section
        },

    };

})(jQuery);