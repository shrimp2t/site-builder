/**
 * Created by truongsa on 1/15/16.
 */

var wp_sb_live_view =  function(){

};

console.log( 'called live view' );

jQuery( document ).ready( function( $ ){
    $( window ) .on( 'wp_sb_modal_save', function ( modal, data, element, field, key) {
        if ( field.type === 'button' ) {
            live_view_button( data, element );
        }
    } );

    function live_view_button( data, element ){
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



} );