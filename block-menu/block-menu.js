/**
 * Created by truongsa on 1/17/16.
 */
function hexToRgb(hex) {
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);

    if ( result ) {
        var r = parseInt(result[1], 16),
            g = parseInt(result[2], 16),
            b = parseInt(result[3], 16);
        return r + "," + g + "," + b;
    } else {
        return false;
    }

}


(function( $ ) {

    window.wp_sb_block_fields = window.wp_sb_block_fields || {};

    wp_sb_block_fields[ 'bg' ]  = {
        open:  function( field  ){
            // data, element, modal, section
        },
        change:  function( field  ){
            field.section.css( { 'background-color': field.data.bg_color , 'background-image': 'url("'+field.data.img_url+'")' } );
            field.control.updateData( 'settings', 'bg', field.data );
        },
        save: function( field ){
            // data, element, modal , section

        },
        close: function( field ){
            //  data, element, modal , section
        },

    };

    wp_sb_block_fields['align'] = function( field ){
        var value = field.element.attr( 'data-value' );
        field.control.updateData( 'settings', 'align', value );
        field.section.css( { 'text-align': value } );
    };


    wp_sb_block_fields[ 'box' ]  = {
        open:  function( field  ){
            // data, element, modal, section
        },
        change:  function( field  ){

            var rgb= hexToRgb( field.data.bg_color );
            field.data.opacity = parseFloat( field.data.opacity );
            if ( isNaN( field.data.opacity ) ) {
                field.data.opacity =  1;
            }

            if ( field.data.opacity > 1 ) {
                field.data.opacity = 1;
            }

            if( rgb ) {
                rgb +=","+field.data.opacity;
            }

            $( '.content-box', field.section ).css( {
                'background-color': "rgba("+rgb+")",
                'color': field.data.text_color,
            } );

        },
        save: function( field ){
            // data, element, modal , section

        },
        close: function( field ){
            //  data, element, modal , section
        },

    };






})(jQuery);