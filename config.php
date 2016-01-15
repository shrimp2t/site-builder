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
) );

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

