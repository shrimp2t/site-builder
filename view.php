<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width">
    <title><?php _e(  'Template Viewer', 'site-builder' ); ?></title>
    <?php
    wp_head();
    ?>
</head>
<body class="template-viewer">
<?php

 WP_SB_Template()->print_template();

?>

<?php wp_footer(); ?>
</body>
</html>