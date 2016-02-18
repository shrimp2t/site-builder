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
    'type' => 'section', // section | sidebar | content
    'thumb' => WP_SITE_BUILDER_URL.'blocks/header-1/images/thumb.jpg',
    'tpl' => WP_SITE_BUILDER_PATH.'blocks/header-1/tpl.php',
    'js' => WP_SITE_BUILDER_URL.'blocks/header-1/js/edit.js',
    'function' => WP_SITE_BUILDER_PATH.'blocks/header-1/functions.php',

    'fields' => array(
        'title' => array(
            'type' => 'inline', // inline edit
            'default' => 'Hello, world!'
        ),
        'tagline'   => array(
            'type' => 'inline',
            'default' => 'This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.'
        ),
        'layout'   => array(
            'type' => 'layout',
            'default' => array(
                'layout-1' => array(
                    // data
                ),
                'layout-2' => array(
                    // data
                ),
                'layout-3' => array(
                    // data
                ),
            ),
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
        'design' => array(
            'img_url' => '',
            'img_id' => '',
            'bg_color' => '',
            'bg_type' => '',
        ),
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


wp_sb_register_element( 'content', 'layout-1', array(
    'title' => __( 'Layout 1', 'site-builder' ),
    'priority' => 5,
    'type' => 'section', // section | sidebar | content
    'thumb' => WP_SITE_BUILDER_URL.'blocks/layout-1/thumb.png',
    'tpl' => WP_SITE_BUILDER_PATH.'blocks/layout-1/tpl.php',
    'js' => WP_SITE_BUILDER_URL.'blocks/layout-1/js/edit.js',

    'fields' => array(
        'title' => array(
            'type' => 'inline', // inline edit
            'default' => 'Layout style 1'
        ),
        'tagline'   => array(
            'type' => 'inline',
            'default' => 'This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.'
        ),
        'contents'   => array(
            'type' => 'layout',
            'default' => array(

            ),
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
        'design' => array(
            'img_url' => '',
            'img_id' => '',
            'bg_color' => '',
            'bg_type' => '',
        ),
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



wp_sb_register_element( 'content', 'posts-1', array(
    'title' => __( 'Post style 1', 'site-builder' ),
    'priority' => 5,
    'type' => 'content', // section | sidebar | content
    'thumb' => WP_SITE_BUILDER_URL.'blocks/posts-1/thumb.png',
    'tpl' => WP_SITE_BUILDER_PATH.'blocks/posts-1/tpl.php',
    //'js' => WP_SITE_BUILDER_URL.'blocks/header-1/js/edit.js',
    'fields' => array(
        'title' => array(
            'type' => 'typography', // inline edit
            'default' => array(
                'style'=>'',
                'label' => 'This is heading typo'
            ),
        ),
        'button'    => array(
            'type' => 'button',
            'default' => array(
                'button_style' =>'btn-primary',
                'size'=>'btn-lg',
                'label' => 'Read more »'
            ),

        ),
    ),
    'settings' =>  array(
        'design' => array(
            'img_url' => '',
            'img_id' => '',
            'bg_color' => '',
            'bg_type' => '',
        ),
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




