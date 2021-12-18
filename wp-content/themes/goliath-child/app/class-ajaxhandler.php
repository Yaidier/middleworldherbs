<?php 

namespace App;

class AjaxHandler {

    public static $metaboxes;

    public static function init() {

        $ajax_hanlders = [ 'wn_mwh_float_add_to_cart' ];

        foreach( $ajax_hanlders as $ajax_hanlder ) {

            add_action( 'wp_ajax_nopriv_' . $ajax_hanlder , [ self::class, $ajax_hanlder ]);
            add_action( 'wp_ajax_' . $ajax_hanlder, [ self::class, $ajax_hanlder ]);

            add_action( 'wc_ajax_wn_float_add_to_cart', [ self::class, 'wn_float_add_to_cart' ] );

        }

    }  

    /* Add to cart is performed by woocommerce as 'add-to-cart' is passed */
	public function wn_float_add_to_cart(){

        

        $cart = WC()->cart->get_cart();

        wp_send_json( ['response' => $cart] );

        die();

	}

}