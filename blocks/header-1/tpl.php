<?php

$settings = array(
    'tag' => 'header-1',
    'content' => array(
        'title'     => 'inline',
        'tagline'   => 'inline',
        'button'    => 'button',
    ),

);

?>

<div class="section" data-settings="<?php echo esc_attr( json_encode( $settings ) ); ?>">
    <div class="jumbotron">
        <div class="container">
            <h1 data-edit="inline" data-content="title">Hello, world!</h1>
            <p data-edit="inline" data-content="title">This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
            <p><a data-edit="inline" data-content="button" role="button" href="#" class="btn btn-primary btn-lg">Learn more »</a></p>
        </div>
    </div>
</div>