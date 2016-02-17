/**
 * Created by truongsa on 1/16/16.
 */



(function( $ ) {

    window.wp_sb_fields = window.wp_sb_fields || {};

    wp_sb_fields[ 'inline' ] = {
        init: function( field ){
            field.element.on( 'click', function( e ){
                e.preventDefault();
                field.element.attr( 'contenteditable', 'true' );
            } );

            field.element.on( 'blur keyup', function( e ){
                e.preventDefault();
                field.control.updateData( 'fields', field.key, field.element.text() );
            } );
        },
    };

})(jQuery);