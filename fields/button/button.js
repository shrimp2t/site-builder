/**
 * Created by truongsa on 1/16/16.
 */

(function( $ ) {

    window.wp_sb_fields = window.wp_sb_fields || {};

    wp_sb_fields[ 'button' ]  = {
        open:  function(   ){
            // data, element, modal, section
        },
        change:  function(   ){
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

        },
        close: function( ){
            //  data, element, modal , section

        },

    };

})(jQuery);