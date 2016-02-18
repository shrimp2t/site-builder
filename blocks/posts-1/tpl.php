<?php
global $section_values, $current_section;

?>
<div class="section"<?php wp_sb_editing_section( ); ?>>
    <?php // echo __FILE__; ?>
    <div class="container">
        <?php
        $title = wp_sb_get_field_value( 'title' );
        ?>
        <h1<?php wp_sb_editing_field( 'title'); ?>><?php echo $title['label']; ?></h1>
        <?php
        $btn =  wp_sb_get_field_value( 'button' );
        ?>
        <p><a<?php wp_sb_editing_field( 'button' ); ?> href="#" class="btn <?php echo esc_attr( $btn['button_style'] ); ?> btn-lg"><?php echo $btn['label']; ?></a></p>
    </div>
</div>

