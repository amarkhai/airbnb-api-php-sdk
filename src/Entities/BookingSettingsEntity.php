<?php

namespace Amarkhai\AirbnbSdk\Entities;

use Amarkhai\AirbnbSdk\Exceptions\EmptyRequiredFieldsException;

/**
 * The entity for the representation Booking Settings
 */
class BookingSettingsEntity
{
    /**
     * Everyone who meets standard Airbnb requirements can make Instant Book reservations.
     */
    public const INSTANT_BOOKING_ALLOWED_CATEGORY_EVERYONE = 'everyone';

    /**
     * Only guests who have traveled on Airbnb, are recommended by other hosts, and have no negative reviews can make
     * Instant Book reservations.
     */
    public const INSTANT_BOOKING_ALLOWED_CATEGORY_EXPERIENCED = 'experienced';

    /**
     * Only guests with verified government-issued ID can make Instant Book reservations.
     */
    public const INSTANT_BOOKING_ALLOWED_CATEGORY_GOVERNMENT_ID = 'government_id';

    /**
     * Only guests with verified government-issued ID and who have traveled on Airbnb, are recommended by other hosts,
     * and have no negative reviews can make Instant Book reservations.
     */
    public const INSTANT_BOOKING_ALLOWED_CATEGORY_EXP_GUEST_WITH_GOVERNMENT_ID = 'experienced_guest_with_government_id';

    private const REQUIRED_FIELDS = [];

    private const FIELDS_EXCLUDED_FROM_EXPORT = [
        'listing_id',
        'listing_id_str',
        'cancellation_policy_category',
    ];

    public const CHECK_IN_TIME_START_MIN = 8;
    public const CHECK_IN_TIME_START_MAX = 25;
    public const CHECK_IN_TIME_END_MIN = 9;
    public const CHECK_IN_TIME_END_MAX = 26;
    public const CHECK_OUT_TIME_MIN = 0;
    public const CHECK_OUT_TIME_MAX = 23;
    /**
     * Listing ID.
     * @var int|null
     */
    private $listing_id;
    /**
     * String representation of the listing id.
     * @var string|null
     */
    private $listing_id_str;
    /**
     * Cancellation policy for the listings. API only supports some of Airbnb's cancellation policies.
     * @var string|null
     */
    private $cancellation_policy_category;
    /**
     * Contains the cancellation policy related settings.
     * @var array|null
     * array like ["cancellation_policy_category" => string, "non_refundable_price_factor" => float]
     * "cancellation_policy_category" - Cancellation policy for the listings. API only supports some of Airbnb's
     * cancellation policies.
     * "non_refundable_price_factor" - If null, the user cannot select a tiered option. If float (0,1), it is the
     * multiplier for the price if the user accepts the non-refundable cancellation policy.
     * You can not set Non-refundable discounts on Lux listings and listings located in Italy.
     */
    private $cancellation_policy_settings;
    /**
     * Earliest time the guest can check in, indicated as hour "8", "9", "10", ..., "25"or "FLEXIBLE".
     * @var string|null
     */
    private $check_in_time_start;
    /**
     * Latest time the guest can check in, indicated as hour "9", "10", "11", ..., "26"or "FLEXIBLE".
     * @var string|null
     */
    private $check_in_time_end;
    /**
     * Latest time the guest can check out, indicated as hour between 0 and 23.
     * @var int|null
     */
    private $check_out_time;
    /**
     * Defines categories of guests that can make Instant Book requests. Anyone who doesn’t meet these requirements can
     * still send a reservation request.
     * @var string|null
     */
    private $instant_booking_allowed_category;
    /**
     * When a guest books instantly, they’ll see this greeting while they’re booking. Greet the guest and gather info
     * about their trip. Maximum 200 characters.
     * @var string|null
     */
    private $instant_book_welcome_message;
    /**
     * Details guests must know about the home. Set expectations that the guests must agree to before booking.
     * @var array[]|null
     * array like [["type" => string, "added_details" => string], ...]
     * type - The type of the restriction the guests must agree to. Must be one of Listing Expectation Types.
     * added_details - Provide optional details. Max 300 characters.
     */
    private $listing_expectations_for_guests;
    /**
     * Rules guests must agree to before they book.
     * @var array|null
     * array like
     * ["allows_children_as_host" => bool, "allows_infants_as_host" => bool, "children_not_allowed_details" => string,
     * "allows_smoking_as_host" => bool, "allows_pets_as_host" => bool, "allows_events_as_host" => bool,
     * "foreigner_eligible_status_as_host" => int]
     *
     * allows_children_as_host - Is listing suitable for children (2-12 years)?
     * allows_infants_as_host - Is listing suitable for infants (under 2 years)?
     * children_not_allowed_details - If you selected false for any of the above, this field is required to provide
     *   details about why the place is not suitable for children.
     * allows_smoking_as_host - Is smoking allowed?
     * allows_pets_as_host - Are pets allowed?
     * allows_events_as_host - Are parties or events allowed?
     * foreigner_eligible_status_as_host - This field is only applicable to some listings within China. Are you eligible
     *   to host foreigner (non-citizen) guests? The default is yes (0). Specify 1 only if you can not.
     */
    private $guest_controls;
    /**
     * Optional variable to help migrate to no response version of this api. Must be set to true
     * @var bool|null
     */
    private $skip_response;

    /**
     * @param bool $withoutNulls
     * @return array
     */
    public function exportAsArray(bool $withoutNulls = false): array
    {
        $bookingSettings = get_object_vars($this);

        foreach (self::FIELDS_EXCLUDED_FROM_EXPORT as $field) {
            unset($bookingSettings[$field]);
        }

        // remove "NOT_SELECTED" (Airbnb set this value for some fields as default)
        foreach ($bookingSettings as $fieldName => $value) {
            if ($value === 'NOT_SELECTED') {
                $bookingSettings[$fieldName] = null;
            }
        }

        // remove empty fields from 'guest_control'
        if (isset($bookingSettings['guest_controls'])) {
            foreach ($bookingSettings['guest_controls'] as $guestControlFieldName => $guestControlValue) {
                if (is_null($guestControlValue)) {
                    unset($bookingSettings['guest_controls'][$guestControlFieldName]);
                }
            }
            if (count($bookingSettings['guest_controls']) === 0) {
                unset($bookingSettings['guest_controls']);
            }
        }

        if ($withoutNulls) {
            foreach ($bookingSettings as $fieldName => $value) {
                if (is_null($value)) {
                    unset($bookingSettings[$fieldName]);
                }
            }
        }

        return $bookingSettings;
    }

    /**
     * @param array $fields
     * @return BookingSettingsEntity
     */
    public function fillByArray(array $fields): BookingSettingsEntity
    {
        foreach ($fields as $name => $value) {
            $this->$name = $value;
        }

        return $this;
    }

    /**
     * @param array $data
     * @return BookingSettingsEntity
     * @throws EmptyRequiredFieldsException
     */
    public static function createByArray(array $data): BookingSettingsEntity
    {
        foreach (self::REQUIRED_FIELDS as $field) {
            if (!isset($data[$field])) {
                throw new EmptyRequiredFieldsException(sprintf(
                    'Some of required fields is absent: %s',
                    implode(',', self::REQUIRED_FIELDS)
                ));
            }
        }

        $bookingSettings = new self();

        $bookingSettings->fillByArray($data);

        return $bookingSettings;
    }

    /**
     * @param array|null $cancellation_policy_settings
     * @return BookingSettingsEntity
     */
    public function setCancellationPolicySettings(?array $cancellation_policy_settings): BookingSettingsEntity
    {
        $this->cancellation_policy_settings = $cancellation_policy_settings;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getCancellationPolicySettings(): ?array
    {
        return $this->cancellation_policy_settings;
    }

    /**
     * @param string|null $check_in_time_start
     * @return BookingSettingsEntity
     */
    public function setCheckInTimeStart(?string $check_in_time_start): BookingSettingsEntity
    {
        $this->check_in_time_start = $check_in_time_start;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCheckInTimeStart(): ?string
    {
        return $this->check_in_time_start;
    }

    /**
     * @param string|null $check_in_time_end
     * @return BookingSettingsEntity
     */
    public function setCheckInTimeEnd(?string $check_in_time_end): BookingSettingsEntity
    {
        $this->check_in_time_end = $check_in_time_end;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCheckInTimeEnd(): ?string
    {
        return $this->check_in_time_end;
    }

    /**
     * @param int|null $check_out_time
     * @return BookingSettingsEntity
     */
    public function setCheckOutTime(?int $check_out_time): BookingSettingsEntity
    {
        $this->check_out_time = $check_out_time;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCheckOutTime(): ?int
    {
        return $this->check_out_time;
    }

    /**
     * @param string|null $instant_booking_allowed_category
     * @return BookingSettingsEntity
     */
    public function setInstantBookingAllowedCategory(?string $instant_booking_allowed_category): BookingSettingsEntity
    {
        $this->instant_booking_allowed_category = $instant_booking_allowed_category;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getInstantBookingAllowedCategory(): ?string
    {
        return $this->instant_booking_allowed_category;
    }

    /**
     * @param string|null $instant_book_welcome_message
     * @return BookingSettingsEntity
     */
    public function setInstantBookWelcomeMessage(?string $instant_book_welcome_message): BookingSettingsEntity
    {
        $this->instant_book_welcome_message = $instant_book_welcome_message;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getInstantBookWelcomeMessage(): ?string
    {
        return $this->instant_book_welcome_message;
    }

    /**
     * @param array[]|null $listing_expectations_for_guests
     * @return BookingSettingsEntity
     */
    public function setListingExpectationsForGuests(?array $listing_expectations_for_guests): BookingSettingsEntity
    {
        $this->listing_expectations_for_guests = $listing_expectations_for_guests;
        return $this;
    }

    /**
     * @return array[]|null
     */
    public function getListingExpectationsForGuests(): ?array
    {
        return $this->listing_expectations_for_guests;
    }

    /**
     * @param array|null $guest_controls
     * @return BookingSettingsEntity
     */
    public function setGuestControls(?array $guest_controls): BookingSettingsEntity
    {
        $this->guest_controls = $guest_controls;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getGuestControls(): ?array
    {
        return $this->guest_controls;
    }

    /**
     * @param bool|null $skip_response
     * @return BookingSettingsEntity
     */
    public function setSkipResponse(?bool $skip_response): BookingSettingsEntity
    {
        $this->skip_response = $skip_response;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getSkipResponse(): ?bool
    {
        return $this->skip_response;
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
     * @return string|null
     */
    public function getCancellationPolicyCategory(): ?string
    {
        return $this->cancellation_policy_category;
    }
}
