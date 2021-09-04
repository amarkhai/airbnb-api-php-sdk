<?php

namespace Amarkhai\AirbnbSdk\Entities;

use Amarkhai\AirbnbSdk\Exceptions\EmptyRequiredFieldsException;

/**
 * The entity for representation Listings
 */
class ListingEntity
{
    public const REQUESTED_APPROVAL_STATUS_CATEGORY_NEW = 'new';
    public const REQUESTED_APPROVAL_STATUS_CATEGORY_READY_FOR_REVIEW = 'ready for review';
    public const REQUESTED_APPROVAL_STATUS_CATEGORY_REJECTED = 'rejected';
    public const REQUESTED_APPROVAL_STATUS_CATEGORY_APPROVED = 'approved';

    public const SYNCHRONIZATION_CATEGORY_SYNC_ALL = 'sync_all';
    public const SYNCHRONIZATION_CATEGORY_SYNC_RATES_AND_AVAILABILITY = 'sync_rates_and_availability';
    public const SYNCHRONIZATION_CATEGORY_SYNC_UNDECIDED = 'sync_all';

    /**
     * Available values for the 'synchronization_category' field
     */
    private const AVAILABLE_SYNCHRONIZATION_CATEGORIES = [
        self::SYNCHRONIZATION_CATEGORY_SYNC_ALL,
        self::SYNCHRONIZATION_CATEGORY_SYNC_RATES_AND_AVAILABILITY,
        self::SYNCHRONIZATION_CATEGORY_SYNC_UNDECIDED,
        null,
    ];

    private const REQUIRED_FIELDS = [
        'name',
        'country_code',
        'city',
        'lat',
        'lng',
        'listing_price'
    ];

    private const FIELDS_EXCLUDED_FROM_EXPORT = [
        'id',
        'id_str',
        'display_exact_location_to_guest',
        'tier',
        'listing_nickname',
        'common_spaces_shared_with_category',
        'user_defined_location',
        'listing_approval_status',
    ];

    /**
     * Listing ID. The number ID will be deprecated in the future, use string ID _str field instead - Airbnb
     * @var int|null
     */
    private $id;
    /**
     * String representation of the id
     * @var string|null
     */
    private $id_str;

    /**
     * Whether the listing is listed or not.
     * While this field is false, the listing will not appear on Airbnb. Do not set it to false until after the listing
     * is published for the first time to avoid re-setting the review process.
     * @var bool|null
     */
    private $has_availability;

    /**
     * how guests will check in.
     * @var array|null
     * array like ["category" => string, "instruction" => string]
     * "category" - The type of check in the host offers. Must one of supported strings.
     * "instruction" - The instructions for guests on how to check in. Only shared with confirmed guests.
     */
    private $check_in_option;
    /**
     * Display exact location on map to guest or an approximate circle. Default is false, while guest with confirmed
     * reservation will always see exact location
     * @var bool|null
     */
    private $display_exact_location_to_guest;
    /**
     * The tier of a listing. One of "lux", "marketplace" or "plus".
     * @var string|null
     */
    private $tier;
    /**
     * The nickname of a listing which is only visible to the host. If a nickname is set, the listing name returned by
     * the API becomes nickname - name. The guests can only see the name of the listing.
     * @var string|null
     */
    private $listing_nickname;
    /**
     * Who are the common spaces shared with? Pass one or more from "host", "family_friends_roommates", "other_guests".
     * Ignore for "entire_home" listings.
     * @var string|null
     */
    private $common_spaces_shared_with_category;
    /**
     * Set this field to true if you are providing lat and lng coordinates.
     * @var bool|null
     */
    private $user_defined_location;
    /**
     * Listing Approval Status object.
     * @var array|null
     */
    private $listing_approval_status;
    /**
     * The listing's synchronization category.
     * @var string|null
     */
    private $synchronization_category;
    /**
     * Listing name. 255 character maximum; 1 character minimum.
     * @var string
     */
    private $name;
    /**
     * Generalized group of the property types.
     * @var string|null
     */
    private $property_type_group;
    /**
     * Property type
     * @var string|null
     */
    private $property_type_category;
    /**
     * Is this listing a shared room, private room, or the entire home
     * @var string|null
     */
    private $room_type_category;
    /**
     * Number of bedrooms. Minimum: 0 Maximum: 50. Zero (0) bedrooms indicates a studio.
     * @var int|null
     */
    private $bedrooms;
    /**
     * Number of bathrooms. Minimum: 0 Maximum: 50. Half values can be used (1.5). A three-quarters bath can be
     * included as a half or full bath.
     * @var float|null
     */
    private $bathrooms;
    /**
     * Number of beds
     * @var int|null
     */
    private $beds;
    /**
     * List of amenities
     * @var string[]|null
     */
    private $amenity_categories;
    /**
     * The local permit or tax ID.
     * @var string|null
     */
    private $permit_or_tax_id;
    /**
     * Apartment/Unit. Non-special characters only.
     * @var string
     */
    private $apt;
    /**
     * Street address. Should include number, street name, and street suffix.
     * @var string|null
     */
    private $street;
    /**
     * @var string
     */
    private $city;
    /**
     * States, territories, districts, or province. For US states, use the official two-letter abbreviation.
     * @var string|null
     */
    private $state;
    /**
     * Zip or postal code.
     * @var string|null
     */
    private $zipcode;
    /**
     * Listing's two-letter country code, capitalized. Format: ISO 3166-1 alpha-2
     * @var string
     */
    private $country_code;
    /**
     * Latitude
     * @var float
     */
    private $lat;
    /**
     * Longitude
     * @var float
     */
    private $lng;
    /**
     * Directions. These are only provided to confirmed guests.
     * @var string|null
     */
    private $directions;
    /**
     * Maximum number of guests that can be accommodated. Default is 1.
     * @var string|null
     */
    private $person_capacity = '1';
    /**
     * Currency used for setting listing price. Only supported strings are accepted.
     * Format: [ISO 4217]https://www.iso.org/iso-4217-currency-codes.html
     * @var string|null
     */
    private $listing_currency;
    /**
     * Listing's base nightly price. Price is in listing_currency currency. Minimum = 10 USD, maximum = 25000 USD.
     * @var int
     */
    private $listing_price;
    /**
     * Is the bathroom shared? Ignore for entire_home listings.
     * @var bool|null
     */
    private $bathroom_shared;
    /**
     * Who is the bathroom shared with? Pass one or more values. Ignore for "entire_home" listings.
     * @var string[]|null
     */
    private $bathroom_shared_with_category;
    /**
     * Are the common spaces shared? Ignore for entire_home listings.
     * @var bool|null
     */
    private $common_spaces_shared;
    /**
     * Listing’s Airbnb review status. Set to 'ready for review' to trigger the automatic review and publish process.
     * Best practice is to send this value separately to ensure proper processing order.Once the listing is published,
     * the value will be changed to 'approved'.Once the listing has been approved, do not send this field again to avoid
     * triggering another review.
     * @var string|null
     */
    private $requested_approval_status_category;
    /**
     * Only used with Room Type inventory. The total number of rooms of a certain room type. Valid value: > 0.
     * @var int|null
     */
    private $total_inventory_count;
    /**
     * Only used with Room Type inventory. A string indicating which property current listing belongs to.
     * @var string|null
     */
    private $property_external_id;
    /**
     * Notes for guest on enjoying their visit and the property
     * @var int|null
     */
    private $house_manual;
    /**
     * name of the wifi network at the listing
     * @var string|null
     */
    private $wifi_network;
    /**
     * password for connecting to the wifi, cannot be set without wifi network
     * @var string|null
     */
    private $wifi_password;

    /**
     * ListingEntity constructor.
     * @param string $name
     * @param string|null $country_code
     * @param string|null $city
     * @param float|null $lat
     * @param float|null $lng
     * @param int|null $listing_price
     */
    public function __construct(
        string $name,
        ?string $country_code,
        ?string $city,
        ?float $lat,
        ?float $lng,
        ?int $listing_price
    ) {
        $this->name = $name;
        $this->country_code = $country_code;
        $this->city = $city;
        $this->lat = $lat;
        $this->lng = $lng;
        $this->listing_price = $listing_price;
    }

    /**
     * @param bool $withoutNulls
     * @return array
     */
    public function exportAsArray(bool $withoutNulls = false): array
    {
        $listing = get_object_vars($this);

        foreach (self::FIELDS_EXCLUDED_FROM_EXPORT as $field) {
            unset($listing[$field]);
        }

        if ($withoutNulls) {
            foreach ($listing as $fieldName => $value) {
                if (is_null($value)) {
                    unset($listing[$fieldName]);
                }
            }
        }

        return $listing;
    }

    /**
     * @param array $fields
     * @return ListingEntity
     */
    public function fillByArray(array $fields): ListingEntity
    {
        foreach ($fields as $name => $value) {
            $this->$name = $value;
        }

        return $this;
    }

    /**
     * @param array $data
     * @return ListingEntity
     * @throws EmptyRequiredFieldsException
     */
    public static function createByArray(array $data): ListingEntity
    {
        foreach (self::REQUIRED_FIELDS as $field) {
            if (!array_key_exists($field, $data)) {
                throw new EmptyRequiredFieldsException(sprintf(
                    'Some of required fields is absent: %s',
                    implode(',', self::REQUIRED_FIELDS)
                ));
            }
        }

        $listing = new self(
            $data['name'],
            $data['country_code'],
            $data['city'],
            $data['lat'],
            $data['lng'],
            $data['listing_price']
        );

        $listing->fillByArray($data);

        return $listing;
    }

    /**
     * Set null for all address fields
     * @return ListingEntity
     */
    public function clearAddressInfo(): ListingEntity
    {
        $this->street = null;
        $this->city = null;
        $this->state = null;
        $this->zipcode = null;
        $this->country_code = null;
        $this->lat = null;
        $this->lng = null;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return ListingEntity
     */
    public function setName(string $name): ListingEntity
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return ListingEntity
     */
    public function setCity(string $city): ListingEntity
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return float
     */
    public function getLat(): float
    {
        return $this->lat;
    }

    /**
     * @param float $lat
     * @return ListingEntity
     */
    public function setLat(float $lat): ListingEntity
    {
        $this->lat = $lat;
        return $this;
    }

    /**
     * @return float
     */
    public function getLng(): float
    {
        return $this->lng;
    }

    /**
     * @param float $lng
     * @return ListingEntity
     */
    public function setLng(float $lng): ListingEntity
    {
        $this->lng = $lng;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getSynchronizationCategory(): ?string
    {
        return $this->synchronization_category;
    }

    /**
     * @param string|null $synchronization_category
     */
    public function setSynchronizationCategory(?string $synchronization_category)
    {
        $this->synchronization_category = $synchronization_category;
    }
    /**
     * @return int
     */
    public function getListingPrice(): int
    {
        return $this->listing_price;
    }
    /**
     * @param int $listing_price
     * @return ListingEntity
     */
    public function setListingPrice(int $listing_price): ListingEntity
    {
        $this->listing_price = $listing_price;
        return $this;
    }
    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }
    /**
     * @return string
     */
    public function getPersonCapacity(): ?string
    {
        return $this->person_capacity;
    }
    /**
     * @param string|null $person_capacity
     * @return ListingEntity
     */
    public function setPersonCapacity(?string $person_capacity): ListingEntity
    {
        $this->person_capacity = $person_capacity;
        return $this;
    }
    /**
     * @return string
     */
    public function getPropertyTypeGroup(): ?string
    {
        return $this->property_type_group;
    }
    /**
     * @param string|null $property_type_group
     * @return ListingEntity
     */
    public function setPropertyTypeGroup(?string $property_type_group): ListingEntity
    {
        $this->property_type_group = $property_type_group;
        return $this;
    }
    /**
     * @return string
     */
    public function getPropertyTypeCategory(): ?string
    {
        return $this->property_type_category;
    }
    /**
     * @param string|null $property_type_category
     * @return ListingEntity
     */
    public function setPropertyTypeCategory(?string $property_type_category): ListingEntity
    {
        $this->property_type_category = $property_type_category;
        return $this;
    }
    /**
     * @return string
     */
    public function getRoomTypeCategory(): ?string
    {
        return $this->room_type_category;
    }
    /**
     * @param string|null $room_type_category
     * @return ListingEntity
     */
    public function setRoomTypeCategory(?string $room_type_category): ListingEntity
    {
        $this->room_type_category = $room_type_category;
        return $this;
    }
    /**
     * @return int
     */
    public function getBedrooms(): ?int
    {
        return $this->bedrooms;
    }
    /**
     * @param int|null $bedrooms
     * @return ListingEntity
     */
    public function setBedrooms(?int $bedrooms): ListingEntity
    {
        $this->bedrooms = $bedrooms;
        return $this;
    }
    /**
     * @return float
     */
    public function getBathrooms(): ?float
    {
        return $this->bathrooms;
    }
    /**
     * @param float|null $bathrooms
     * @return ListingEntity
     */
    public function setBathrooms(?float $bathrooms): ListingEntity
    {
        $this->bathrooms = $bathrooms;
        return $this;
    }
    /**
     * @return string[]
     */
    public function getAmenityCategories(): ?array
    {
        return $this->amenity_categories;
    }
    /**
     * @param array|null $amenity_categories
     * @return $this
     */
    public function setAmenityCategories(?array $amenity_categories): ListingEntity
    {
        $this->amenity_categories = $amenity_categories;
        return $this;
    }
    /**
     * @return string
     */
    public function getPermitOrTaxId(): ?string
    {
        return $this->permit_or_tax_id;
    }
    /**
     * @param string|null $permit_or_tax_id
     * @return ListingEntity
     */
    public function setPermitOrTaxId(?string $permit_or_tax_id): ListingEntity
    {
        $this->permit_or_tax_id = $permit_or_tax_id;
        return $this;
    }
    /**
     * @return string
     */
    public function getApt(): ?string
    {
        return $this->apt;
    }
    /**
     * @param string|null $apt
     * @return ListingEntity
     */
    public function setApt(?string $apt)
    {
        $this->apt = $apt;
        return $this;
    }
    /**
     * @return string
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }
    /**
     * @param string|null $street
     * @return ListingEntity
     */
    public function setStreet(?string $street): ListingEntity
    {
        $this->street = $street;
        return $this;
    }
    /**
     * @return string
     */
    public function getState(): ?string
    {
        return $this->state;
    }
    /**
     * @param string|null $state
     * @return ListingEntity
     */
    public function setState(?string $state): ListingEntity
    {
        $this->state = $state;
        return $this;
    }
    /**
     * @return string
     */
    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }
    /**
     * @param string|null $zipcode
     * @return ListingEntity
     */
    public function setZipcode(?string $zipcode): ListingEntity
    {
        $this->zipcode = $zipcode;
        return $this;
    }
    /**
     * @return string
     */
    public function getDirections(): ?string
    {
        return $this->directions;
    }
    /**
     * @param string|null $directions
     * @return ListingEntity
     */
    public function setDirections(?string $directions): ListingEntity
    {
        $this->directions = $directions;
        return $this;
    }
    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->country_code;
    }
    /**
     * @param string $country_code
     * @return ListingEntity
     */
    public function setCountryCode(string $country_code): ListingEntity
    {
        $this->country_code = $country_code;
        return $this;
    }
    /**
     * @return string
     */
    public function getListingCurrency(): ?string
    {
        return $this->listing_currency;
    }
    /**
     * @param string|null $listing_currency
     * @return ListingEntity
     */
    public function setListingCurrency(?string $listing_currency): ListingEntity
    {
        $this->listing_currency = $listing_currency;
        return $this;
    }
    /**
     * @return bool
     */
    public function isBathroomShared(): ?bool
    {
        return $this->bathroom_shared;
    }

    /**
     * @param bool $bathroom_shared
     * @return ListingEntity
     */
    public function setBathroomShared(?bool $bathroom_shared): ListingEntity
    {
        $this->bathroom_shared = $bathroom_shared;
        return $this;
    }
    /**
     * @return string[]
     */
    public function getBathroomSharedWithCategory(): ?array
    {
        return $this->bathroom_shared_with_category;
    }
    /**
     * @param array|null $bathroom_shared_with_category
     * @return $this
     */
    public function setBathroomSharedWithCategory(?array $bathroom_shared_with_category): ListingEntity
    {
        $this->bathroom_shared_with_category = $bathroom_shared_with_category;
        return $this;
    }
    /**
     * @return bool
     */
    public function isCommonSpacesShared(): ?bool
    {
        return $this->common_spaces_shared;
    }
    /**
     * @param bool|null $common_spaces_shared
     * @return $this
     */
    public function setCommonSpacesShared(?bool $common_spaces_shared): ListingEntity
    {
        $this->common_spaces_shared = $common_spaces_shared;
        return $this;
    }
    /**
     * @return string
     */
    public function getRequestedApprovalStatusCategory(): ?string
    {
        return $this->requested_approval_status_category;
    }

    /**
     * @param string|null $requested_approval_status_category
     * @return ListingEntity
     */
    public function setRequestedApprovalStatusCategory(?string $requested_approval_status_category): ListingEntity
    {
        $this->requested_approval_status_category = $requested_approval_status_category;
        return $this;
    }

    /**
     * @return int
     */
    public function getTotalInventoryCount(): ?int
    {
        return $this->total_inventory_count;
    }

    /**
     * @param int|null $total_inventory_count
     * @return ListingEntity
     */
    public function setTotalInventoryCount(?int $total_inventory_count): ListingEntity
    {
        $this->total_inventory_count = $total_inventory_count;
        return $this;
    }

    /**
     * @return string
     */
    public function getPropertyExternalId(): ?string
    {
        return $this->property_external_id;
    }

    /**
     * @param string|null $property_external_id
     * @return ListingEntity
     */
    public function setPropertyExternalId(?string $property_external_id): ListingEntity
    {
        $this->property_external_id = $property_external_id;
        return $this;
    }

    /**
     * @return int
     */
    public function getHouseManual(): ?int
    {
        return $this->house_manual;
    }

    /**
     * @param int|null $house_manual
     * @return ListingEntity
     */
    public function setHouseManual(?int $house_manual): ListingEntity
    {
        $this->house_manual = $house_manual;
        return $this;
    }

    /**
     * @return string
     */
    public function getWifiNetwork(): ?string
    {
        return $this->wifi_network;
    }

    /**
     * @param string|null $wifi_network
     * @return ListingEntity
     */
    public function setWifiNetwork(?string $wifi_network)
    {
        $this->wifi_network = $wifi_network;
        return $this;
    }

    /**
     * @return int
     */
    public function getBeds(): ?int
    {
        return $this->beds;
    }

    /**
     * @param int $beds
     * @return ListingEntity
     */
    public function setBeds(?int $beds)
    {
        $this->beds = $beds;
        return $this;
    }

    /**
     * @return string
     */
    public function getWifiPassword(): ?string
    {
        return $this->wifi_password;
    }

    /**
     * @param string|null $wifi_password
     * @return ListingEntity
     */
    public function setWifiPassword(?string $wifi_password): ListingEntity
    {
        $this->wifi_password = $wifi_password;
        return $this;
    }

    /**
     * @return string
     */
    public function getIdStr(): ?string
    {
        return $this->id_str;
    }

    /**
     * @return bool|null
     */
    public function getDisplayExactLocationToGuest(): ?bool
    {
        return $this->display_exact_location_to_guest;
    }

    /**
     * @return string|null
     */
    public function getTier(): ?string
    {
        return $this->tier;
    }

    /**
     * @return string|null
     */
    public function getListingNickname(): ?string
    {
        return $this->listing_nickname;
    }

    /**
     * @return string|null
     */
    public function getCommonSpacesSharedWithCategory(): ?string
    {
        return $this->common_spaces_shared_with_category;
    }

    /**
     * @return bool|null
     */
    public function getUserDefinedLocation(): ?bool
    {
        return $this->user_defined_location;
    }

    /**
     * @param bool|null $has_availability
     * @return ListingEntity
     */
    public function setHasAvailability(?bool $has_availability): ListingEntity
    {
        $this->has_availability = $has_availability;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getHasAvailability(): ?bool
    {
        return $this->has_availability;
    }

    /**
     * @return array|null
     */
    public function getCheckInOption(): ?array
    {
        return $this->check_in_option;
    }

    /**
     * @param array|null $check_in_option
     * @return ListingEntity
     */
    public function setCheckInOption(?array $check_in_option): ListingEntity
    {
        $this->check_in_option = $check_in_option;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getListingApprovalStatus(): ?array
    {
        return $this->listing_approval_status;
    }
}
