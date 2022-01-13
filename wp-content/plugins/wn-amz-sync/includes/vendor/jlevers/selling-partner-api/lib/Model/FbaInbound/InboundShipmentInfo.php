<?php
/**
 * InboundShipmentInfo
 *
 * PHP version 7.2
 *
 * @category Class
 * @package  SellingPartnerApi
 */

/**
 * Selling Partner API for Fulfillment Inbound
 *
 * The Selling Partner API for Fulfillment Inbound lets you create applications that create and update inbound shipments of inventory to Amazon's fulfillment network.
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

namespace SellingPartnerApi\Model\FbaInbound;

use \ArrayAccess;
use \SellingPartnerApi\ObjectSerializer;
use \SellingPartnerApi\Model\ModelInterface;

/**
 * InboundShipmentInfo Class Doc Comment
 *
 * @category Class
 * @description Information about the seller&#39;s inbound shipments. Returned by the listInboundShipments operation.
 * @package  SellingPartnerApi
 * @group 
 * @implements \ArrayAccess<TKey, TValue>
 * @template TKey int|null
 * @template TValue mixed|null  
 */
class InboundShipmentInfo implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'InboundShipmentInfo';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'shipment_id' => 'string',
        'shipment_name' => 'string',
        'ship_from_address' => '\SellingPartnerApi\Model\FbaInbound\Address',
        'destination_fulfillment_center_id' => 'string',
        'shipment_status' => '\SellingPartnerApi\Model\FbaInbound\ShipmentStatus',
        'label_prep_type' => '\SellingPartnerApi\Model\FbaInbound\LabelPrepType',
        'are_cases_required' => 'bool',
        'confirmed_need_by_date' => '\DateTime',
        'box_contents_source' => '\SellingPartnerApi\Model\FbaInbound\BoxContentsSource',
        'estimated_box_contents_fee' => '\SellingPartnerApi\Model\FbaInbound\BoxContentsFeeDetails'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      * @phpstan-var array<string, string|null>
      * @psalm-var array<string, string|null>
      */
    protected static $openAPIFormats = [
        'shipment_id' => null,
        'shipment_name' => null,
        'ship_from_address' => null,
        'destination_fulfillment_center_id' => null,
        'shipment_status' => null,
        'label_prep_type' => null,
        'are_cases_required' => null,
        'confirmed_need_by_date' => 'date',
        'box_contents_source' => null,
        'estimated_box_contents_fee' => null
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
        'shipment_id' => 'ShipmentId',
        'shipment_name' => 'ShipmentName',
        'ship_from_address' => 'ShipFromAddress',
        'destination_fulfillment_center_id' => 'DestinationFulfillmentCenterId',
        'shipment_status' => 'ShipmentStatus',
        'label_prep_type' => 'LabelPrepType',
        'are_cases_required' => 'AreCasesRequired',
        'confirmed_need_by_date' => 'ConfirmedNeedByDate',
        'box_contents_source' => 'BoxContentsSource',
        'estimated_box_contents_fee' => 'EstimatedBoxContentsFee'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'shipment_id' => 'setShipmentId',
        'shipment_name' => 'setShipmentName',
        'ship_from_address' => 'setShipFromAddress',
        'destination_fulfillment_center_id' => 'setDestinationFulfillmentCenterId',
        'shipment_status' => 'setShipmentStatus',
        'label_prep_type' => 'setLabelPrepType',
        'are_cases_required' => 'setAreCasesRequired',
        'confirmed_need_by_date' => 'setConfirmedNeedByDate',
        'box_contents_source' => 'setBoxContentsSource',
        'estimated_box_contents_fee' => 'setEstimatedBoxContentsFee',
        'headers' => 'setHeaders'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'shipment_id' => 'getShipmentId',
        'shipment_name' => 'getShipmentName',
        'ship_from_address' => 'getShipFromAddress',
        'destination_fulfillment_center_id' => 'getDestinationFulfillmentCenterId',
        'shipment_status' => 'getShipmentStatus',
        'label_prep_type' => 'getLabelPrepType',
        'are_cases_required' => 'getAreCasesRequired',
        'confirmed_need_by_date' => 'getConfirmedNeedByDate',
        'box_contents_source' => 'getBoxContentsSource',
        'estimated_box_contents_fee' => 'getEstimatedBoxContentsFee',
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
        $this->container['shipment_id'] = $data['shipment_id'] ?? null;
        $this->container['shipment_name'] = $data['shipment_name'] ?? null;
        $this->container['ship_from_address'] = $data['ship_from_address'] ?? null;
        $this->container['destination_fulfillment_center_id'] = $data['destination_fulfillment_center_id'] ?? null;
        $this->container['shipment_status'] = $data['shipment_status'] ?? null;
        $this->container['label_prep_type'] = $data['label_prep_type'] ?? null;
        $this->container['are_cases_required'] = $data['are_cases_required'] ?? null;
        $this->container['confirmed_need_by_date'] = $data['confirmed_need_by_date'] ?? null;
        $this->container['box_contents_source'] = $data['box_contents_source'] ?? null;
        $this->container['estimated_box_contents_fee'] = $data['estimated_box_contents_fee'] ?? null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['ship_from_address'] === null) {
            $invalidProperties[] = "'ship_from_address' can't be null";
        }
        if ($this->container['are_cases_required'] === null) {
            $invalidProperties[] = "'are_cases_required' can't be null";
        }
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
     * Gets shipment_id
     *
     * @return string|null
     */
    public function getShipmentId()
    {
        return $this->container['shipment_id'];
    }

    /**
     * Sets shipment_id
     *
     * @param string|null $shipment_id The shipment identifier submitted in the request.
     *
     * @return self
     */
    public function setShipmentId($shipment_id)
    {
        $this->container['shipment_id'] = $shipment_id;

        return $this;
    }

    /**
     * Gets shipment_name
     *
     * @return string|null
     */
    public function getShipmentName()
    {
        return $this->container['shipment_name'];
    }

    /**
     * Sets shipment_name
     *
     * @param string|null $shipment_name The name for the inbound shipment.
     *
     * @return self
     */
    public function setShipmentName($shipment_name)
    {
        $this->container['shipment_name'] = $shipment_name;

        return $this;
    }

    /**
     * Gets ship_from_address
     *
     * @return \SellingPartnerApi\Model\FbaInbound\Address
     */
    public function getShipFromAddress()
    {
        return $this->container['ship_from_address'];
    }

    /**
     * Sets ship_from_address
     *
     * @param \SellingPartnerApi\Model\FbaInbound\Address $ship_from_address ship_from_address
     *
     * @return self
     */
    public function setShipFromAddress($ship_from_address)
    {
        $this->container['ship_from_address'] = $ship_from_address;

        return $this;
    }

    /**
     * Gets destination_fulfillment_center_id
     *
     * @return string|null
     */
    public function getDestinationFulfillmentCenterId()
    {
        return $this->container['destination_fulfillment_center_id'];
    }

    /**
     * Sets destination_fulfillment_center_id
     *
     * @param string|null $destination_fulfillment_center_id An Amazon fulfillment center identifier created by Amazon.
     *
     * @return self
     */
    public function setDestinationFulfillmentCenterId($destination_fulfillment_center_id)
    {
        $this->container['destination_fulfillment_center_id'] = $destination_fulfillment_center_id;

        return $this;
    }

    /**
     * Gets shipment_status
     *
     * @return \SellingPartnerApi\Model\FbaInbound\ShipmentStatus|null
     */
    public function getShipmentStatus()
    {
        return $this->container['shipment_status'];
    }

    /**
     * Sets shipment_status
     *
     * @param \SellingPartnerApi\Model\FbaInbound\ShipmentStatus|null $shipment_status shipment_status
     *
     * @return self
     */
    public function setShipmentStatus($shipment_status)
    {
        $this->container['shipment_status'] = $shipment_status;

        return $this;
    }

    /**
     * Gets label_prep_type
     *
     * @return \SellingPartnerApi\Model\FbaInbound\LabelPrepType|null
     */
    public function getLabelPrepType()
    {
        return $this->container['label_prep_type'];
    }

    /**
     * Sets label_prep_type
     *
     * @param \SellingPartnerApi\Model\FbaInbound\LabelPrepType|null $label_prep_type label_prep_type
     *
     * @return self
     */
    public function setLabelPrepType($label_prep_type)
    {
        $this->container['label_prep_type'] = $label_prep_type;

        return $this;
    }

    /**
     * Gets are_cases_required
     *
     * @return bool
     */
    public function getAreCasesRequired()
    {
        return $this->container['are_cases_required'];
    }

    /**
     * Sets are_cases_required
     *
     * @param bool $are_cases_required Indicates whether or not an inbound shipment contains case-packed boxes. When AreCasesRequired = true for an inbound shipment, all items in the inbound shipment must be case packed.
     *
     * @return self
     */
    public function setAreCasesRequired($are_cases_required)
    {
        $this->container['are_cases_required'] = $are_cases_required;

        return $this;
    }

    /**
     * Gets confirmed_need_by_date
     *
     * @return \DateTime|null
     */
    public function getConfirmedNeedByDate()
    {
        return $this->container['confirmed_need_by_date'];
    }

    /**
     * Sets confirmed_need_by_date
     *
     * @param \DateTime|null $confirmed_need_by_date confirmed_need_by_date
     *
     * @return self
     */
    public function setConfirmedNeedByDate($confirmed_need_by_date)
    {
        $this->container['confirmed_need_by_date'] = $confirmed_need_by_date;

        return $this;
    }

    /**
     * Gets box_contents_source
     *
     * @return \SellingPartnerApi\Model\FbaInbound\BoxContentsSource|null
     */
    public function getBoxContentsSource()
    {
        return $this->container['box_contents_source'];
    }

    /**
     * Sets box_contents_source
     *
     * @param \SellingPartnerApi\Model\FbaInbound\BoxContentsSource|null $box_contents_source box_contents_source
     *
     * @return self
     */
    public function setBoxContentsSource($box_contents_source)
    {
        $this->container['box_contents_source'] = $box_contents_source;

        return $this;
    }

    /**
     * Gets estimated_box_contents_fee
     *
     * @return \SellingPartnerApi\Model\FbaInbound\BoxContentsFeeDetails|null
     */
    public function getEstimatedBoxContentsFee()
    {
        return $this->container['estimated_box_contents_fee'];
    }

    /**
     * Sets estimated_box_contents_fee
     *
     * @param \SellingPartnerApi\Model\FbaInbound\BoxContentsFeeDetails|null $estimated_box_contents_fee estimated_box_contents_fee
     *
     * @return self
     */
    public function setEstimatedBoxContentsFee($estimated_box_contents_fee)
    {
        $this->container['estimated_box_contents_fee'] = $estimated_box_contents_fee;

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


