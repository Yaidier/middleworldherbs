<?php 

namespace App;

class AjaxHandler {

    public static $metaboxes;

    public static function init() {

        $ajax_hanlders = [ 'wn_mwh_float_add_to_cart' ];

        foreach( $ajax_hanlders as $ajax_hanlder ) {

            add_action( 'wp_ajax_nopriv_' . $ajax_hanlder , [ self::class, $ajax_hanlder ]);
            add_action( 'wp_ajax_' . $ajax_hanlder, [ self::class, $ajax_hanlder ]);

        }
    }  

    private static function wn_mwh_add_to_cart_validation( $product_id, $quantity ) {

        $passed_validation      = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
        $product_status         = get_post_status($product_id);

        if ( !$passed_validation ) {
            self::send_json_response( 'admin_error', 'The validation has failed' );
        }

        if ( 'publish' != $product_status ) {
            self::send_json_response( 'admin_error', 'Product is not published' );
        }
    }

    private static function check_subscription( $subscription ) {

        if( $subscription != 'false' ) {

            add_filter( 'woocommerce_add_cart_item_data', function( $cart_item_data, $product_id, $variation_id ) use ( $subscription ){

                $wcsatt_data    = [ 'active_subscription_scheme' => $subscription ];

                $cart_item_data = [
                    'wcsatt_data' => $wcsatt_data,
                ];

                return $cart_item_data;
    
            }, 10, 3 );
        }
    }

    public static function check_cart( $product_id ) {

        $woo_cart = WC()->cart->get_cart();

        foreach( $woo_cart as $cart_item ) {

            if( $cart_item['product_id'] == $product_id ) {
                self::send_json_response( 'failure', 'Product already on cart' );
            }

        }
    }

    public function check_quantity( $product, $quantity  ) {

        $prodcut_stock_quantity = $product->get_stock_quantity();

        if ( $quantity > $prodcut_stock_quantity ) {
            self::send_json_response( 'failure', 'Not enough amount of product on Stock' );
        }
    }

    private static function send_json_response( $status = 'success', $messasge = '', $data = null ) {

        wp_send_json( [
            'status'    => $status,
            'message'   => $messasge,
            'data'      => $data,
        ]);
    }

	public static function wn_mwh_float_add_to_cart(){

        if( !isset( $_GET['product_id'] ) ){
            self::send_json_response( 'admin_error', 'product id is missing' );
        }

        $product_id             = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $_GET['product_id'] ) );
        $quantity               = empty( $_GET['quantity'] )     ? 1                     : wc_stock_amount( $_GET['quantity'] );
        $subscription           = isset( $_GET['subscription'] ) ? $_GET['subscription'] : 'false';
        $variation_id           = absint( $_GET['variation_id'] );
        $product                = wc_get_product( $product_id );
        $prodcut_stock_quantity = $product->get_stock_quantity();

        self::wn_mwh_add_to_cart_validation( $product_id, $quantity );
        self::check_subscription( $subscription );
        self::check_cart( $product_id );
        self::check_quantity( $product, $quantity );

        WC()->cart->add_to_cart( $product_id, $quantity, $variation_id );
        do_action('woocommerce_ajax_added_to_cart', $product_id);

        self::send_json_response( 'success', 'Product Added Succesfully' );

	}
}