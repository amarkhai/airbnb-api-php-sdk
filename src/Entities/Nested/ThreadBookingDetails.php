<?php

namespace Amarkhai\AirbnbSdk\Entities\Nested;

use Amarkhai\AirbnbSdk\Exceptions\EmptyRequiredFieldsException;

/**
 * The entity for the representation Booking Details in Threads
 */
class ThreadBookingDetails
{
    private const REQUIRED_FIELDS = [
        'listing_id_str',
        'checkin_date',
        'checkout_date',
    ];

    private const FIELDS_EXCLUDED_FROM_EXPORT = [];

    /**
     * int64 Listing ID The number ID will be deprecated in the future, use string ID _str field instead.
     * @var string
     */
    private $listing_id;
    /**
     * String representation of the listing_id
     * @var string
     */
    private $listing_id_str;
    /**
     * Listing name
     * @var string|null
     */
    private $listing_name;
    /**
     * Check-in date in iso8601 format.
     * @var string
     */
    private $checkin_date;
    /**
     * Check-out date in iso8601 format.
     * @var string
     */
    private $checkout_date;
    /**
     * Number of nights
     * @var int|null
     */
    private $nights;
    /**
     * Total number of guests
     * @var int|null
     */
    private $number_of_guests;
    /**
     * Total number of adults
     * @var int|null
     */
    private $number_of_adults;
    /**
     * Total number of children
     * @var int|null
     */
    private $number_of_children;
    /**
     * Total number of infants
     * @var int|null
     */
    private $number_of_infants;
    /**
     * Reservation code if present, null otherwise.
     * @var string|null
     */
    private $reservation_confirmation_code;
    /**
     * When the inquiry is considered "not responded to," in iso8601 date/time format. Note that this negatively impacts
     * a host's response rate. The value is null if no response is required.
     * @var string|null
     */
    private $non_response_at;
    /**
     * The amount to be paid out to the host, in the host's currency. Formatted with the recommended ISO-4217 exponent
     * corresponding to the currency.
     * @var string|null
     */
    private $expected_payout_amount_accurate;

    /**
     * ThreadBookingDetails constructor.
     * @param string $listing_id_str
     * @param string $checkin_date
     * @param string $checkout_date
     */
    public function __construct(
        string $listing_id_str,
        string $checkin_date,
        string $checkout_date
    ) {
        $this->listing_id_str = $listing_id_str;
        $this->checkin_date = $checkin_date;
        $this->checkout_date = $checkout_date;
    }

    /**
     * @param bool $withoutNulls
     * @return array
     */
    public function exportAsArray(bool $withoutNulls = false): array
    {
        $bookingDetails = get_object_vars($this);

        foreach (self::FIELDS_EXCLUDED_FROM_EXPORT as $field) {
            unset($bookingDetails[$field]);
        }

        if ($withoutNulls) {
            foreach ($bookingDetails as $fieldName => $value) {
                if (is_null($value)) {
                    unset($bookingDetails[$fieldName]);
                }
            }
        }

        return $bookingDetails;
    }

    /**
     * @param array $fields
     * @return ThreadBookingDetails
     */
    public function fillByArray(array $fields): ThreadBookingDetails
    {
        foreach ($fields as $name => $value) {
            $this->$name = $value;
        }

        return $this;
    }

    /**
     * @param array $data
     * @return ThreadBookingDetails
     * @throws EmptyRequiredFieldsException
     */
    public static function createByArray(array $data): ThreadBookingDetails
    {
        foreach (self::REQUIRED_FIELDS as $field) {
            if (!isset($data[$field])) {
                throw new EmptyRequiredFieldsException(sprintf(
                    'Some of required fields is absent: %s',
                    implode(',', self::REQUIRED_FIELDS)
                ));
            }
        }

        $bookingDetails = new self(
            $data['listing_id_str'],
            $data['checkin_date'],
            $data['checkout_date']
        );

        $bookingDetails->fillByArray($data);

        return $bookingDetails;
    }

    /**
     * @return string|null
     */
    public function getListingName(): ?string
    {
        return $this->listing_name;
    }

    /**
     * @return int|null
     */
    public function getNights(): ?int
    {
        return $this->nights;
    }

    /**
     * @return string|null
     */
    public function getReservationConfirmationCode(): ?string
    {
        return $this->reservation_confirmation_code;
    }

    /**
     * @return string|null
     */
    public function getNonResponseAt(): ?string
    {
        return $this->non_response_at;
    }

    /**
     * @return string|null
     */
    public function getExpectedPayoutAmountAccurate(): ?string
    {
        return $this->expected_payout_amount_accurate;
    }

    /**
     * @return string
     */
    public function getListingId(): string
    {
        return $this->listing_id;
    }

    /**
     * @return string
     */
    public function getListingIdStr(): string
    {
        return $this->listing_id_str;
    }

    /**
     * @return string
     */
    public function getCheckinDate(): string
    {
        return $this->checkin_date;
    }

    /**
     * @return string
     */
    public function getCheckoutDate(): string
    {
        return $this->checkout_date;
    }
}
