<?php
/**
 * DebtRecoveryItem
 *
 * PHP version 7.2
 *
 * @category Class
 * @package  SellingPartnerApi
 */

/**
 * Selling Partner API for Finances
 *
 * The Selling Partner API for Finances helps you obtain financial information relevant to a seller's business. You can obtain financial events for a given order, financial event group, or date range without having to wait until a statement period closes. You can also obtain financial event groups for a given date range.
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

namespace SellingPartnerApi\Model\Finances;

use \ArrayAccess;
use \SellingPartnerApi\ObjectSerializer;
use \SellingPartnerApi\Model\ModelInterface;

/**
 * DebtRecoveryItem Class Doc Comment
 *
 * @category Class
 * @description An item of a debt payment or debt adjustment.
 * @package  SellingPartnerApi
 * @group 
 * @implements \ArrayAccess<TKey, TValue>
 * @template TKey int|null
 * @template TValue mixed|null  
 */
class DebtRecoveryItem implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'DebtRecoveryItem';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'recovery_amount' => '\SellingPartnerApi\Model\Finances\Currency',
        'original_amount' => '\SellingPartnerApi\Model\Finances\Currency',
        'group_begin_date' => '\DateTime',
        'group_end_date' => '\DateTime'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      * @phpstan-var array<string, string|null>
      * @psalm-var array<string, string|null>
      */
    protected static $openAPIFormats = [
        'recovery_amount' => null,
        'original_amount' => null,
        'group_begin_date' => 'date-time',
        'group_end_date' => 'date-time'
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
        'recovery_amount' => 'RecoveryAmount',
        'original_amount' => 'OriginalAmount',
        'group_begin_date' => 'GroupBeginDate',
        'group_end_date' => 'GroupEndDate'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'recovery_amount' => 'setRecoveryAmount',
        'original_amount' => 'setOriginalAmount',
        'group_begin_date' => 'setGroupBeginDate',
        'group_end_date' => 'setGroupEndDate',
        'headers' => 'setHeaders'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'recovery_amount' => 'getRecoveryAmount',
        'original_amount' => 'getOriginalAmount',
        'group_begin_date' => 'getGroupBeginDate',
        'group_end_date' => 'getGroupEndDate',
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
        $this->container['recovery_amount'] = $data['recovery_amount'] ?? null;
        $this->container['original_amount'] = $data['original_amount'] ?? null;
        $this->container['group_begin_date'] = $data['group_begin_date'] ?? null;
        $this->container['group_end_date'] = $data['group_end_date'] ?? null;
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
     * Gets recovery_amount
     *
     * @return \SellingPartnerApi\Model\Finances\Currency|null
     */
    public function getRecoveryAmount()
    {
        return $this->container['recovery_amount'];
    }

    /**
     * Sets recovery_amount
     *
     * @param \SellingPartnerApi\Model\Finances\Currency|null $recovery_amount recovery_amount
     *
     * @return self
     */
    public function setRecoveryAmount($recovery_amount)
    {
        $this->container['recovery_amount'] = $recovery_amount;

        return $this;
    }

    /**
     * Gets original_amount
     *
     * @return \SellingPartnerApi\Model\Finances\Currency|null
     */
    public function getOriginalAmount()
    {
        return $this->container['original_amount'];
    }

    /**
     * Sets original_amount
     *
     * @param \SellingPartnerApi\Model\Finances\Currency|null $original_amount original_amount
     *
     * @return self
     */
    public function setOriginalAmount($original_amount)
    {
        $this->container['original_amount'] = $original_amount;

        return $this;
    }

    /**
     * Gets group_begin_date
     *
     * @return \DateTime|null
     */
    public function getGroupBeginDate()
    {
        return $this->container['group_begin_date'];
    }

    /**
     * Sets group_begin_date
     *
     * @param \DateTime|null $group_begin_date group_begin_date
     *
     * @return self
     */
    public function setGroupBeginDate($group_begin_date)
    {
        $this->container['group_begin_date'] = $group_begin_date;

        return $this;
    }

    /**
     * Gets group_end_date
     *
     * @return \DateTime|null
     */
    public function getGroupEndDate()
    {
        return $this->container['group_end_date'];
    }

    /**
     * Sets group_end_date
     *
     * @param \DateTime|null $group_end_date group_end_date
     *
     * @return self
     */
    public function setGroupEndDate($group_end_date)
    {
        $this->container['group_end_date'] = $group_end_date;

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


