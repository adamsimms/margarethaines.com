<?php

if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;

/**
 * A class to create a dropdown for all categories in your wordpress site
 */
 class Category_Dropdown_Custom_Control extends WP_Customize_Control
 {
    private $cats = false;

    public function __construct($manager, $id, $args = array(), $options = array())
    {
        $this->cats = get_categories($options);

        parent::__construct( $manager, $id, $args );
    }

    /**
     * Render the content of the category dropdown
     *
     * @return HTML
     */
    public function render_content()
    {
        if ( empty($this->cats) )
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
                foreach ( $this->cats as $cat )
                    echo '<option value="' . $cat->term_id . '"' . selected($this->value(), $cat->term_id, false) . '>' . $cat->name . '</option>';
                ?>
            </select>
        </label>
        <?php

    }

 }
?>