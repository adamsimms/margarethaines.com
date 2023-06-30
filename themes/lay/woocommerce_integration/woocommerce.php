<?php
// todo: check if comments are enabled and disable them
// todo: check all pages like: shop page, single product page and taxonomy pages, checkout, cart, account
// here it says the pages checkout, cart, account use my theme's page.php template ( https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/ )
// todo: make it possible to have an add to cart button that is tied to a certain product, but be able to put that into a gridder
// todo: look at gutenberg block editor woocommerce elements and see if there is anything i'd like to use too for the gridder
// todo: buy side cart pro plugin and then style all the pro things, or code my own sidecart    
// todo: test sidecart plugin on mobile
// todo: test different browsers
// todo: make it possible to also have black background for shop and all shop pages
// todo: can people create a profile and register and login and all these things, yes they can but i will still need to style this
// todo: check if you can sell audios or files
// todo: make it possible to insert a product thumbnail into the carousel and make it possible to link any carousel image to a product

// todo: footer in cart should be at bottom
// todo: footer for product page
// 

/* 
todo: check all these pages:
https://docs.woocommerce.com/document/woocommerce-theme-developer-handbook/
*/

// https://www.wpexplorer.com/woocommerce-compatible-theme/
class Lay_WooCommerce{

    public static $product_tags;
    public static $product_categories;
    // public static $cart_icon = '<svg viewBox="0 0 27 29" fill="none" class="lay-cart-icon"><path fill="currentColor" fill-rule="evenodd" d="M8.333 6.667a5 5 0 1110 0zm-1.666 0a6.667 6.667 0 1113.333 0h6.667v21.666H0V6.667zm0 1.666h-5v18.334H25V8.333h-5z" clip-rule="evenodd"></path></svg>';
    public static $cart_icon = '';

    public function __construct(){
        add_filter( 'wp_editor_settings', array($this, 'lay_woocommerce_editor_settings'), 10, 2 );
        add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
        add_action( 'wp_enqueue_scripts', array($this, 'lay_woocommerce_enqueue') );
        add_action( 'after_setup_theme', array($this, 'lay_add_woocommerce_support') );

        add_action( 'woocommerce_after_main_content', array($this, 'lay_after_single_product') );
        add_action( 'get_footer', array($this, 'lay_shop_footer'), 10, 2 );

        add_filter( 'loop_shop_per_page', array($this, 'lay_posts_per_page') );
        add_filter( 'loop_shop_columns', array($this, 'lay_woo_shop_columns') );
        add_filter( 'body_class', array($this, 'lay_woo_shop_columns_body_class') );
        add_filter( 'woocommerce_pagination_args', array($this, 'lay_woo_pagination_args') );
        add_filter( 'woocommerce_sale_flash', array($this, 'lay_woo_sale_flash') );
        add_filter( 'woocommerce_output_related_products_args', array($this, 'lay_woo_related_posts_per_page') );
        add_filter( 'woocommerce_up_sells_columns', array($this, 'lay_woo_single_loops_columns') );
        add_filter( 'woocommerce_output_related_products_args', array($this, 'lay_woo_related_columns'), 10 );
        add_filter( 'body_class', array($this, 'lay_woo_single_loops_columns_body_class') );
        add_action( 'init', array($this, 'disable_reviews') );

        // https://stackoverflow.com/questions/30811930/how-to-remove-woocommerce-tab
        remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
        // add_action( 'woocommerce_single_product_summary',  array($this, 'woocommerce_template_product_description'), 40 );
        add_action( 'woocommerce_single_product_summary',  'woocommerce_output_product_data_tabs', 40 );

        // price for thumbnails
        remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
        
        remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
        add_action('woocommerce_after_single_product', 'woocommerce_output_related_products', 10);

        remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
        add_action('woocommerce_after_single_product', 'woocommerce_upsell_display', 5);

        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);
        
        // https://stackoverflow.com/questions/27259838/change-or-translate-specific-texts-in-woocommerce
        add_filter( 'gettext',  array($this, 'my_text_strings'), 20, 3 );

        add_action('woocommerce_before_quantity_input_field', array($this, 'my_button_minus_qty'), 10);
        add_action('woocommerce_after_quantity_input_field', array($this, 'my_button_plus_qty'), 10);

        // put notifications html to top
        remove_action( 'wp_footer', 'woocommerce_demo_store' );
        add_action( 'laytheme_after_bodytag', 'woocommerce_demo_store' );

        // get rid of "description" headline
        add_filter( 'woocommerce_product_description_heading', '__return_false' );
        // add_action( 'woocommerce_after_shop_loop_item', array($this, 'after_thumbnail_title'), 10 );
        remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
         
        // add_action('wp_ajax_get_product_tags_for_productsmodal_json', array($this, 'get_product_tags_for_productsmodal_json'));
        // add_action('woocommerce_before_add_to_cart_quantity', array($this, 'my_button_minus_qty'), 10);
        // Lay_WooCommerce::$product_tags = Lay_WooCommerce::get_product_tags();
        add_action('after_setup_theme', array($this, 'get_product_tags_and_categories'), 10);
        add_action('wp_ajax_get_wc_products_thumbnail_grid_markup', array($this, 'get_wc_products_thumbnail_grid_markup'));

        // images
        add_filter('woocommerce_product_get_image', array($this, 'change_get_product_image'), 10, 5);

        // remove cross sells from cart page
        remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );

        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price' );
        add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 25 );

        add_filter( 'woocommerce_product_upsells_products_heading', array($this, 'lay_upsell_text'), 10, 1 );
        add_filter( 'woocommerce_product_related_products_heading', array($this, 'lay_related_text'), 10, 1 );
        
        add_action( 'woocommerce_single_variation', array( $this, 'lay_variations_container'), 15 );

        add_action( 'woocommerce_product_additional_information_heading', array( $this, 'lay_additional_info_headline' ), 10 );
        
        // add_filter('woocommerce_default_address_fields', array( $this, 'override_default_checkout_fields'), 20, 1);
        add_filter('woocommerce_checkout_fields', array( $this, 'override_default_checkout_fields'), 20 );

        add_action( 'wp_enqueue_scripts', array( $this, 'woo_dequeue_select2'), 100 );


        // checkout todo: housenumber and streetname do not have "*" in placeholder
        // make phone number not required
        // and apartment suite not required

        // https://www.cloudways.com/blog/move-woocommerce-coupon-field/
        remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form' );
        add_action( 'woocommerce_after_checkout_form', 'woocommerce_checkout_coupon_form' );

        add_filter( 'woocommerce_product_single_add_to_cart_text', array( $this, 'change_add_to_cart_text' ), 10, 2 );
        add_filter( 'woocommerce_product_add_to_cart_text', array( $this, 'change_add_to_cart_text' ), 10, 2 );

        add_action( 'admin_init', array($this, 'disable_content_editor'), 10);

        add_filter( 'wc_add_to_cart_message_html', array($this, 'cart_message'), 10, 3 );

        add_action( 'wp_loaded', array($this, 'set_mobile_cart_icon_qty'), 10 );
        // https://iconicwp.com/blog/update-custom-cart-count-html-ajax-add-cart-woocommerce/
        // https://rudrastyh.com/woocommerce/get-number-of-items-in-cart.html
        add_filter( 'woocommerce_add_to_cart_fragments', array($this, 'lay_cart_count_fragments'), 10, 1 );
    }


    public static function lay_cart_count_fragments( $fragments ) {
        $count = WC()->cart->get_cart_contents_count();
        $fragments['.lay-cart-icon-wrap'] = '<a href="'.wc_get_cart_url().'" class="lay-cart-icon-wrap">' . $count . '</a>';
        $fragments['.laycart-button-count'] = '<span class="laycart-button-count">'.$count.'</span>';
        // error_log(print_r($fragments, true));
        return $fragments;
    }

    public static function set_mobile_cart_icon_qty(){
        // if( function_exists('xoo_wsc_cart') ) {
        //     $cart_count = xoo_wsc_cart()->get_cart_count();
        //     Lay_WooCommerce::$cart_icon = '<a href="'.wc_get_cart_url().'" class="lay-cart-icon-wrap">'.$cart_count.'</a>';
        // } else 
        if ( is_object( WC()->cart ) ) {
            // todo: does this make sense?
            $cart_count = WC()->cart->get_cart_contents_count();
            Lay_WooCommerce::$cart_icon = '<a href="'.wc_get_cart_url().'" class="lay-cart-icon-wrap">'.$cart_count.'</a>';
        }
    }

    public static function cart_message($message, $products, $show_qty){
        // put span around text so we can align the text centered compared to the "view cart" button
        // this message shows up when an item was added without sidecart plugin
        $pos = strpos($message, '</a>');
        $pos = $pos + 4;
        $message = substr_replace($message, '<span>', $pos, 0);
        $message = substr_replace($message, '</span>', strlen($message), 0);
        return $message;
    }

    // disables content editor for all pages but woocommerce pages
    public static function disable_content_editor($can) {

        remove_post_type_support('post', 'editor');

        if (isset($_GET['post'])) {
            $post_ID = $_GET['post'];
        } else if (isset($_POST['post_ID'])) {
            $post_ID = $_POST['post_ID'];
        }
        if (!isset($post_ID) || empty($post_ID)) {
            remove_post_type_support('page', 'editor');
            return;
        }
    
        // need to test this! page ids could potentially not be saved already.
        $enabled_ids = array();
        $enabled_ids []= get_option( 'woocommerce_shop_page_id' ); 
        $enabled_ids []= get_option( 'woocommerce_cart_page_id' ); 
        $enabled_ids []= get_option( 'woocommerce_checkout_page_id' );
        $enabled_ids []= get_option( 'woocommerce_pay_page_id' ); 
        $enabled_ids []= get_option( 'woocommerce_thanks_page_id' ); 
        $enabled_ids []= get_option( 'woocommerce_myaccount_page_id' ); 
        $enabled_ids []= get_option( 'woocommerce_edit_address_page_id' ); 
        $enabled_ids []= get_option( 'woocommerce_view_order_page_id' ); 
        $enabled_ids []= get_option( 'woocommerce_terms_page_id' ); 
        $enabled_ids []= wc_privacy_policy_page_id();

        // if editor content is not empty, show the editor. this way people can remove the sample page sample text!
        if( !in_array( $post_ID, $enabled_ids ) && get_the_content(null, false, $post_ID) == '' ) {
            remove_post_type_support('page', 'editor');
        }
    }


    public static function change_add_to_cart_text( $text ){
        if( $text == 'Add to cart' ) {
            $text = 'Add to Cart';
        }
        if( $text == 'Select options' ) {
            $text = 'Select Options';
        }
        return $text;
    }

    // tinymce buttons!
    // todo: do i need laylink layunlink here instead of link unlink?
    public static function lay_woocommerce_editor_settings( $settings, $id ){
        // dont need to change settings here cause they're already used for initalizing the gridder texteditor
        if( $id != 'gridder_text_editor' && $id != 'lay_project_description' ) {
            // but for all other texteditors like the main one that we need to be enabled for woocommerce pages, use my settings
            $settings = array(
                'media_buttons' => false,
                'quicktags' => false,
                'tinymce' => array(
                    'toolbar1' => 'undo, redo, link, unlink, fontselect, fontsizeselect, lineheightselect, letterspacingselect, table, styleselect, laynightmode',
                    'toolbar2' => 'forecolor, bold, italic, underline, alignleft, aligncenter, alignright, removeformat, charmap, nonbreaking, softhyphen, visualblocks, code',
                    'toolbar3' => '',
                    'toolbar4' => '',
                )
            );
        }
        return $settings;
    }
    

    public static function woo_dequeue_select2() {
        wp_dequeue_style( 'select2' );
        wp_deregister_style( 'select2' );
        wp_dequeue_script( 'selectWoo');
        wp_deregister_script('selectWoo');        
    }

    public static function override_default_checkout_fields( $sections ) {
        // error_log(print_r($fields, true));
        // error_log(print_r($fields, true));
        foreach ($sections as &$sec) {
            foreach ($sec as &$field) {
                if(array_key_exists('label', $field)){
                    // error_log(print_r($field, true));
                    $field['placeholder'] = $field['label'];
                    if(array_key_exists('required', $field) && $field['required'] == 1){
                        $field['placeholder'] .= '*';
                    }
                    // $field['placeholder'] = '';
                }            
            }
        }
        // $fields['first_name']['placeholder'] = 'Fornavn';
        // $fields['last_name']['placeholder'] = 'Efternavn';
        // $fields['address_1']['placeholder'] = 'Adresse';
        // $fields['state']['placeholder'] = 'Stat';
        // $fields['postcode']['placeholder'] = 'Postnummer';
        // $fields['city']['placeholder'] = 'By';
        return $sections;
    }

    public static function lay_additional_info_headline(){
        return '';
    }

    public static function lay_variations_container(){
        echo '<div class="lay-variable-products-select-container"></div>';
    }

    public static function lay_related_text($text){
        return get_theme_mod('lay_woocommerce_singleproduct_related_text', 'Related Products');
    }

    public static function lay_upsell_text($text){
        return get_theme_mod('lay_woocommerce_singleproduct_youmayalsolike_text', 'You may also like');
    }

    // todo: show _512 image when in admin panel. when on frontend show image using getLazyImgByImageId
    public static function change_get_product_image( $image, $_this, $size, $attr, $placeholder  ) {
        $attid = $_this->get_image_id();
        if ( $attid ) {
            $image = '';
            $thumbnail_type = get_theme_mod('lay_woocommerce_image_type', 'woocommerce');
            // error_log( print_r($thumbnail_type, true) );
            switch($thumbnail_type) {
                case 'woocommerce':
                    // not using laytheme standard image but woocommerce's thumbnail size
                    // this way people can have cropped images and set their image ratios in customize -> woocommerce -> product images
                    $imgobj = wp_get_attachment_image_src( $attid, 'woocommerce_thumbnail' );
                    $w = $imgobj[1];
                    $h = $imgobj[2];
                    $image = '<div class="ph lay-woocommerce-image" style="padding-bottom:'.($h / $w * 100).'%;">'.LayElFunctions::getLazyImgByImageId($attid, 'woocommerce_thumbnail').'</div>';
                break;
                case 'laytheme':
                    $imgobj = wp_get_attachment_image_src( $attid, 'full' );
                    $w = $imgobj[1];
                    $h = $imgobj[2];
                    $image = '<div class="ph lay-woocommerce-image" style="padding-bottom:'.($h / $w * 100).'%;">'.LayElFunctions::getLazyImgByImageId($attid).'</div>';
                break;
            }
        }
        return $image;
    }

    // public static function get_product_tags_for_productsmodal_json(){
    //     $terms = get_terms( 'product_tag' );
    //     error_log( print_r($terms, true) );
    //     $term_array = array();
    //     if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
    //         foreach ( $terms as $term ) {
    //             $term_array[] = array(
    //                 'text' => $term->slug,
    //                 'id' => $term->id
    //             );
    //         }
    //     }
	// 	wp_send_json($term_array);
    //     die();
    // }

    // products thumbnails grid
    public static function build_lay_products_markup($config){
        // error_log( print_r($config, true) );

        // create the woocommerce shortcode
        $shortcode = '[products ';
        foreach( $config as $key => $value ) {
            // error_log( print_r($key, true) );
            // error_log( print_r($value, true) );
            switch( $key ) {
                case 'desktop':
                case 'tablet':
                case 'phone':
                    if( is_array($value) ) {
                        // desktop, tablet, phone configuration
                        $json = json_encode($value);
                        $json = str_replace('"','\'',$json);
                        $shortcode .= $key.'="'.$json.'" ';
                    }
                break;
                case 'category':
                case 'tag':
                    if( is_array($value) ) {
                        $cat_array = array();
                        foreach( $value as $key2 => $value2 ) {
                            $cat_array []= $value2['value'];
                        }
                        $imploded_array = implode(',', $cat_array);
                        $shortcode .= $key.'="'.$imploded_array.'" ';
                    }
                break;
                default:
                    $shortcode .= $key.'="'.$value.'" ';
                break;
            }
        }
        $shortcode = substr($shortcode, 0, -1);
        $shortcode .= ']';
        // error_log( print_r($shortcode, true) );
        // create shortcode markup
        $markup = do_shortcode( $shortcode );

        $markup = str_replace('<ul class="products', '<ul class="lay-products', $markup);
        $markup = str_replace('<li class="product', '<li class="lay-product', $markup);

        // now add lay theme's extra configuration
        // find class="" attribute
        $pos = strpos($markup, 'class="');
        $ul_end_pos = strpos($markup, '</ul>');
        if( $pos !== FALSE ) {
            $first_part = substr($markup, 0, $pos);
            $second_part = substr($markup, $pos, 7);
            $third_part = substr($markup, $pos + 7, $ul_end_pos - $pos - 7);
            $fourth_part = substr($markup, $ul_end_pos);
            $new_config = array(
                'desktop' => $config['desktop'],
                'tablet' => $config['tablet'],
                'phone' => $config['phone'],
                'layoutType' => $config['layoutType']
            );

            $new_classes = 'lay-products-thumbnails-grid '.$config['layoutType'].' ';

            $masonry_sizer = '';
            if( $config['layoutType'] == 'masonry' ) {
                $masonry_sizer = '<div class="lay-productsgrid-gutter-sizer"></div><div class="lay-productsgrid-col-sizer"></div>';
            }

            $new_markup = $first_part.' data-config="'.htmlspecialchars(json_encode($new_config)).'" '.$second_part.$new_classes.$third_part.$masonry_sizer.$fourth_part;
            // remove "columns-4", because it is woocommerce markup we dont need
            // not sure if this could also be a different value than 4 and not get removed but i think it's not that important
            $new_markup = str_replace('columns-4', '', $new_markup);
            $markup = $new_markup;
        }
        return $markup;
    }

    public static function get_wc_products_thumbnail_grid_markup(){
        $config = $_POST['products_config'];
        $markup = Lay_WooCommerce::build_lay_products_markup($config);
        // error_log( print_r($shortcode, true) );
        // $array = json_decode( $config, true );
        // error_log( print_r($config, true) );
        // error_log( gettype($config) );
        // $shortcode = '[products limit="-1" paginate="false" orderby="date" skus="false" order="ASC" on_sale="false" best_selling="false" top_rated="false"]';

        // $shortcode = '[products category="" tag="" skus="" limit="-1" paginate="false" orderby="date" order="ASC" on_sale="false" best_selling="false" top_rated="false"]';

        echo $markup;
        die();
    }

    public static function get_product_tags_and_categories(){
        // get_terms does not work!
        // https://wordpress.stackexchange.com/questions/256897/get-terms-wont-display-product-cat-or-any-other-custom-taxonomies-when-specifie
        $output = array();
        $terms = get_terms( array(
            'orderby'      => 'name',
            'pad_counts'   => false,
            'hierarchical' => 1,
            'hide_empty'   => true,
        ) );
        
        //error_log( print_r($terms, true) );
        $product_tags_array = array();
        $product_categories_array = array();
        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
            foreach ( $terms as $term ) {
                if( $term->taxonomy == 'product_tag' ) {
                    $product_tags_array[] = array(
                        'label' => $term->name,
                        'value' => $term->slug
                    );
                }
                else if( $term->taxonomy == 'product_cat' ) {
                    // error_log( print_r($term, true) );
                    $product_categories_array[] = array(
                        'label' => $term->name,
                        'value' => $term->slug
                    );
                }
            }
        }
        Lay_WooCommerce::$product_categories = $product_categories_array;
        Lay_WooCommerce::$product_tags = $product_tags_array;
    }

    // public static function after_thumbnail_title(){
    //     echo '<h2>test</h2>';
    // }

    public static function my_button_minus_qty(){
        echo '<div class="lay-woocommerce-minus-qty-button js-lay-woocommerce-minus-qty"></div>';
    }
    public static function my_button_plus_qty(){
        echo '<div class="lay-woocommerce-plus-qty-button js-lay-woocommerce-plus-qty"></div>';
    }

    // CHANGE RELATED PRODUCTS TEXT
    public static function my_text_strings( $translated_text, $text, $domain ) {
        // switch ( $translated_text ) {
        //     case 'Related products' :
        //         $translated_text = __( 'You might also like', 'woocommerce' );
        //         break;
        // }
        return $translated_text;
    }

    // remove all woocommerce styles
	public static function lay_woocommerce_enqueue() {
        // https://www.cloudways.com/blog/move-woocommerce-coupon-field/
        wp_enqueue_script('jquery-ui-dialog');
		wp_enqueue_style( 'lay-woocommerce-style', Setup::$uri."/woocommerce_integration/assets/css/woocommerce.style.css", array(), Setup::$ver );
    }
    // use hooks: https://docs.woocommerce.com/document/woocommerce-theme-developer-handbook/#section-3
    public static function lay_add_woocommerce_support() {
        add_theme_support( 'woocommerce' );
        /*
        In WooCommerce 3.0 they introduced a new product gallery, zoom and lightbox.
        These must all be enabled via “add_theme_support” if you want to make use of them in your theme.
        */
        // add_theme_support( 'wc-product-gallery-slider' );
        // add_theme_support( 'wc-product-gallery-zoom' );
        // add_theme_support( 'wc-product-gallery-lightbox' );
        /*
        A lot of themes already have functions to display archive titles so this code
        removes the extra title from WooCommerce which is better then hiding it via CSS.
        */
        add_filter( 'woocommerce_show_page_title', '__return_false' );
    }

    // woocommerce has templates and uses hooks that i use to put my lay theme markup into
    // https://github.com/woocommerce/woocommerce/tree/4.3.0/templates

    // todo: put my markup into all needed templates?

    public static function lay_shop_footer($name, $args){
        // in order to get footer
        // if( $name == 'shop' ) {
        //     echo Lay_Layout::getLayoutInit();
        // }
    }

    // single product page
    public static function lay_after_single_product(){
        ?>
        	<div id="intro-region"></div>
	        <div id="search-region"></div>
        <?php
        // in order to get footer
        echo Lay_Layout::getLayoutInit();
    }

    // Alter WooCommerce shop posts per page
    public static function lay_posts_per_page( $cols ) {
        return 12;
    }
        // /*
    //     I don’t understand why WooCommerce works in this way but you can’t just alter the ‘loop_shop_columns’ filter, 
    //     you must also add the unique classes to the body tag in order for the columns to work. While the Woo Shortcodes 
    //     have a div wrapper with the correct classes the shop pages do not, that’s why we need two functions.
    // */
    // Alter shop columns
    public static function lay_woo_shop_columns( $columns ) {
        return 4;
    }
    // Add correct body class for shop columns
    public static function lay_woo_shop_columns_body_class( $classes ) {
        if ( is_shop() || is_product_category() || is_product_tag() ) {
            $classes[] = 'columns-4';
        }
        return $classes;
    }
    /*
        Change the Next & Previous Pagination Arrows
        This snippet will allow you to tweak the pagination arrows 
        on the shop to match those in your theme.
    */
    public static function lay_woo_pagination_args( $args ) {
        $args['prev_text'] = '<i class="fa fa-angle-left"></i>';
        $args['next_text'] = '<i class="fa fa-angle-right"></i>';
        return $args;
    }
    /*
        Change the OnSale Badge Text
        Especially useful on sites using a different language or to remove the exclamation mark which I am not a huge fan of.
    */
    public static function lay_woo_sale_flash() {
        return '<span class="onsale">' . esc_html__( 'Sale', 'woocommerce' ) . '</span>';
    }
    // /*
    //     Change Product Gallery thumbnails columns
    //     You may want to change the number of columns for the single product gallery thumbnails
    //     depending on your layout and this function will do just that.
    // */
    // function lay_woo_product_thumbnails_columns() {
    //     return 4;
    // }
    // add_action( 'woocommerce_product_thumbnails_columns', 'lay_woo_product_thumbnails_columns' );

    // /*
    //     Alter the number of displayed related products
    //     Used to alter the number of products displayed for
    //     related products on the single product page.
    // */
    // // Set related products to display 4 products
    public static function lay_woo_related_posts_per_page( $args ) {
        $args['posts_per_page'] = 4;
        return $args;
    }
    // /*
    //     Change the number of columns per row for related & up-sells sections on products
    //     Just like the shop if you want to properly alter the number of columns for related and
    //     up-sell products on the single product pages you must filter the columns and also alter the body classes accordingly.
    // */
    // Filter up-sells columns
    public static function lay_woo_single_loops_columns( $columns ) {
        return 4;
    }
    // Filter related args
    public static function lay_woo_related_columns( $args ) {
        $args['columns'] = 4;
        return $args;
    }
    // Filter body classes to add column class
    public static function lay_woo_single_loops_columns_body_class( $classes ) {
        if ( is_singular( 'product' ) ) {
            $classes[] = 'columns-4';
        }
        return $classes;
    }
    public static function disable_reviews() {
        remove_post_type_support( 'product', 'comments' );
    }
    public static function woocommerce_template_product_description() {
        return '<div class="lay-wc-descriptions">'.wc_get_template( 'single-product/tabs/description.php' ).'</div>';
    }
}
if ( class_exists( 'WooCommerce' ) ){
    new Lay_WooCommerce();
}