<?php
/**
 * 
 * 
 */

class WN_Amzs_Ajax_Handler {

    public static function init() {
        add_action('wp_ajax_wn_amzs_ajax_sync_images', array( self::class, 'wn_amzs_ajax_sync_images' ) );
    }

    static function wn_amzs_ajax_sync_images() {
        if( !isset( $_GET['action'] ) ) {
            self::send_json_response( 'wn_amzs_ajax_sync_images', 'error', 'action is missing' );
        }

        if( isset( $_GET['is_fresh_start'] ) && $_GET['is_fresh_start'] == 'true' ) {
            $products_to_sync_ids   = isset( $_GET['products_to_sync'] ) ? $_GET['products_to_sync'] : null;
            $products_to_sync_ids   = explode( ',', $products_to_sync_ids );
            $asins_and_products     = ( WN_Products_Sync::get_products_with_assin_number( $products_to_sync_ids ) )['asins_and_products'];
        }
        else {
            $asins_and_products = get_option( 'wn-amzs-imgs-sync-data' );
        }

        /**
         * Extract next product to sync the images
         */
        $prodcut_to_sync    = array_slice( $asins_and_products, 0, 1, true );
        $product_asin       = key( $prodcut_to_sync );
        $product            = wc_get_product( $prodcut_to_sync[ $product_asin ] );
        $prodcut_id         = $product->get_id();
        $prodcut_name       = $product->get_name();

        /**
         * Syncronyze images
         */
        $response = WN_Products_Sync::sync_images_for_single_product( $product_asin, $prodcut_id );

        /**
         * Remove product to sync from the list
         */
        unset( $asins_and_products[ $product_asin ] );
        update_option( 'wn-amzs-imgs-sync-data', $asins_and_products );

        /**
         * Check if it is the last product
         */
        $is_last = empty( $asins_and_products ) ? true : false;

        $prodcut_data = [
            'product_name'  => $prodcut_name,
            'product_id'    => $prodcut_id,
            'is_last'       => $is_last,
            'images_status' => $response
        ];

        if( ( gettype( $response ) == 'array' ) && $response['status'] == 'error' ){
            self::send_json_response( 'WN_Products_Sync', 'error', $response['message'], $prodcut_data );
        }
        else {
            self::send_json_response( 'wn_amzs_ajax_sync_images', 'success', 'Product syncronized successfully', $prodcut_data );
        }
    }

    private static function send_json_response( $from = '', $status = '', $message = '', $data = null ) {
        wp_send_json( [
            'from'          => $from,
            'status'        => $status,
            'message'       => $message,
            'data'          => $data,
        ]);
    }
}