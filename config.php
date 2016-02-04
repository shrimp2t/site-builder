<?php

$categories = array(
    'header'  =>__( 'Header', 'site-builder' ),
    'content' =>__( 'Content', 'site-builder' ),
    'videos'  =>__( 'Video', 'site-builder' ),
    'team'    =>__( 'Team', 'site-builder' ),
);

wp_sb_register_section( 'header', array(
    'title' => __( 'Header', 'site-builder' ),
    'priority' => 5,
) );

wp_sb_register_element( 'header', 'header-1', array(
    'title' => __( 'Header 1', 'site-builder' ),
    'priority' => 5,
    'thumb' => WP_SITE_BUILDER_URL.'blocks/header-1/images/thumb.jpg',
    'tpl' => WP_SITE_BUILDER_PATH.'blocks/header-1/tpl.php',
    'js' => WP_SITE_BUILDER_URL.'blocks/header-1/js/edit.js',

    'fields' => array(
        'title' => array(
            'type' => 'inline', // inline edit
            'default' => 'Hello, world!'
        ),
        'tagline'   => array(
            'type' => 'inline',
            'default' => 'This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.'
        ),
        'button'    => array(
            'type' => 'button',
            'default' => array(
                'button_style' =>'btn-primary',
                'size'=>'btn-lg',
                'label' => 'Learn more »'
            ),

        ),
    ),
    'settings' =>  array(
        'bg' => array(
            'img_url' => '',
            'img_id' => '',
            'bg_color' => '',
            'bg_type' => '',
        ),
        'content_box' => array( // add class content-box to element want to see live view
            'bg_color' => '',
            'opacity' => '',
            'text_color' => '',
        ),
        'typography' =>  array(
            'font' => '',
            'size' => '',
            'color' => '',
        ),
        'align' => 'left',
    )

) );


/*
wp_sb_register_element( 'header', 'header-2', array(
    'title' => __( 'Header 2', 'site-builder' ),
    'priority' => 5,
) );

wp_sb_register_element( 'header', 'header-3', array(
    'title' => __( 'Header 3', 'site-builder' ),
    'priority' => 5,
) );

wp_sb_register_element( 'header', 'header-4', array(
    'title' => __( 'Header 4', 'site-builder' ),
    'priority' => 5,
) );


wp_sb_register_section( 'content', array(
    'title' => __( 'Content', 'site-builder' ),
    'priority' => 5,
) );


wp_sb_register_section( 'videos', array(
    'title' => __( 'Videos', 'site-builder' ),
    'priority' => 5,
) );
*/

