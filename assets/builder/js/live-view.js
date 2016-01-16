/**
 * Created by truongsa on 1/15/16.
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

    // When section  BG change
    /*
    $( window).on( 'wp_sb_section_bg_change',  function(  modal, data, $content, key ){
        $content.css( { 'background-color': data.bg_color , 'background-image': 'url("'+data.img_url+'")' } );
    } );
    */

    // When context box change
    /*
    $( window).on( 'wp_sb_section_content_box_change',  function(  modal, data, $content, key ){
        //$content.css( { 'background-color': data.bg_color , 'background-image': 'url("'+data.img_url+'")' } );
        var rgb= hexToRgb( data.bg_color );
        data.opacity = parseFloat( data.opacity );
        if ( isNaN( data.opacity ) ) {
            data.opacity =  1;
        }

        if ( data.opacity > 1 ) {
            data.opacity = 1;
        }

        if( rgb ) {
            rgb +=","+data.opacity;
        }

        $( '.content-box', $content).css( {
            'background-color': "rgba("+rgb+")",
            'color': data.text_color,
        } );
    } );

    $( window).on( 'wp_sb_section_align_change',  function(  modal, data, $content, key ){
        $content.css( { 'text-align':data } );
    } );
    */




} );