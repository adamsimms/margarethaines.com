<?php
if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;

/**
 * Class to create a custom post control
 */
class Post_Dropdown_Custom_Control extends WP_Customize_Control
{
    private $posts = false;

    public function __construct($manager, $id, $args = array(), $options = array())
    {
        $postargs = wp_parse_args($options, array('numberposts' => '-1'));
        $this->posts = get_posts($postargs);

        parent::__construct( $manager, $id, $args );
    }

    /**
    * Render the content on the theme customizer page
    */
    public function render_content()
    {
        if ( empty( $this->posts ) )
            return;
        ?>
        <label>
            <?php if ( ! empty( $this->label ) ) : ?>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <?php endif;
            if ( ! empty( $this->description ) ) : ?>
                <span class="description customize-control-description"><?php echo $this->description; ?></span>
            <?php endif; ?>

            <select <?php $this->link(); ?>>
                <?php
                echo '<option value="">--SELECT--</option>';
                foreach ( $this->posts as $post )
                    echo '<option value="' . $post->ID . '"' . selected( $this->value(), $post->ID, false ) . '>' . $post->post_title . '</option>';
                ?>
            </select>
        </label>
        <?php

    }
}
?>