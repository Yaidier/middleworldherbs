<?php
/**
 * 
 * 
 */

class WN_Products_Sync {

    public static function check_amazon_api_connection() {
        try {
            extract ( self::check_amz_api_credentials() );
        }
        catch (Exception $e) {
            return [ 'status' => 'error', 'message' => $e->getMessage() ];
        }

        $amz_api = new WN_Amz_Api( $lwa_client_id, $lwa_client_secret, $lwa_refresh_token, $aws_access_key_id, $aws_secret_access_key );
        
        return $amz_api->check_amazon_api_connection( $marketplace_id );
    }

    public static function check_amz_api_credentials() {
        try {
            $amz_credentials = self::get_amz_api_credentials();
        }
        catch (Exception $e) {
            return [ 'status' => 'error', 'message' => $e->getMessage() ];
        }

        return $amz_credentials;
    }

    public static function sync_images_for_single_product( $asin, $product_id ) {
        try {
            extract( self::get_amz_api_credentials() );
        }
        catch (Exception $e) {
            return [ 'status' => 'error', 'message' => $e->getMessage() ];
        }

        $amz_api    = new WN_Amz_Api( $lwa_client_id, $lwa_client_secret, $lwa_refresh_token, $aws_access_key_id, $aws_secret_access_key );
        $images     = $amz_api->get_amazon_images( $asin, $marketplace_id, ['images'], 'en_US' ) ;

        if ( isset( $images['status'] ) && $images['status'] == 'failure' )  {
            $message = $images['message'];

            if (strpos( $message, 'Invalid \u0027asin\u0027 provided.' ) !== false) {
                $message = 'Something went wrong, check the ASIN number...';
            }
            return [ 'status' => 'error', 'message' => $message ];
        }

        $inserted_attachments = self::insert_images_into_wp_media_library( $images ); 

        if( empty( $inserted_attachments ) ) {
            return;
        }

        $images_for_product_gallery = [];
        foreach( $inserted_attachments as $variant => &$inserted_attachment_data ) {
            if( isset( $inserted_attachment_data['status'] ) && $inserted_attachment_data['status'] == 'error' ){
                continue;
            }

            if( $variant == 'MAIN' ) {
                /**
                 * Do not update the product thumbnail for now as the image from amazon
                 * isn't a png and it looks bad...
                 */

                // if ( set_post_thumbnail( $product_id, $inserted_attachment_data['attach_id'] ) ) {
                //     $inserted_attachment_data['status']     = 'success';
                //     $inserted_attachment_data['message']    = 'Image updated successfully';
                // }
                // else {
                //     $inserted_attachment_data['status']     = 'error';
                //     $inserted_attachment_data['message']    = 'It wasn\'t possible to update the post thumbnail';
                // }

                $inserted_attachment_data['status']     = 'error';
                $inserted_attachment_data['message']    = 'Product thumbnail image not updated intentionally...';
            }
            else {
                array_push( $images_for_product_gallery, $inserted_attachment_data['attach_id'] );
                $inserted_attachment_data['status']     = 'success';
                $inserted_attachment_data['message']    = 'Image updated successfully';
            }
        }

        if( !empty( $images_for_product_gallery ) ) {
            $product = wc_get_product( $product_id );

            $product->set_gallery_image_ids( $images_for_product_gallery );
            $product->save();
        }

        return $inserted_attachments;
    }

    private static function add_filter_for_custom_products_image_sizes() {
        add_filter( 
            'intermediate_image_sizes_advanced', 
            array( self::class, 'intermediate_image_sizes_advanced' ), 
            10, 
            1 
        );
    }

    private static function remove_filter_for_custom_products_image_sizes() {
        remove_filter( 
            'intermediate_image_sizes_advanced', 
            array( self::class, 'intermediate_image_sizes_advanced' ),
            10
        );
    }

    public static function intermediate_image_sizes_advanced( $new_sizes ) {
        $new_product_sizes  = [];
        $product_sizes      = [ 
            'thumbnail', 
            'medium', 
            'large', 
            'woocommerce_single', 
            'product_header'
        ];

        foreach( $product_sizes as $product_size ) {
            if( !isset( $new_sizes[$product_size] ) ) {
                continue;
            }

            $new_product_sizes[$product_size] = $new_sizes[$product_size];
        }

        return $new_product_sizes;
    }

    private static function insert_images_into_wp_media_library( $images ) {
        $inserted_attachments = [];

        self::add_filter_for_custom_products_image_sizes();

        foreach( $images as $image ) {
            $image_url          = $image['link'];
            $filename           = basename( $image_url );
            $image_title        = substr( $filename, 0, strrpos( $filename, '.') );
            $uploads_dir        = trailingslashit( wp_upload_dir()['basedir'] ) . 'wn-amzs-uploads';
            $uploadfile         = trailingslashit( $uploads_dir ) . $filename;

            if ( !wp_mkdir_p( $uploads_dir ) ) {
                return [ 'status' => 'error', 'message' => 'It wasn\'t possible to create the directory: ' . $uploads_dir ];
            };

            if ( file_exists( $uploadfile ) ) {
                $inserted_attachments[ $image['variant'] ] = [
                    'status'    => 'error',
                    'message'   => 'Image file already exists',
                    'file_name' => $filename,
                ];

                continue;
            }

            $wp_filetype    = wp_check_filetype( basename( $filename ), null );
            $image_content  = file_get_contents( $image_url );
            $savefile       = fopen( $uploadfile, 'w');

            fwrite( $savefile, $image_content );
            fclose( $savefile );

            $attachment = [
                'post_mime_type'    => $wp_filetype['type'],
                'post_title'        => $image_title,
                'post_content'      => '',
                'post_status'       => 'inherit',
            ];

            $attach_id      = wp_insert_attachment( $attachment, $uploadfile );
            $imagenew       = get_post( $attach_id );
            $fullsizepath   = get_attached_file( $imagenew->ID );
            $attach_data    = wp_generate_attachment_metadata( $attach_id, $fullsizepath );
            
            wp_update_attachment_metadata( $attach_id, $attach_data );

            if ( $attach_data ) {
                $inserted_attachments[ $image['variant'] ] = [
                    'status'    => '',
                    'message'   => '',
                    'file_name' => $filename,
                    'attach_id' => $attach_id,
                ];
            }
        }

        self::remove_filter_for_custom_products_image_sizes();

        return $inserted_attachments;
    }

    public static function sync_prices( $products_to_sync_ids ) {
        try {
            extract( self::get_amz_api_credentials() );
            extract( self::get_products_with_assin_number( $products_to_sync_ids ) );
        }
        catch (Exception $e) {
            return [ 'status' => 'error', 'message' => $e->getMessage() ];
        }

        $amz_api        = new WN_Amz_Api( $lwa_client_id, $lwa_client_secret, $lwa_refresh_token, $aws_access_key_id, $aws_secret_access_key );
        $prices_result  = [];

        foreach( $asins_groups as $asins_group ) {
            $prices_result = array_merge( $prices_result, $amz_api->get_amazon_prices( $marketplace_id, 'Asin', $asins_group ) );
        }

        if ( isset( $prices_result['status'] ) && $prices_result['status'] == 'failure' ) {
            return [ 'status' => 'error', 'message' => $prices_result['message'] ];
        }

        $prices_succesfully_updated = self::assign_prices_to_wc_products( $asins_and_products, $prices_result );

        if ( !empty( $prices_succesfully_updated ) ) {
            return [ 'status' => 'success', 'message' => 'Products prices updated succesfully', 'data' => $prices_succesfully_updated ];
        }
        else {
            return [ 'status' => 'error', 'message' => 'Prices was not updated' ];
        }
    }

    static function get_products_with_assin_number( $products_to_sync_ids = null ) {
        if ( $products_to_sync_ids ) {
            $products = wc_get_products( [
                'status'    => 'publish',
                'limit'     => -1,
                'include'   => $products_to_sync_ids,
            ] );
        }
        else {
            $products = wc_get_products( [
                'status'    => 'publish',
                'limit'     => -1,
            ] );
        }

        $asins_and_products = [];
        foreach( $products as $product ) {
            $asin_number = get_post_meta( $product->get_id(), 'product_amazon_asin', true );

            if( $asin_number && $asin_number != '' ) {
                $asins_and_products[$asin_number] = $product;
            }
        }

        if( empty( $asins_and_products ) ) {
            return [ 'status' => 'error', 'message' => 'No Asins Numbers found on the products' ];
        }

        $asins = array_keys( $asins_and_products );

        /**
         * Amazon Selling Partner API only accpets a query for up to 20 items,
         * so if we have more than 20 products, we need to call the api more than once...
         */
        $asins_groups = array_chunk( $asins, 20 );
        
        return [ 'asins_and_products' => $asins_and_products, 'asins_groups' => $asins_groups];
    }

    public static function get_amz_api_credentials() {
        $settings_sections  = WN_Amzs_Admin::get_settings_sections();
        $amz_credentials    = [];

        foreach( $settings_sections['wn_amzs_options']['fields'] as $field_id => $field ){
            $value = get_option( $field_id . '_value' );

            if ( $value === false || $value == '' || $value === 'null' ) {
                throw new Exception ( $field['label'] . ' is missng' );
            }
            else {
                $amz_credentials[$field_id] = $value;
            }
        }

        return $amz_credentials;
    }

    static function assign_prices_to_wc_products( $asins_and_products, $prices_result ) {
        $prices_succesfully_updated = [];
        $currency_symbol            = get_woocommerce_currency_symbol();

        foreach( $prices_result as $assin => $price ) {
            $variable_product   = $asins_and_products[$assin];
            $parent_product_id  = $variable_product->get_id();
            $variations         = $variable_product->get_available_variations();

            foreach( $variations as $variation ) {
                $variation_name     = $variation['attributes']['attribute_choose-quantity'];
                $product            = wc_get_product( $variation['variation_id'] );
                $old_regular_price  = (float) $product->get_regular_price();

                if ( !isset( $prices_succesfully_updated[$parent_product_id] ) ) {
                    $prices_succesfully_updated[$parent_product_id] = [];
                }

                if ( isset( $price['status'] ) && $price['status'] == 'error' ) {
                    $prices_succesfully_updated[$parent_product_id][$variation_name] = [
                        'price'     => 'error',
                        'message'   => $price['message'],
                    ];

                    continue;
                }

                $new_regular_price  = self::calculate_variation_price_with_discounts( $price, $variation_name );

                /**
                 * Handle price - remove dates and set to lowest.
                 * See /woocommerce/includes/admin/class-wc-admin-post-types.php row from 
                 * 406 to 418
                 * 
                 *  */ 
                if ( ! is_null( $new_regular_price ) && $new_regular_price !== $old_regular_price ) {
                    $product->set_regular_price( $new_regular_price );
                    $product->set_date_on_sale_to( '' );
                    $product->set_date_on_sale_from( '' );

                    $response = $product->save();

                    if ( $response ) {
                        $prices_succesfully_updated[$parent_product_id][$variation_name] = [
                            'price'     => $currency_symbol . $new_regular_price,
                            'message'   => 'Price updated successfully',
                        ];
                    }
                }
                else {
                    $prices_succesfully_updated[$parent_product_id][$variation_name] = [
                        'price'     => $currency_symbol . $new_regular_price,
                        'message'   => 'Price was already the same',
                    ];
                }
            }
        }

        return  $prices_succesfully_updated;
    }

    static function calculate_variation_price_with_discounts( $new_regular_price, $variation_name ) {
        $discounts_and_packs    = (array) include WN_AMZ_SYNC_DIR . '/config/wn-packs-discounts.php';
        $discount               = (float) $discounts_and_packs[$variation_name];
        $quantity               = (int) str_replace( '-Pack', '', $variation_name );

        return round( ( ( $new_regular_price - ( $new_regular_price * $discount ) ) * $quantity ), 2 );
    }
}