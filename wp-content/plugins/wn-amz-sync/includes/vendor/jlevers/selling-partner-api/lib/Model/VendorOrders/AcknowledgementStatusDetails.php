<?php
/**
 * AcknowledgementStatusDetails
 *
 * PHP version 7.2
 *
 * @category Class
 * @package  SellingPartnerApi
 */

/**
 * Selling Partner API for Retail Procurement Orders
 *
 * The Selling Partner API for Retail Procurement Orders provides programmatic access to vendor orders data.
 *
 * The version of the OpenAPI document: v1
 * 
 * Generated by: https://openapi-generator.tech
 * OpenAPI Generator version: 5.0.1
 */

/**
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech).
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace SellingPartnerApi\Model\VendorOrders;

use \ArrayAccess;
use \SellingPartnerApi\ObjectSerializer;
use \SellingPartnerApi\Model\ModelInterface;

/**
 * AcknowledgementStatusDetails Class Doc Comment
 *
 * @category Class
 * @description Details of item quantity ordered
 * @package  SellingPartnerApi
 * @group 
 * @implements \ArrayAccess<TKey, TValue>
 * @template TKey int|null
 * @template TValue mixed|null  
 */
class AcknowledgementStatusDetails implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'AcknowledgementStatusDetails';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'acknowledgement_date' => '\DateTime',
        'accepted_quantity' => '\SellingPartnerApi\Model\VendorOrders\ItemQuantity',
        'rejected_quantity' => '\SellingPartnerApi\Model\VendorOrders\ItemQuantity'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      * @phpstan-var array<string, string|null>
      * @psalm-var array<string, string|null>
      */
    protected static $openAPIFormats = [
        'acknowledgement_date' => 'date-time',
        'accepted_quantity' => null,
        'rejected_quantity' => null
    ];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function openAPITypes()
    {
        return self::$openAPITypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function openAPIFormats()
    {
        return self::$openAPIFormats;
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'acknowledgement_date' => 'acknowledgementDate',
        'accepted_quantity' => 'acceptedQuantity',
        'rejected_quantity' => 'rejectedQuantity'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'acknowledgement_date' => 'setAcknowledgementDate',
        'accepted_quantity' => 'setAcceptedQuantity',
        'rejected_quantity' => 'setRejectedQuantity',
        'headers' => 'setHeaders'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'acknowledgement_date' => 'getAcknowledgementDate',
        'accepted_quantity' => 'getAcceptedQuantity',
        'rejected_quantity' => 'getRejectedQuantity',
        'headers' => 'getHeaders'
    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName()
    {
        return self::$openAPIModelName;
    }

    

    

    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['acknowledgement_date'] = $data['acknowledgement_date'] ?? null;
        $this->container['accepted_quantity'] = $data['accepted_quantity'] ?? null;
        $this->container['rejected_quantity'] = $data['rejected_quantity'] ?? null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {
        return count($this->listInvalidProperties()) === 0;
    }

    /**
     * Gets headers, if this is a top-level response model
     *
     * @return array[string]|null
     */
    public function getHeaders()
    {
        return $this->container['headers'];
    }

    /**
     * Sets headers (only relevant to response models)
     *
     * @param array[string => string]|null $headers Associative array of response headers.
     *
     * @return self
     */
    public function setHeaders($headers)
    {
        $this->container['headers'] = $headers;

        return $this;
    }


    /**
     * Gets acknowledgement_date
     *
     * @return \DateTime|null
     */
    public function getAcknowledgementDate()
    {
        return $this->container['acknowledgement_date'];
    }

    /**
     * Sets acknowledgement_date
     *
     * @param \DateTime|null $acknowledgement_date The date when the line item was confirmed by vendor. Must be in ISO-8601 date/time format.
     *
     * @return self
     */
    public function setAcknowledgementDate($acknowledgement_date)
    {
        $this->container['acknowledgement_date'] = $acknowledgement_date;

        return $this;
    }

    /**
     * Gets accepted_quantity
     *
     * @return \SellingPartnerApi\Model\VendorOrders\ItemQuantity|null
     */
    public function getAcceptedQuantity()
    {
        return $this->container['accepted_quantity'];
    }

    /**
     * Sets accepted_quantity
     *
     * @param \SellingPartnerApi\Model\VendorOrders\ItemQuantity|null $accepted_quantity accepted_quantity
     *
     * @return self
     */
    public function setAcceptedQuantity($accepted_quantity)
    {
        $this->container['accepted_quantity'] = $accepted_quantity;

        return $this;
    }

    /**
     * Gets rejected_quantity
     *
     * @return \SellingPartnerApi\Model\VendorOrders\ItemQuantity|null
     */
    public function getRejectedQuantity()
    {
        return $this->container['rejected_quantity'];
    }

    /**
     * Sets rejected_quantity
     *
     * @param \SellingPartnerApi\Model\VendorOrders\ItemQuantity|null $rejected_quantity rejected_quantity
     *
     * @return self
     */
    public function setRejectedQuantity($rejected_quantity)
    {
        $this->container['rejected_quantity'] = $rejected_quantity;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param integer $offset Offset
     *
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param integer $offset Offset
     *
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        return $this->container[$offset] ?? null;
    }

    /**
     * Sets value based on offset.
     *
     * @param int|null $offset Offset
     * @param mixed    $value  Value to be set
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param integer $offset Offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Serializes the object to a value that can be serialized natively by json_encode().
     * @link https://www.php.net/manual/en/jsonserializable.jsonserialize.php
     *
     * @return mixed Returns data which can be serialized by json_encode(), which is a value
     * of any type other than a resource.
     */
    public function jsonSerialize()
    {
       return ObjectSerializer::sanitizeForSerialization($this);
    }

    /**
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode(
            ObjectSerializer::sanitizeForSerialization($this),
            JSON_PRETTY_PRINT
        );
    }

    /**
     * Gets a header-safe presentation of the object
     *
     * @return string
     */
    public function toHeaderValue()
    {
        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}


