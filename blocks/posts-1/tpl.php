<?php
global $section_values, $current_section, $WP_SB_Template;


$section_id = uniqid('s-');



?>
<div class="section <?php echo esc_attr( $section_id ); ?>"<?php wp_sb_editing_section( ); ?>>
    <?php // echo __FILE__; ?>
    <div class="container">
        <?php
        $title = wp_sb_get_field_value( 'title' );
        if ( isset( $title['_css'] ) ) {
            wp_sb_template()->add_css( '.'.$section_id.' .post-heading', $title['_css'] );
        }
        ?>
        <h1<?php wp_sb_editing_field( 'title'); ?> class="post-heading"><?php echo $title['label']; ?></h1>
        <?php
        $btn =  wp_sb_get_field_value( 'button' );
        ?>
        <p><a<?php wp_sb_editing_field( 'button' ); ?> href="#" class="btn <?php echo esc_attr( $btn['button_style'] ); ?> btn-lg"><?php echo $btn['label']; ?></a></p>
    </div>
</div>

