<?php 

namespace App;

class AjaxHandler {

    public static $metaboxes;

    public static function init() {
        $ajax_hanlders = [ 
            'wn_mwh_float_add_to_cart',
            'wn_mwh_float_remove_from_cart',
            'wn_mwh_float_upgrade_to_subscription',
            'wn_mwh_float_update_purchase_option',
            'wn_mwh_float_update_pack_option',
        ];

        foreach( $ajax_hanlders as $ajax_hanlder ) {
            add_action( 'wp_ajax_nopriv_' . $ajax_hanlder , [ self::class, $ajax_hanlder ]);
            add_action( 'wp_ajax_' . $ajax_hanlder, [ self::class, $ajax_hanlder ]);
        }
    }  

    private static function add_to_cart_validation( $product_id, $quantity, $from ) {
        $passed_validation      = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
        $product_status         = get_post_status($product_id);

        if ( !$passed_validation ) {
            self::send_json_response( $from, 'admin_error', 'The validation has failed' );
        }

        if ( 'publish' != $product_status ) {
            self::send_json_response( $from, 'admin_error', 'Product is not published' );
        }
    }

    private static function check_subscription( $subscription ) {
        if( $subscription ) {
            add_filter( 'woocommerce_add_cart_item_data', function( $cart_item_data, $product_id, $variation_id ) use ( $subscription ){

                $wcsatt_data    = [ 'active_subscription_scheme' => $subscription ];
                $cart_item_data = [
                    'wcsatt_data' => $wcsatt_data,
                ];

                return $cart_item_data;
            }, 10, 3 );
        }
    }

    public static function check_cart( $cart_item_id = false, $product_id, $variation_id, $subscription, $from ) {
        $woo_cart = WC()->cart->get_cart();

        foreach( $woo_cart as $cart_item ) {

            if ( ( $cart_item_id == $cart_item['key'] ) ) {
                continue;
            }

            if( ( $cart_item['product_id'] == $product_id ) && ( gettype( $cart_item[ 'wcsatt_data' ][ 'active_subscription_scheme' ] ) == gettype( $subscription ) ) ) {
                //Check if susbcriptions are the choosen one for this product or check the current variation
                if ( ( gettype( $subscription ) == 'string' ) || ( $cart_item['variation_id'] == $variation_id ) ) {
                    self::send_json_response( $from, 'failure', 'Product already on cart', self::render_floating_cart_inner_content() );
                }
            }
        }
    }

    public function render_floating_cart_inner_content() {
        ob_start();
        require_once get_stylesheet_directory() . '/templates/woocommerce/floating_cart_inner.php';
        $buffer_output = ob_get_clean();
        
        return $buffer_output;
    }

    public function check_quantity( $product, $quantity, $from  ) {
        $prodcut_stock_quantity = $product->get_stock_quantity();

        if ( $quantity > $prodcut_stock_quantity ) {
            self::send_json_response( $from, 'failure', 'Not enough amount of product on Stock' );
        }
    }

    private static function send_json_response( $from, $status = 'success', $messasge = '', $data = null ) {
        wp_send_json( [
            'from'      => $from,
            'status'    => $status,
            'message'   => $messasge,
            'content'   => $data,
        ]);
    }

	public static function wn_mwh_float_add_to_cart(){
        if( !isset( $_GET['product_id'] ) ){
            self::send_json_response( 'add_to_cart', 'admin_error', 'product id is missing' );
        }

        $product_id             = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $_GET['product_id'] ) );
        $quantity               = empty( $_GET['quantity'] ) ? 1 : wc_stock_amount( $_GET['quantity'] );
        $subscription           = ( $_GET['subscription'] != 'false' ) ? $_GET['subscription'] : false;
        $variation_id           = absint( $_GET['variation_id'] );
        $product                = wc_get_product( $product_id );
        $prodcut_stock_quantity = $product->get_stock_quantity();

        self::add_to_cart_validation( $product_id, $quantity, 'add_to_cart' );
        self::check_subscription( $subscription );
        self::check_cart( false, $product_id, $variation_id, $subscription, 'add_to_cart' );
        self::check_quantity( $product, $quantity, 'add_to_cart' );

        WC()->cart->add_to_cart( $product_id, $quantity, $variation_id );
        do_action('woocommerce_ajax_added_to_cart', $product_id);

        self::send_json_response( 'add_to_cart', 'success', 'Product added', self::render_floating_cart_inner_content() );
	}

    public static function wn_mwh_float_remove_from_cart() {
        if( !isset( $_GET['cart_item_id'] ) ){
            self::send_json_response( 'remove_item_from_cart', 'admin_error', 'cart item id is missing' );
        }

        $cart_item_id   = $_GET['cart_item_id'];
        $is_success     = WC()->cart->remove_cart_item( $cart_item_id );

        if( $is_success ) {
            self::send_json_response( 'remove_item_from_cart', 'success', 'Product removed', self::render_floating_cart_inner_content() );
        }
        else {
            self::send_json_response( 'remove_item_from_cart', 'failure', 'It was not possible to remove the item from the cart'  );
        }
    }

    public static function wn_mwh_float_update_subscription( $cart_item_id, $susbcription_scheme_key = 'first_option' ) {
        $cart_contents          = WC()->cart->cart_contents;
        $susbcriptions_schemes  = \WCS_ATT_Product_Schemes::get_subscription_schemes( $cart_contents[ $cart_item_id ][ 'data' ] );

        if ( !$susbcriptions_schemes ) {
            self::send_json_response( 'upgrade_to_subscription', 'admin_error', 'current product do not have subscritions schemes' );
        }

        if ( $susbcription_scheme_key == 'first_option' ) {
            $susbcriptions_schemes      = array_values( $susbcriptions_schemes );
            $susbcription_scheme_key    = $susbcriptions_schemes[0]->get_key();
        }

        $product_id     = WC()->cart->cart_contents[ $cart_item_id ]['product_id'];
        $variation_id   = WC()->cart->cart_contents[ $cart_item_id ]['variation_id'];

        self::check_cart( $cart_item_id, $product_id, $variation_id, $susbcription_scheme_key, 'upgrade_to_subscription' );

        WC()->cart->cart_contents[ $cart_item_id ][ 'wcsatt_data' ][ 'active_subscription_scheme' ] = $susbcription_scheme_key;
        \WCS_ATT_Cart::apply_subscription_schemes( WC()->cart );
        WC()->cart->calculate_totals();

        return true;
    }

    public static function wn_mwh_float_upgrade_to_subscription() {
        if( !isset( $_GET['cart_item_id'] ) ){
            self::send_json_response( 'upgrade_to_subscription', 'admin_error', 'cart item id is missing' );
        }

        $cart_item_id               = $_GET['cart_item_id'];
        $cart_contents              = WC()->cart->get_cart();
        $cart_item_prodcut_id       = $cart_contents[$cart_item_id]['product_id'];
        $cart_item_variation_id     = $cart_contents[$cart_item_id]['variation_id'];
        $product                    = wc_get_product( $cart_item_prodcut_id );
        $variations                 = $product->get_available_variations();
        $one_pack_var_id            = $variations[0]['variation_id']; 

        if ( $one_pack_var_id == $cart_item_variation_id ) {
            if ( self::wn_mwh_float_update_subscription( $cart_item_id ) ) {
                self::send_json_response( 'upgrade_to_subscription', 'success', 'Product updated to subscription', self::render_floating_cart_inner_content() );
            }
        }
        else {
            $cart_item_id = self::wn_mwh_float_update_pack_option_action( $cart_item_id, $one_pack_var_id );

            if ( self::wn_mwh_float_update_subscription( $cart_item_id ) ) {
                self::send_json_response( 'upgrade_to_subscription', 'success', 'Product updated to subscription', self::render_floating_cart_inner_content() );
            }
        }
    }

    public static function wn_mwh_float_update_purchase_option() {
        if( !isset( $_GET['cart_item_id'] ) ){
            self::send_json_response( 'upgrade_to_subscription', 'admin_error', 'cart item id is missing' );
        }

        if( !isset( $_GET['purchase_option'] ) ){
            self::send_json_response( 'upgrade_to_subscription', 'admin_error', 'purchase option value not sent from js' );
        }

        $cart_item_id       = $_GET['cart_item_id'];
        $purchase_option    = ( $_GET['purchase_option'] == 'one_time' ) ? false : $_GET['purchase_option'];

        if ( self::wn_mwh_float_update_subscription( $cart_item_id, $purchase_option ) ) {
            $messasge = $purchase_option ? 'Product updated to subscription' : 'Product updated to one time purchase';
            self::send_json_response( 'upgrade_to_subscription', 'success', $messasge, self::render_floating_cart_inner_content() );
        }
    }

    public static function wn_mwh_float_update_pack_option() {
        if( !isset( $_GET['cart_item_id'] ) ){
            self::send_json_response( 'update_pack_option', 'admin_error', 'cart item id value not sent from js' );
        }

        if( !isset( $_GET['option_variation_id'] ) ){
            self::send_json_response( 'update_pack_option', 'admin_error', 'option variation id value not sent from js' );
        }

        $cart_item_id = $_GET['cart_item_id'];
        $variation_id = $_GET['option_variation_id'];
        
        if( self::wn_mwh_float_update_pack_option_action( $cart_item_id, $variation_id ) ) {
            self::send_json_response( 'update_pack_option', 'success', 'Product pack updated', self::render_floating_cart_inner_content() );
        }
        else {
            self::send_json_response( 'update_pack_option', 'failure', 'It wasn\' possible to update the product', self::render_floating_cart_inner_content() );
        }
        
    }

    static function wn_mwh_float_update_pack_option_action( $cart_item_id, $variation_id ) {
        $variation      = wc_get_product( $variation_id );
        $product        = wc_get_product( $variation->get_parent_id() );
        $product_id     = $product->get_id();
        $susbcription   = WC()->cart->cart_contents[ $cart_item_id ][ 'wcsatt_data' ][ 'active_subscription_scheme' ];

        self::check_cart( $cart_item_id, $product_id, $variation_id, $susbcription, 'update_pack_option' );
        
        WC()->cart->remove_cart_item( $cart_item_id );

        self::add_to_cart_validation( $product_id, 1, 'add_to_cart' );
        self::check_quantity( $product, 1, 'add_to_cart' );

        $cart_item_id = WC()->cart->add_to_cart( $product_id, 1, $variation_id );
        do_action('woocommerce_ajax_added_to_cart', $product_id);

        return $cart_item_id;
    }
}