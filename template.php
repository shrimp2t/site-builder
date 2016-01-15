<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width">
    <title><?php _e(  'Template Builder', 'site-builder' ); ?></title>
    <?php
   // wp_print_scripts();
   // wp_print_styles();
    wp_head();
    ?>
</head>
<body>

<div class="wp-sb-builder-content-wrap">
    <div class="wp-sb-builder-area">


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
                    'default' => 'Hello, world!'
                ),
                'button'    => array(
                    'type' => 'button',
                    'default' => 'Hello, world!'
                ),
            ),
            'settings' =>  array(
                'bg' => array(
                    'type' => 'background',
                    'default' => array (
                        'img_url' => '',
                        'img_id' => '',
                        'bg_color' => '',
                        'bg_type' => '',
                    )
                ),
                'content_box' => array(),
                'typography' =>  array(
                    'type' => 'background',
                    'default' => array(
                        'font' => '',
                        'size' => '',
                        'color' => '',
                    ),
                ),
                'align' =>  array(
                    'type' => 'align',
                    'default' => 'left',
                ),

            )

        );

        ?>

        <div class="section" data-settings="<?php echo esc_attr( json_encode( $settings ) ); ?>">
            <div class="jumbotron">
                <div class="container">
                    <h1  data-content="title">Hello, world!</h1>
                    <p  data-content="title">This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
                    <p><a data-default="<?php echo esc_attr( json_encode( array( 'button_style' =>'btn-primary', 'size'=>'btn-lg' ) ) ); ?>" data-content="button" href="#" class="btn btn-primary btn-lg">Learn more »</a></p>
                </div>
            </div>
        </div>






    </div>
</div>

<?php wp_footer(); ?>
</body>
</html>