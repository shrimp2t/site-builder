/**
 * Created by truongsa on 1/17/16.
 */
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




})(jQuery);