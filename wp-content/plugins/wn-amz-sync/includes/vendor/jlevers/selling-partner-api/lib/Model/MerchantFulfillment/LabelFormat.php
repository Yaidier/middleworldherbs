<?php
/**
 * LabelFormat
 *
 * PHP version 7.2
 *
 * @category Class
 * @package  SellingPartnerApi
 */

/**
 * Selling Partner API for Merchant Fulfillment
 *
 * The Selling Partner API for Merchant Fulfillment helps you build applications that let sellers purchase shipping for non-Prime and Prime orders using Amazon’s Buy Shipping Services.
 *
 * The version of the OpenAPI document: v0
 * 
 * Generated by: https://openapi-generator.tech
 * OpenAPI Generator version: 5.0.1
 */

/**
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech).
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace SellingPartnerApi\Model\MerchantFulfillment;
use \SellingPartnerApi\ObjectSerializer;
use \SellingPartnerApi\Model\ModelInterface;

/**
 * LabelFormat Class Doc Comment
 *
 * @category Class
 * @description The label format.
 * @package  SellingPartnerApi
 * @group 
 */
class LabelFormat
{
    /**
     * Possible values of this enum
     */
    const PDF = 'PDF';
    const PNG = 'PNG';
    const ZPL203 = 'ZPL203';
    const ZPL300 = 'ZPL300';
    const SHIPPING_SERVICE_DEFAULT = 'ShippingServiceDefault';
    const EMPTY = '';
    
    /**
     * Gets allowable values of the enum
     * @return string[]
     */
    public static function getAllowableEnumValues()
    {
        return [
            self::PDF,
            self::PNG,
            self::ZPL203,
            self::ZPL300,
            self::SHIPPING_SERVICE_DEFAULT,
            self::EMPTY,
        ];
    }
}


