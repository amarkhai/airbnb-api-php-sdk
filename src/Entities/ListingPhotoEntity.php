<?php

namespace Amarkhai\AirbnbSdk\Entities;

use Amarkhai\AirbnbSdk\Exceptions\EmptyRequiredFieldsException;

/**
 * The entity for representation Listing Photo
 */
class ListingPhotoEntity
{
    private const REQUIRED_FIELDS = [
        'listing_id',
        'image'
    ];

    private const FIELDS_EXCLUDED_FROM_EXPORT = [
        'thumbnail_url',
        'small_url',
        'extra_medium_url',
        'id',
        'listing_id_str',
        'large_url',
        'extra_large_url',
    ];
    /**
     * Associated Listing ID.
     * @var string
     */
    private $listing_id;
    /**
     * String representation of the listing_id
     * @var string|null
     */
    private $listing_id_str;
    /**
     * Image MIME content type. This field is being deprecated and is not required anymore.
     * @var string|null
     */
    private $content_type;
    /**
     * The file extension must match the content_type. This field is being deprecated and is not required anymore.
     * @var string|null
     */
    private $filename;
    /**
     * Image contents in base64 string format. Images cannot be larger then 25MB or smaller than 50 KB and will be
     * auto-cropped.
     * @var string
     */
    private $image;
    /**
     * Photo description.
     * @var string|null
     */
    private $caption;
    /**
     * Determines the order of photos displayed on the listing. The photo with the lowest sort_order value is shown
     * first.
     * @var int|null
     */
    private $sort_order;
    /**
     * The listing_id and then the unique photo_id separated by an underscore.
     * @var string|null
     */
    private $id;
    /**
     * Thumbnail image (example: 114 x 74) URL.
     * @var string|null
     */
    private $thumbnail_url;
    /**
     * Small image (example: 216 x 144) URL.
     * @var string|null
     */
    private $small_url;
    /**
     * Medium image (example: 416 x 224) URL.
     * @var string|null
     */
    private $extra_medium_url;
    /**
     * Large image (example: 636 x 429) URL.
     * @var string|null
     */
    private $large_url;
    /**
     * Extra-large image (example: 1024 x 683) URL.
     * @var string|null
     */
    private $extra_large_url;
    /**
     * ListingPhotoEntity constructor.
     * @param string $listing_id
     * @param string $image
     */
    public function __construct(string $listing_id, string $image)
    {
        $this->listing_id = $listing_id;
        $this->image = $image;
    }

    /**
     * @param bool $withoutNulls
     * @return array
     */
    public function exportAsArray(bool $withoutNulls = false): array
    {
        $listingPhotoData = get_object_vars($this);

        foreach (self::FIELDS_EXCLUDED_FROM_EXPORT as $field) {
            unset($listingPhotoData[$field]);
        }

        if ($withoutNulls) {
            foreach ($listingPhotoData as $fieldName => $value) {
                if (is_null($value)) {
                    unset($listingPhotoData[$fieldName]);
                }
            }
        }

        return $listingPhotoData;
    }

    /**
     * @param array $fields
     * @return ListingPhotoEntity
     */
    public function fillByArray(array $fields): ListingPhotoEntity
    {
        foreach ($fields as $name => $value) {
            $this->$name = $value;
        }

        return $this;
    }

    /**
     * @param array $data
     * @return ListingPhotoEntity
     * @throws EmptyRequiredFieldsException
     */
    public static function createByArray(array $data): ListingPhotoEntity
    {
        // need to set field 'image' because when we get all photo for listing, airbnb sent data without images
        if (!isset($data['image'])) {
            $data['image'] = '';
        }

        foreach (self::REQUIRED_FIELDS as $field) {
            if (!isset($data[$field])) {
                throw new EmptyRequiredFieldsException(sprintf(
                    'Some of required fields is absent: %s',
                    implode(',', self::REQUIRED_FIELDS)
                ));
            }
        }

        $photo = new self(
            $data['listing_id'],
            $data['image']
        );

        $photo->fillByArray($data);

        return $photo;
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
     * @return ListingPhotoEntity
     */
    public function setListingId(string $listing_id): ListingPhotoEntity
    {
        $this->listing_id = $listing_id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getContentType(): ?string
    {
        return $this->content_type;
    }

    /**
     * @param string|null $content_type
     * @return ListingPhotoEntity
     */
    public function setContentType(?string $content_type): ListingPhotoEntity
    {
        $this->content_type = $content_type;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFilename(): ?string
    {
        return $this->filename;
    }

    /**
     * @param string|null $filename
     * @return ListingPhotoEntity
     */
    public function setFilename(?string $filename): ListingPhotoEntity
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param string $image
     * @return ListingPhotoEntity
     */
    public function setImage(string $image): ListingPhotoEntity
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCaption(): ?string
    {
        return $this->caption;
    }

    /**
     * @param string|null $caption
     * @return ListingPhotoEntity
     */
    public function setCaption(?string $caption): ListingPhotoEntity
    {
        $this->caption = $caption;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getSortOrder(): ?int
    {
        return $this->sort_order;
    }

    /**
     * @param int|null $sort_order
     * @return ListingPhotoEntity
     */
    public function setSortOrder(?int $sort_order): ListingPhotoEntity
    {
        $this->sort_order = $sort_order;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getThumbnailUrl(): ?string
    {
        return $this->thumbnail_url;
    }

    /**
     * @return string|null
     */
    public function getSmallUrl(): ?string
    {
        return $this->small_url;
    }

    /**
     * @return string|null
     */
    public function getExtraMediumUrl(): ?string
    {
        return $this->extra_medium_url;
    }

    /**
     * @return string|null
     */
    public function getLargeUrl(): ?string
    {
        return $this->large_url;
    }

    /**
     * @return string|null
     */
    public function getExtraLargeUrl(): ?string
    {
        return $this->extra_large_url;
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getListingIdStr(): ?string
    {
        return $this->listing_id_str;
    }
}
