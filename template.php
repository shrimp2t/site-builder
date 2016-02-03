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

        $data_blocks = get_option( 'site_builder' );
        var_dump( $data_blocks );
        global $wp_sb_elements;

        if ( is_array( $data_blocks ) && ! empty( $data_blocks ) ) {
            foreach ( $data_blocks as $block ) {
                if ( isset( $block['tag'] ) ) {
                    if ( isset ( $wp_sb_elements[ $block['tag'] ] ) ) {
                        if ( file_exists( $wp_sb_elements[ $block['tag'] ]['tpl'] ) ) {
                            $GLOBALS['section_values'] =  $block['tag']['fields'];
                            $GLOBALS['section_settings'] =  $block['tag']['settings'];
                            include $wp_sb_elements[ $block['tag'] ]['tpl'];
                        }

                    }
                }

            }
        }

        /*
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

        ?>

        <div class="section" data-settings="<?php echo esc_attr( json_encode( $settings ) ); ?>">

            <div class="container">
                <h1 data-content="title">Hello, world!</h1>
                <p data-content="title">This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
                <p><a data-default="<?php echo esc_attr( json_encode( array( 'button_style' =>'btn-primary', 'size'=>'btn-lg' ) ) ); ?>" data-content="button" href="#" class="btn btn-primary btn-lg">Learn more »</a></p>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-lg-6 content-box">
                        <h4>Subheading</h4>
                        <p>Donec id elit non mi porta gravida at eget metus. Maecenas faucibus mollis interdum.</p>

                        <h4>Subheading</h4>
                        <p>Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Cras mattis consectetur purus sit amet fermentum.</p>

                        <h4>Subheading</h4>
                        <p>Maecenas sed diam eget risus varius blandit sit amet non magna.</p>
                    </div>

                    <div class="col-lg-6 content-box">
                        <h4>Subheading</h4>
                        <p>Donec id elit non mi porta gravida at eget metus. Maecenas faucibus mollis interdum.</p>

                        <h4>Subheading</h4>
                        <p>Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Cras mattis consectetur purus sit amet fermentum.</p>

                        <h4>Subheading</h4>
                        <p>Maecenas sed diam eget risus varius blandit sit amet non magna.</p>
                    </div>
                </div>
            </div>

        </div>
        */ ?>





    </div>
</div>

<?php wp_footer(); ?>
</body>
</html>