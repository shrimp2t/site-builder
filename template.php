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
                    <p><a  data-content="button" href="#" class="btn btn-primary btn-lg">Learn more »</a></p>
                </div>
            </div>
        </div>



        <div class="section">
            <div class="container">
                <!-- Example row of columns -->
                <div class="row">
                    <div class="col-md-4">
                        <h2>Heading</h2>
                        <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                        <p><a role="button" href="#" class="btn btn-default">View details »</a></p>
                    </div>
                    <div class="col-md-4">
                        <h2>Heading</h2>
                        <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                        <p><a role="button" href="#" class="btn btn-default">View details »</a></p>
                    </div>
                    <div class="col-md-4">
                        <h2>Heading</h2>
                        <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
                        <p><a role="button" href="#" class="btn btn-default">View details »</a></p>
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