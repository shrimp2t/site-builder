<?php
global $section_values, $current_section, $WP_SB_Template;

$section_id = uniqid('s-');

?>
<div class="sb-section parallax-window <?php echo esc_attr( $section_id ); ?>"<?php wp_sb_editing_section( ); ?> data-parallax="scroll" data-image-src="<?php echo WP_SITE_BUILDER_URL ?>assets/frontend/images/<?php echo rand(1,2) ?>.jpg">
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
        $classes = array(
            $btn['button_style'],  $btn['size']
        );
        ?>
        <p><a<?php wp_sb_editing_field( 'button' ); ?> href="#" class="btn <?php echo esc_attr( join( ' ', $classes ) ); ?>"><?php echo $btn['label']; ?></a></p>
    </div>
</div>

