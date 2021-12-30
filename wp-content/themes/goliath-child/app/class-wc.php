<?php 

namespace App;

class WC {

    public static $metaboxes;

    public static function init() {

        self::$metaboxes = (array) include __DIR__ . '/config/metaboxes.php';

        self::load_single_product_scripts();
        self::load_custom_add_to_cart();
        self::load_custom_metaboxes();
        self::display_amz_redirect();
        self::add_floating_cart();

    }  

    private static function add_floating_cart() {

        add_filter( 'wp_nav_menu_items', function( $nav_menu, $args ){

            ob_start();
            require_once get_stylesheet_directory() . '/templates/woocommerce/cart_section.php';
            $cart_section = ob_get_clean();

            $nav_menu .= $cart_section;

            return $nav_menu;

        }, 2, 10 );

        add_action( 'wp_footer', function(){

            require_once get_stylesheet_directory() . '/templates/woocommerce/floating_cart.php';

        } );

    }

    public static function display_amz_redirect() {

        //Add the redirect link & price to the single product
        add_action('woocommerce_before_single_product', function(){

            global $post;

            $amz_redirect_info = get_post_meta( $post->ID, 'amz_redirect_data' );
            $amz_redirect_info = $amz_redirect_info[0];

            if ( isset( $amz_redirect_info ) && !empty( $amz_redirect_info ) && $amz_redirect_info['amz_redirect_is_active'] == '1' ) {

                echo '<input type="hidden" id="wn_product_not_purchasable">';

                add_filter( 'woocommerce_is_purchasable', '__return_false');
                add_filter( 'woocommerce_product_price_class', function( $classes ) {
    
                    $classes .= ' wn_display_none';
                    return $classes;
        
                });

                add_action( 'woocommerce_after_add_to_cart_form', function() use ( $amz_redirect_info ) {

                    ?>
                    <a class="wn_amz_redirect_link" href="<?php echo $amz_redirect_info['amz_redirect_url']; ?>" target="_blank" >
                        <div class="wn_add_to_cart_amz_redirect">
                            <span class="wn_amz_r_price">$<?php echo $amz_redirect_info['amz_redirect_price']; ?></span>
                            <div class="wn_amz_r_content">
                                <span>Buy now</span>
                                <i class="wn_amz_r_icon"></i>
                            </div>
                        </div>
                    </a>
                    <?php

                });
            }
            else {

                if( !current_user_can('administrator') ) { 
                    
                    // add_filter( 'woocommerce_is_purchasable', '__return_false');
                    // echo '<input type="hidden" id="wn_product_not_purchasable">'; 
                    
                }
            }
        });

        //Add the redirect to thumbnail  
        add_filter( 'woocommerce_get_price_html', function( $price, $product ){

            global $post;

            $amz_redirect_info = get_post_meta( $post->ID, 'amz_redirect_data' );

            if ( ! isset( $amz_redirect_info[0] ) ) {
                return $price;
            }

            $amz_redirect_info = $amz_redirect_info[0];

            if ( isset( $amz_redirect_info ) && !empty( $amz_redirect_info ) && $amz_redirect_info['amz_redirect_is_active'] == '1' ) {

                $currency_symbol = get_woocommerce_currency_symbol();
                $price           = $currency_symbol . $amz_redirect_info['amz_redirect_price'];
                
            }
            else {
                
                if( !current_user_can('administrator') ) { 
                    $price = '<span style="color: #8b0808;" >SOLD OUT</span>';
                }
            }

            return $price;
            
        }, 2000000, 2);

        //Displaying Amazon Redirect Information as a column in the Products table
        add_filter('manage_product_posts_columns', function( $columns ) {

            //Making some space to insert our custom column
            unset( $columns['product_tag'] );
            $columns['wn_amz_redirect'] = '<i class="wn_amz_icon-black">';

            return $columns;

        }, 20, 1);

        //Adding value to the rows of our custom comlumn
        add_action( 'manage_posts_custom_column', function( $column_id, $post_id ) {
            
            switch( $column_id ) { 

                case 'wn_amz_redirect':

                    $data                = get_post_meta($post_id, 'amz_redirect_data', true);
                    $redirect_active     = '<i class="wn_amz_redirect-on">';
                    $redirect_not_active = '<i class="wn_amz_redirect-off">';

                    if( $data !== '' ) {

                        if ( isset( $data['amz_redirect_is_active'] ) &&  $data['amz_redirect_is_active'] == '1' ) {
                            echo $redirect_active;
                        }
                        else {
                            echo $redirect_not_active;
                        } 
                    }
                    else {
                        echo $redirect_not_active;
                    }

                break;

            }
        } , 20, 2 );
    }

    public static function load_custom_metaboxes() {
        
        add_action( 'add_meta_boxes', array( self::class, 'member_add_meta_box') );
        add_action( 'save_post', array( self::class, 'wn_save_post_actions') );

    }

    public static function member_add_meta_box() {

        //this will add the metabox for the member post type
        $screens = array( 'product' );

        foreach ( $screens as $screen ) {

            foreach( self::$metaboxes as $metabox => $data ) {

                $type = $data['type'];
                self::add_custom_meta_box($type, $metabox, $data);
                
            }
        }
    }

    function add_custom_meta_box($type, $metabox, $data) {

        switch ($type) {

            case 'WYSIWYG_editor': self::wp_editor_metabox($metabox, $data);
                break;

            case 'amazon_redirect': self::amazon_redirect_metabox_callback($metabox, $data);
                break;
            
            default:
                break;
        }

    }

    function wp_editor_metabox($metabox, $data) {

        $title = $data['title'];

        add_meta_box(

            $metabox,
            __( $title, 'member_textdomain' ),
            function( $post, $args ) {

                $metabox = $args['args']['metabox_name'];

                // Add a nonce field so we can check for it later.
                wp_nonce_field( $metabox . '_metabox_save_data', $metabox . '_metabox_nonce' );
                
                $value = get_post_meta( $post->ID, $metabox, true );
            
                wp_editor( stripslashes( $value ), $metabox . $post->ID, $settings = array('textarea_name' => $metabox . '_input') );
            
            },
            $screen,
            'advanced',
            'default',
            array( 'metabox_name' => $metabox )

        );

    }

    function amazon_redirect_metabox_callback( $metabox, $data ) {

        $title = $data['title'];

        add_meta_box(

            $metabox,
            __( $title, 'member_textdomain' ),
            function( $post, $args ) {

                $metabox = $args['args']['metabox_name'];

                // Add a nonce field so we can check for it later.
                wp_nonce_field( $metabox . '_metabox_save_data', $metabox . '_metabox_nonce' );
                
                $data = get_post_meta( $post->ID, 'amz_redirect_data', true );

                if( $data === '' ) {
                    $data = [];
                }

                isset( $data['amz_redirect_is_active'] ) ? $data['amz_redirect_is_active'] = $data['amz_redirect_is_active'] : $data['amz_redirect_is_active'] = '0';
                isset( $data['amz_redirect_price'] )     ? $data['amz_redirect_price']     = $data['amz_redirect_price']     : $data['amz_redirect_price']     = '';
                isset( $data['amz_redirect_url'] )       ? $data['amz_redirect_url']       = $data['amz_redirect_url']       : $data['amz_redirect_url']       = '';

                $data['amz_redirect_is_active'] ? $checked = 'checked' : $checked = '';

                echo '<label style="display: block;" for="amz_active">Amazon Redirect Active</label>';
                echo '<label class="wn_switch"><input name="amz_redirect_is_active" id="amz_active" value="1" type="checkbox" ' . $checked . ' ><span class="wn_slider round" ></span></label>';
            
                echo '<label style="display: block;  margin-top: 10px;" for="amz_price">Product Price on Amazon</label>';
                echo '<input name="amz_redirect_price" id="amz_price" style="width: 140px;" value="' . $data['amz_redirect_price'] . '" type="number" min="0" step="0.01" >';

                echo '<label style="display: block; margin-top: 10px;" for="amz_url">Product Url on Amazon</label>';
                echo '<input name="amz_redirect_url" id="amz_url" type="url" value="' . $data['amz_redirect_url'] . '">';

            },
            $screen,
            'advanced',
            'default',
            array( 'metabox_name' => $metabox )

        );

    }

    public static function wn_save_post_actions( $post_id ) {

        foreach( self::$metaboxes as $metabox => $data ) {

            (function() use ($metabox, $data, $post_id) {

                if ( ! isset( $_POST[$metabox . '_metabox_nonce'] ) ) {
                    return;
                }
                
                if ( ! wp_verify_nonce( $_POST[ $metabox . '_metabox_nonce'], $metabox . '_metabox_save_data' ) ) {
                    return;
                }

                if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
                    return;
                }

                // Check the user's permissions.
                if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
            
                    if ( !current_user_can( 'edit_page', $post_id ) ) {
                        return;
                    }
            
                } else {
        
                    if ( !current_user_can( 'edit_post', $post_id ) ) {
                        return;
                    }

                }

                $my_data;

                if( $data['type'] == 'amazon_redirect' ) {

                    if ( ! isset( $_POST['amz_redirect_url'] ) ) {
                        return;
                    }

                    $my_data = [];

                    isset( $_POST['amz_redirect_is_active'] )   ? $my_data['amz_redirect_is_active'] = '1'                       : $my_data['amz_redirect_is_active'] = '0';
                    isset( $_POST['amz_redirect_price'] )       ? $my_data['amz_redirect_price']  = $_POST['amz_redirect_price'] : $my_data['amz_redirect_price']  = '';
                    isset( $_POST['amz_redirect_url'] )         ? $my_data['amz_redirect_url']    = $_POST['amz_redirect_url']   : $my_data['amz_redirect_url']    = '';

                    update_post_meta( $post_id, 'amz_redirect_data', $my_data );

                }

                if( $data['type'] == 'WYSIWYG_editor' ) { 

                    if ( ! isset( $_POST[$metabox . '_input'] ) ) {
                        return;
                    }
            
                    $my_data = (( $_POST[ $metabox . '_input' ] ));
                    update_post_meta( $post_id, $metabox, $my_data );

                }
            })();
        }
    }

    public static function load_custom_add_to_cart() {

        //Returning Simple price instead of a range
        add_filter( 'woocommerce_variable_price_html', function( $price, $product ){

            $currency_symbol        = get_woocommerce_currency_symbol();
            $product_simple_price   = $product->price;

            return $currency_symbol . $product_simple_price;

        }, 10, 2);

        add_action('woocommerce_after_add_to_cart_form', function(){

            require_once get_stylesheet_directory() . '/templates/woocommerce/custom_add_to_cart_form.php';

        });
    }

    public static function load_single_product_scripts() {

        add_action( 'wp_enqueue_scripts', function() {

            if ( is_single() && 'product' == get_post_type() ) {
    
                wp_enqueue_style( 'single-product-styles', get_stylesheet_directory_uri() . '/theme/assets/css/single-product.css',
                    array(), 
                    time(),
                ); 
        
                //Single Product Zoom Effect Plugin
                wp_enqueue_style( 'wm-zoom-styles', get_stylesheet_directory_uri() . '/addons/wm-zoom/jquery.wm-zoom-1.0.css',
                    array(), 
                    time(),
                ); 
        
                wp_enqueue_style( 'single-product-styles-768', get_stylesheet_directory_uri() . '/theme/assets/css/responsive/single-product-768.css',
                    array(), 
                    time(),
                    '(max-width: 768px)'
                ); 
                wp_enqueue_style( 'single-product-styles-450', get_stylesheet_directory_uri() . '/theme/assets/css/responsive/single-product-450.css',
                    array(), 
                    time(),
                    '(max-width: 450px)'
                );
                
                //Single Product Zoom Effect Plugin
                wp_enqueue_script( 'wm-zoom-script', get_stylesheet_directory_uri() . '/addons/wm-zoom/jquery.wm-zoom-1.0.js',
                    array('jquery'), 
                    time(), false
                ); 
        
                wp_enqueue_script( 'single-product-script', get_stylesheet_directory_uri() . '/theme/assets/js/single-product.js',
                    array('jquery', 'wm-zoom-script', 'wc-add-to-cart-variation', 'wc-add-to-cart', 'wcsatt-single-product', 'wc-single-product'), 
                    time(), true
                ); 
            }
        } );
    }
}
