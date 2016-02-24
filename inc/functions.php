<?php
/**
 * Priority
 *
 * @param $section_id
 * @param $element_id
 * @param $settings
 */
function wp_sb_register_element( $section_id, $element_id, $settings ){
    if ( ! is_array( $settings ) ) {
        $settings = array();
    }
    $settings = wp_parse_args( $settings, array(
        'tag'    => $element_id,
        'title'  => $element_id,
        'priority' => '',
        'function' => '',
        'thumb' => '',
        'tpl' => '',
        'js' => '',
        'fields' => array(),
        'settings' => array(),
    ) );
    global $wp_sb_sections, $wp_sb_elements;
    if ( ! isset( $wp_sb_sections[ $section_id ] ) ) {
        wp_sb_register_section( $section_id, array() );
    }
    $wp_sb_sections[ $section_id ][ 'elements' ][ $element_id ] =  $settings;
    $wp_sb_elements[ $element_id ] = $settings;

}

/**
 * @param $section_id
 * @param $settings
 */
function wp_sb_register_section( $section_id, $settings ){
    global $wp_sb_sections;
    if ( ! is_array( $settings ) ) {
        $settings = array();
    }
    $settings = wp_parse_args( $settings, array(
        'title' => $section_id,
        'priority' => '',
        'elements' => array(),
    ) );
    $wp_sb_sections[ $section_id ] = $settings;

}






function wp_sb_editing_attr( $key, $args = array(), $echo = true ){
    if( ! defined( 'WP_SB_EDITING' ) || WP_SB_EDITING != 1 ) {
        return ;
    }

    if ( is_array( $args ) || is_object( $args ) ){
        $_string_attr = json_encode( $args );
    } else {
        $_string_attr = $args;
    }

    if ( $echo ) {
        echo " data-{$key}=\"".esc_attr( $_string_attr )."\" ";
    } else {
        return " data-{$key}=\"".esc_attr( $_string_attr )."\" ";
    }
}

function wp_sb_editing_field( $field_id, $echo = true ){
    if( ! defined( 'WP_SB_EDITING' ) || WP_SB_EDITING != 1 ) {
        return ;
    }
    global $current_section;
    $data = array();
    if ( isset( $current_section['fields'] ) && is_array( $current_section['fields'] ) ){
        if ( isset( $current_section['fields'][ $field_id ] ) ) {
            $data =  $current_section['fields'][ $field_id ];
        }
    }

    $attr = '';
    if ( ! empty ( $data ) ) {
        $attr .=  wp_sb_editing_attr( 'section-id', $current_section['tag'], false );
        $attr .=  wp_sb_editing_attr( 'content', $field_id, false );
        foreach ( $data as $key => $val ) {
            $attr .= wp_sb_editing_attr( $key, $val, false );
        }
    }

    if ( $echo ) {
        echo $attr;
    } else {
        return $attr;
    }
}

function wp_sb_editing_section( $echo = true ){
    if( ! defined( 'WP_SB_EDITING' ) || WP_SB_EDITING != 1 ) {
        return ;
    }
    global $current_section, $section_values, $section_settings;
    $atts = '';
    $atts .=  wp_sb_editing_attr( 'settings', array(
        'tag' => $current_section[ 'tag' ],
        'fields' => $current_section[ 'fields' ],
        'settings' => $current_section[ 'settings' ],
    ) , false );
    $atts .=  wp_sb_editing_attr( 'values',
        array(
            'tag' => $current_section['tag'],
            'settings'=> $section_settings,
            'fields' => $section_values
        ),
        false );

    if ( $echo ){
        echo $atts;
    } else {
        return $atts;
    }
}


function wp_get_setting_field( $settings,  $field, $default = array() ){
    if ( ! is_array( $settings ) ) {
        return  $default;
    }

    if ( isset( $settings['fields'] ) ) {
        if ( isset( $settings['fields'][ $field ] ) ) {
            $v = $settings['fields'][ $field ];
            if ( is_string( $v ) && !empty( $v ) ){
                return $v;
            } else {
                return wp_parse_args( $settings['fields'][ $field ], $default );
            }
        }
    }

    return $default;
}


/**
 *
 *
 * @param array $default
 */
function wp_sb_setup_section_data( $default = array() ){
    if ( ! is_array( $default ) ) {
        return ;
    }
    $default = wp_parse_args( $default,
        array(
            'fields'=> array() ,
            'settings'=> array()
        )
    );

    global $section_values;
    global $section_settings;

    $v = array();
    foreach ( $default['fields'] as $k => $_v ) {
        $_v = wp_parse_args( $_v, array( 'default' => '' ) );
        $v[ $k ] = $_v['default'];
    }

    $s = array();
    foreach ( $default['settings'] as $k => $_v ) {
        $_v = wp_parse_args( $_v, array( 'default' => '' ) );
        $s[ $k ] = $_v['default'];
    }

    $GLOBALS['section_values'] =  wp_parse_args( $section_values, $v );
    $GLOBALS['section_settings'] =  wp_parse_args( $section_settings, $s );
}


function wp_sb_get_field_value( $field_id ){
    global $current_section, $section_values;
    $value = false;
    if ( isset ( $section_values[ $field_id ] ) ) {
        $value = $section_values[ $field_id ];
    }
    $default_data = false;
    if ( isset( $current_section['fields'] ) && is_array( $current_section['fields'] ) ){
        if ( isset( $current_section['fields'][ $field_id ] ) && isset( $current_section['fields'][ $field_id ]['default'] ) ) {
            $default_data =  $current_section['fields'][ $field_id ]['default'];
        }
    }
    if  ( $default_data && is_array( $default_data ) ){
        $value =  wp_parse_args( $value, $default_data );
    }
    return $value;
}