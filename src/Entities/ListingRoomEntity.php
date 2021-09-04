<?php

namespace Amarkhai\AirbnbSdk\Entities;

use Amarkhai\AirbnbSdk\Exceptions\EmptyRequiredFieldsException;

/**
 * The entity for representation Listing Rooms
 */
class ListingRoomEntity
{
    private const REQUIRED_FIELDS = [
        'listing_id',
        'room_number'
    ];

    private const FIELDS_EXCLUDED_FROM_EXPORT = [
        'id',
        'listing_id_str',
    ];
    /**
     * Room ID.
     * @var int|null
     */
    private $id;
    /**
     * Associated Listing ID
     * @var string
     */
    private $listing_id;
    /**
     * String representation of the listing_id
     * @var string
     */
    private $listing_id_str;
    /**
     * The number of the room. Use 0 for living room/common spaces and 1, 2, ... for bedrooms
     * @var int
     */
    private $room_number;
    /**
     * A list of beds in the room.
     * @var array|null
     */
    private $beds;
    /**
     * A list of amenities in the room.
     * @var array|null
     */
    private $room_amenities;
    /**
     * The type of room. Room 0 (zero) is assumed to be the living room/common space, and all other rooms are assumed
     * to be bedrooms unless room_type is specified.
     * @var string|null
     */
    private $room_type;

    /**
     * ListingRoomEntity constructor.
     * @param int $listing_id
     * @param int $room_number
     */
    public function __construct(int $listing_id, int $room_number)
    {
        $this->listing_id = $listing_id;
        $this->room_number = $room_number;
    }

    /**
     * @param bool $withoutNulls
     * @return array
     */
    public function exportAsArray(bool $withoutNulls = false): array
    {
        $listingRoom = get_object_vars($this);

        foreach (self::FIELDS_EXCLUDED_FROM_EXPORT as $field) {
            unset($listingRoom[$field]);
        }

        if ($withoutNulls) {
            foreach ($listingRoom as $fieldName => $value) {
                if (is_null($value)) {
                    unset($listingRoom[$fieldName]);
                }
            }
        }

        return $listingRoom;
    }

    /**
     * @param array $fields
     * @return ListingRoomEntity
     */
    public function fillByArray(array $fields): ListingRoomEntity
    {
        foreach ($fields as $name => $value) {
            $this->$name = $value;
        }

        return $this;
    }

    /**
     * @param array $data
     * @return ListingRoomEntity
     * @throws EmptyRequiredFieldsException
     */
    public static function createByArray(array $data): ListingRoomEntity
    {
        foreach (self::REQUIRED_FIELDS as $field) {
            if (!isset($data[$field])) {
                throw new EmptyRequiredFieldsException(sprintf(
                    'Some of required fields is absent: %s',
                    implode(',', self::REQUIRED_FIELDS)
                ));
            }
        }

        $room = new self(
            $data['listing_id'],
            $data['room_number']
        );

        $room->fillByArray($data);

        return $room;
    }

    /**
     * @return string
     */
    public function getListingId(): string
    {
        return $this->listing_id;
    }

    /**
     * @param string $listing_id
     * @return ListingRoomEntity
     */
    public function setListingId(string $listing_id): ListingRoomEntity
    {
        $this->listing_id = $listing_id;
        return $this;
    }

    /**
     * @return int
     */
    public function getRoomNumber(): int
    {
        return $this->room_number;
    }

    /**
     * @param int $room_number
     * @return ListingRoomEntity
     */
    public function setRoomNumber(int $room_number): ListingRoomEntity
    {
        $this->room_number = $room_number;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getBeds(): ?array
    {
        return $this->beds;
    }

    /**
     * @param array|null $beds
     * @return ListingRoomEntity
     */
    public function setBeds(?array $beds): ListingRoomEntity
    {
        $this->beds = $beds;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getRoomAmenities(): ?array
    {
        return $this->room_amenities;
    }

    /**
     * @param array|null $room_amenities
     * @return ListingRoomEntity
     */
    public function setRoomAmenities(?array $room_amenities): ListingRoomEntity
    {
        $this->room_amenities = $room_amenities;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRoomType(): ?string
    {
        return $this->room_type;
    }

    /**
     * @param string|null $room_type
     * @return ListingRoomEntity
     */
    public function setRoomType(?string $room_type): ListingRoomEntity
    {
        $this->room_type = $room_type;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getListingIdStr(): string
    {
        return $this->listing_id_str;
    }
}
