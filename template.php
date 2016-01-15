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
                'title'     => 'inline',
                'tagline'   => 'inline',
                'button'    => 'button',
            ),
            'default' => array(
                'title'     => __( 'Hello, world!', 'site-builder' ),
                'tagline'   => __( 'This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.', 'site-builder' ),
                'button'    => __( 'Learn more »', 'site-builder' ),
            ),

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


        <?php

        $settings = array(
            'tag' => 'header-1',
            'fields' => array(
                'title_1'     => 'inline',
                'p_1'   => 'inline',
                'button_1'    => 'button',

                'title_2'     => 'inline',
                'p_2'   => 'inline',
                'button_2'    => 'button',

                'title_3'     => 'inline',
                'p_3'   => 'inline',
                'button_3'    => 'button',
            ),
            'default' => array(
                'title_1'     => __( 'Hello, world!', 'site-builder' ),
                'p_1'  => __( 'This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.', 'site-builder' ),
                'button_1'    => __( 'Learn more »', 'site-builder' ),


                'title_2'     => __( 'Hello, world!', 'site-builder' ),
                'p_2'  => __( 'This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.', 'site-builder' ),
                'button_2'    => __( 'Learn more »', 'site-builder' ),


                'title_3'     => __( 'Hello, world!', 'site-builder' ),
                'p_3'  => __( 'This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.', 'site-builder' ),
                'button_3'    => __( 'Learn more »', 'site-builder' ),


            ),

        );

        ?>


        <div class="section" data-settings="<?php echo esc_attr( json_encode( $settings ) ); ?>">
            <div class="container">
                <!-- Example row of columns -->
                <div class="row">
                    <div class="col-md-4">
                        <h2 data-content="title_1">Heading</h2>
                        <p data-content="p_1">Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                        <p><a role="button" data-content="button_1" data-content="title" href="#" class="btn btn-default">View details »</a></p>
                    </div>
                    <div class="col-md-4">
                        <h2 data-content="title_2">Heading</h2>
                        <p data-content="p_2">Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                        <p><a role="button" data-content="button_2" href="#" class="btn btn-default">View details »</a></p>
                    </div>
                    <div class="col-md-4">
                        <h2 data-content="title_3">Heading</h2>
                        <p data-content="p_3">Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
                        <p><a role="button"  data-content="button_3" href="#" class="btn btn-default">View details »</a></p>
                    </div>
                </div>

                <hr>

                <footer>
                    <p>&copy; 2015 Company, Inc.</p>
                </footer>
            </div>
        </div>





    </div>
</div>

<?php wp_footer(); ?>
</body>
</html>