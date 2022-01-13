<?php
/**
 * 
 * 
 */

require_once WN_AMZ_SYNC_DIR . '/includes/vendor/autoload.php';

use SellingPartnerApi\Api\SellersApi;
use SellingPartnerApi\Configuration;
use SellingPartnerApi\Endpoint;

class WN_Amz_Api {

    public function __construct( $lwa_client_id, $lwa_client_secret, $lwa_refresh_token, $aws_access_key_id, $aws_secret_access_key, $end_point = Endpoint::NA ) {
        $this->config = new Configuration( [
            'lwaClientId'           => $lwa_client_id,
            'lwaClientSecret'       => $lwa_client_secret,
            'lwaRefreshToken'       => $lwa_refresh_token,
            'awsAccessKeyId'        => $aws_access_key_id,
            'awsSecretAccessKey'    => $aws_secret_access_key,
            'endpoint'              => $end_point // or another endpoint from lib/Endpoint.php
        ] );
    }

    public function check_amazon_api_connection( $marketplace_id ) {
        $api_instance = new SellingPartnerApi\Api\ProductPricingApi( $this->config );
    
        try {
            $result = $api_instance->getCompetitivePricing( $marketplace_id, 'Asin', array( 'XXXXXXX' ) );
        } 
        catch (Exception $e) {
            $message = $e->getMessage();

            if (strpos( $message, 'Invalid \u0027asin\u0027 provided.' ) == false) {
                return [ 'status' => 'failure', 'message' => $message ] ;
            }
        }

        return [ 'status' => 'success', 'message' => '' ] ;
    }

    public function get_amazon_prices( $marketplace_id, $item_type, $asins = null, $skus = null, $customer_type = null ) {
        $api_instance = new SellingPartnerApi\Api\ProductPricingApi( $this->config );
    
        try {
            $result         = $api_instance->getCompetitivePricing( $marketplace_id, $item_type, $asins, $skus, $customer_type );
            $prices         = $result->getPayload();
            $prices_result  = [];

            foreach ( $prices as $price ) {
                $asin_number    = $price->getAsin();
                $status         = $price->getStatus();

                if ( $status == 'ClientError' ) {
                    $prices_result[$asin_number] = [
                        'status'    => 'error',
                        'message'   => 'Something went wrong, check the ASIN number...',
                    ];
                    continue;
                }

                $amount  = $price->getProduct()->getCompetitivePricing()->getCompetitivePrices()[0]->getPrice()->getListingPrice()->getAmount();
                $prices_result[$asin_number] = $amount;
            }

            return  $prices_result;
        } 
        catch (Exception $e) {
            $message = $e->getMessage();
            return [ 'status' => 'failure', 'message' => $e->getMessage() ];
        }
    }
    
    public function get_amazon_images( $asin, $marketplace_id, $included_data, $locale ) {
        $api_instance = new SellingPartnerApi\Api\CatalogApi( $this->config );
    
        try {
            $result         = $api_instance->getCatalogItem( $asin, $marketplace_id, $included_data, $locale );
            $images_items   = $result->getImages()[0]->getImages();
            $images_result  = [];

            foreach ( $images_items as $image_item ) {
                $variant    = $image_item->getVariant();
                $link       = $image_item->getLink();
                $width      = $image_item->getWidth();
                $height     = $image_item->getHeight();

                if( array_key_exists( $variant, $images_result ) && 
                    $width <= $images_result[ $variant ]['width'] && 
                    $height <= $images_result[ $variant ]['height'] 
                    ) {
                    continue;
                }

                $images_result[ $variant ] = [
                    'variant'   => $variant,
                    'link'      => $link,
                    'width'     => $width,
                    'height'    => $height,
                ];
            }

            return  $images_result;
        } 
        catch (Exception $e) {
            return [ 'status' => 'failure', 'message' => $e->getMessage() ] ;
        }
    }
}