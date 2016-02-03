<?php

$settings = array(
    'tag' => 'header-1',
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
            'default' => 'Hello, world!'
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
);
global $section_values;

?>
<div class="section"<?php wp_sb_editing_section(  $settings  ); ?>>

    <div class="container">
        <h1<?php wp_sb_editing_field( 'title' ); ?>><?php echo esc_html( $section_values['title'] ); ?></h1>
        <p<?php wp_sb_editing_field( 'tagtitle' ); ?>>This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
        <p><a<?php wp_sb_editing_field( 'button', array( 'button_style' =>'btn-primary', 'size'=>'btn-lg' ) ); ?> href="#" class="btn btn-primary btn-lg">Learn more »</a></p>
    </div>

</div>
