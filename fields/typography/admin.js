/**
 * Created by truongsa on 1/16/16.
 */

Array.prototype.toObject = function(keys){
    var obj = {};
    var tmp = this; // we want the original array intact.
    if(keys.length == this.length){
        var c = this.length-1;
        while( c>=0 ){
            obj[ keys[ c ] ] = tmp[c];
            c--;
        }
    }
    return obj;
};

(function( $ ) {

    window.wp_sb_fields = window.wp_sb_fields || {};

    wp_sb_fields[ 'typography' ]  = {
        init: function( field ){

            field.element.on( 'click', function( e ) {
                e.preventDefault();
                if ( field.element.hasClass('m-opened') ) {
                    return false;
                }
                field.element.addClass('m-opened');
                data_default = field.element.attr('data-default') || '{}';
                data_default = JSON.parse( data_default );
                data_default['label'] = field.element.html();
                field.data = $.extend( {}, data_default,{} );
                field.control.element_modal( field.element, field.field, field.key, field.data );

            });

        },
        open:  function( field  ){
            // data, element, modal, section
            //console.log( field );
        },
        change:  function( field  ){
            this.save( field );

        },
        save: function( field ){
            // data, element, modal , section
            field.element.html( field.data.label );

            var css_id =  field.element.attr( 'data-css-id' ) || '';

            if ( css_id != '' ) {
                window.wp_sb_live_css.add( css_id, '.css-el[data-css-id="'+css_id+'"]', _.clone( field.data.css ) );
                window.wp_sb_live_css.add( css_id+'_hover', '.css-el[data-css-id="'+css_id+'"]:hover', _.clone( field.data.css_hover ) );
                window.wp_sb_live_css.render();
                field.data['_css'] = window.wp_sb_live_css.get( css_id );
                field.data['_css_hover'] = window.wp_sb_live_css.get( css_id+'_hover' );
            }

            field.control.updateData( 'fields', field.key, field.data );
        },
        close: function( field ){
            //  data, element, modal , section
            field.element.removeClass('m-opened');
        },

    };

})(jQuery);