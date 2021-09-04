<?php

namespace Amarkhai\AirbnbSdk\Entities;

use Amarkhai\AirbnbSdk\Exceptions\EmptyRequiredFieldsException;

/**
 * The entity for representation Listing Descriptions
 */
class ListingDescriptionEntity
{
    private const REQUIRED_FIELDS = [];

    private const FIELDS_EXCLUDED_FROM_EXPORT = [
        'id',
        'id_str',
        'description',
        'machine_translated',
    ];

    /**
     * Listing ID.
     * @var int|null
     */
    private $listing_id;
    /**
     * String representation of the id
     * @var string|null
     */
    private $listing_id_str;
    /**
     * The locale of this response/translation. Must be a supported locale.
     * @var string|null
     */
    private $locale;
    /**
     * The entire listing description. This field is not updatable and is aggregated from the following fields: space,
     * access, interaction, neighborhood_overview, transit, and notes.
     * @var string|null
     */
    private $description;
    /**
     * Indicates if the response description field is machine translated. (Deprecated)
     * @var string|null
     */
    private $machine_translated;
    /**
     * If a name was specified using the Listings API, this name will overwrite it.
     * If a name is specified in future Listings API requests, this name will be overwritten too. Please do not update
     * the name by using Listings API. Otherwise, this name may be overwritten unexpectedly.
     * @var string|null
     */
    private $name;
    /**
     * Should cover the major features of the space and neighborhood in 500 characters or less.
     * @var string|null
     */
    private $summary;
    /**
     * what makes it unique, and how many people does it comfortably fit.
     * @var string|null
     */
    private $space;
    /**
     * Information about what parts of the space the guests will be able to access.
     * @var string|null
     */
    private $access;
    /**
     * How much the Host will interact with the guests, and if the Host will be present during the guest stay.
     * @var string|null
     */
    private $interaction;
    /**
     * Information about the neighborhood and surrounding region. Suggestions about what guests should experience & do.
     * @var string|null
     */
    private $neighborhood_overview;
    /**
     * Information on getting to the property. Is there convenient public transit? Is parking included with the listing
     * or nearby? How does the guest get to the listing from the airport?
     * @var string|null
     */
    private $transit;
    /**
     * Any additional details for the guest to know.
     * @var string|null
     */
    private $notes;
    /**
     * Instructions for guests on how to behave. Should also include whether pets are allowed and if there are rules
     * about smoking.
     * @var string|null
     */
    private $house_rules;

    /**
     * @param bool $withoutNulls
     * @return array
     */
    public function exportAsArray(bool $withoutNulls = false): array
    {
        $listingDescriptionData = get_object_vars($this);

        foreach (self::FIELDS_EXCLUDED_FROM_EXPORT as $field) {
            unset($listingDescriptionData[$field]);
        }

        if ($withoutNulls) {
            foreach ($listingDescriptionData as $fieldName => $value) {
                if (is_null($value)) {
                    unset($listingDescriptionData[$fieldName]);
                }
            }
        }

        return $listingDescriptionData;
    }

    /**
     * @param array $fields
     * @return ListingDescriptionEntity
     */
    public function fillByArray(array $fields): ListingDescriptionEntity
    {
        foreach ($fields as $name => $value) {
            $this->$name = $value;
        }

        return $this;
    }

    /**
     * @param array $data
     * @return ListingDescriptionEntity
     * @throws EmptyRequiredFieldsException
     */
    public static function createByArray(array $data): ListingDescriptionEntity
    {
        foreach (self::REQUIRED_FIELDS as $field) {
            if (!isset($data[$field])) {
                throw new EmptyRequiredFieldsException(sprintf(
                    'Some of required fields is absent: %s',
                    implode(',', self::REQUIRED_FIELDS)
                ));
            }
        }

        $description = new self();

        $description->fillByArray($data);

        return $description;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return ListingDescriptionEntity
     */
    public function setName(?string $name): ListingDescriptionEntity
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getSummary(): ?string
    {
        return $this->summary;
    }

    /**
     * @param string|null $summary
     * @return ListingDescriptionEntity
     */
    public function setSummary(?string $summary): ListingDescriptionEntity
    {
        $this->summary = $summary;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSpace(): ?string
    {
        return $this->space;
    }

    /**
     * @param string|null $space
     * @return ListingDescriptionEntity
     */
    public function setSpace(?string $space): ListingDescriptionEntity
    {
        $this->space = $space;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAccess(): ?string
    {
        return $this->access;
    }

    /**
     * @param string|null $access
     * @return ListingDescriptionEntity
     */
    public function setAccess(?string $access): ListingDescriptionEntity
    {
        $this->access = $access;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getInteraction(): ?string
    {
        return $this->interaction;
    }

    /**
     * @param string|null $interaction
     * @return ListingDescriptionEntity
     */
    public function setInteraction(?string $interaction): ListingDescriptionEntity
    {
        $this->interaction = $interaction;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNeighborhoodOverview(): ?string
    {
        return $this->neighborhood_overview;
    }

    /**
     * @param string|null $neighborhood_overview
     * @return ListingDescriptionEntity
     */
    public function setNeighborhoodOverview(?string $neighborhood_overview): ListingDescriptionEntity
    {
        $this->neighborhood_overview = $neighborhood_overview;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTransit(): ?string
    {
        return $this->transit;
    }

    /**
     * @param string|null $transit
     * @return ListingDescriptionEntity
     */
    public function setTransit(?string $transit): ListingDescriptionEntity
    {
        $this->transit = $transit;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNotes(): ?string
    {
        return $this->notes;
    }

    /**
     * @param string|null $notes
     * @return ListingDescriptionEntity
     */
    public function setNotes(?string $notes): ListingDescriptionEntity
    {
        $this->notes = $notes;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHouseRules(): ?string
    {
        return $this->house_rules;
    }

    /**
     * @param string|null $house_rules
     * @return ListingDescriptionEntity
     */
    public function setHouseRules(?string $house_rules): ListingDescriptionEntity
    {
        $this->house_rules = $house_rules;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLocale(): ?string
    {
        return $this->locale;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return string|null
     */
    public function getMachineTranslated(): ?string
    {
        return $this->machine_translated;
    }

    /**
     * @return int|null
     */
    public function getListingId(): ?int
    {
        return $this->listing_id;
    }

    /**
     * @return string|null
     */
    public function getListingIdStr(): ?string
    {
        return $this->listing_id_str;
    }

    /**
     * @param string|null $locale
     * @return ListingDescriptionEntity
     */
    public function setLocale(?string $locale): ListingDescriptionEntity
    {
        $this->locale = $locale;
        return $this;
    }
}
