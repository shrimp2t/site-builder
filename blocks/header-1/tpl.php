<?php
global $section_values, $current_section;

?>
<div class="section"<?php wp_sb_editing_section( ); ?>>
    <div class="container">
        <h1<?php wp_sb_editing_field( 'title' ); ?>><?php echo esc_html( $section_values['title'] ); ?></h1>
        <p<?php wp_sb_editing_field( 'tagline' ); ?>><?php echo esc_html( $section_values['tagline'] ); ?></p>
        <p><a<?php wp_sb_editing_field( 'button', array( 'button_style' =>'btn-primary', 'size'=>'btn-lg' ) ); ?> href="#" class="btn btn-primary btn-lg">Learn more »</a></p>
    </div>
</div>
