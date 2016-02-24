<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width">
    <title><?php _e(  'Template Builder', 'site-builder' ); ?></title>
    <?php
    wp_head();
    ?>
</head>
<body>

<div class="wp-sb-builder-content-wrap">
    <div class="wp-sb-builder-area">
        <?php
        WP_SB_Template()->print_template();
       ?>
    </div>
</div>

<?php wp_footer(); ?>
</body>
</html>