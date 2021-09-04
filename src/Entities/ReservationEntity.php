<?php

namespace Amarkhai\AirbnbSdk\Entities;

use Amarkhai\AirbnbSdk\Exceptions\EmptyRequiredFieldsException;

/**
 * The entity for representation Reservations
 */
class ReservationEntity
{
    public const STATUS_TYPE_CANCELLED_BY_HOST = 'cancelled_by_host';
    public const STATUS_TYPE_CANCELLED_BY_GUEST = 'cancelled_by_guest';
    public const STATUS_TYPE_CANCELLED_BY_ADMIN = 'cancelled_by_admin';
    public const STATUS_TYPE_ACCEPT = 'accept';
    /**
     *
     */
    private const REQUIRED_FIELDS = [];
    /**
     *
     */
    private const FIELDS_EXCLUDED_FROM_EXPORT = [];

    /**
     * The cancellation policy category must be one of the options supported by the API.
     * @var string|null
     */
    private $cancellation_policy_category;

    /**
     * Confirmation code (10 chars)
     * @var string|null
     */
    private $confirmation_code;

    /**
     * The time that the guest initiated the reservation / entered the checkout page. ISO-8601 format
     * @var string|null
     */
    private $created_at;

    /**
     * The time this reservation was last updated. ISO-8601 format
     * @var string|null
     */
    private $updated_at;

    /**
     * The time the reservation was confirmed / entered the accepted state. ISO-8601 format
     * @var string|null
     */
    private $booked_at;

    /**
     * The beginning of the reservation. ISO-8601 format
     * @var string|null
     */
    private $start_date;

    /**
     * The end of the reservation. ISO-8601 format
     * @var string|null
     */
    private $end_date;

    /**
     * @var array|null
     * array like
     * ['number_of_adults' => int, 'number_of_children' => int, 'number_of_infants' => int]
     * number_of_adults - The number of adults
     * number_of_children - The number of children
     * number_of_infants - The number of infants. Infants are not included in the total maximum guest count.
     */
    private $guest_details;

    /**
     * Anonymized guest email.
     * @var string|null
     */
    private $guest_email;

    /**
     * Guest's first name
     * @var string|null
     */
    private $guest_first_name;

    /**
     * Guest's last name
     * @var string|null
     */
    private $guest_last_name;

    /**
     * Guest's Airbnb ID
     * @var int|null
     */
    private $guest_id;

    /**
     * Array of Guest's phone numbers
     * @var string[]|null
     */
    private $guest_phone_numbers;

    /**
     * Guest's preferred locale.
     * @var string|null
     */
    private $guest_preferred_locale;

    /**
     * The currency of the amount this in which reservation is quoted.
     * @var string|null
     */
    private $host_currency;

    /**
     * Host's Airbnb ID
     * @var int|null
     */
    private $host_id;

    /**
     * Amount paid to Host for reservation, in Host's currency. ISO 4217 format
     * @var string|null
     */
    private $expected_payout_amount_accurate;

    /**
     * Reservation price without fees. ISO 4217 format
     * @var string|null
     */
    private $listing_base_price_accurate;

    /**
     * Airbnb service fee charged to host without VAT. ISO 4217 format
     * @var string|null
     */
    private $host_fee_base_accurate;

    /**
     * The amount of VAT on the Airbnb service fee charged to host. ISO 4217 format
     * @var string|null
     */
    private $host_fee_vat_accurate;

    /**
     * Deprecated. Use host_fee_base_accurate and host_fee_vat_accurate instead.
     * @var string|null
     * @deprecated
     */
    private $listing_host_fee_accurate;

    /**
     * Amount of security deposit. ISO 4217 format
     * @var string|null
     */
    private $listing_security_price_accurate;

    /**
     * Amount of cleaning fee. ISO 4217 format
     * @var string|null
     */
    private $listing_cleaning_fee_accurate;

    /**
     * Amount paid to the Host in case of cancellation. Defaults to 0 unless the reservation was cancelled. If
     * cancelled by Host, this is 0. ISO 4217 format
     * @var string|null
     */
    private $listing_cancellation_payout_accurate;

    /**
     * The Host fee paid to Airbnb if reservation is canceled. If canceled by host, this value is 0.
     * @var string|null
     */
    private $listing_cancellation_host_fee_accurate;

    /**
     * Listing's Airbnb ID The number ID will be deprecated in the future, use string ID _str field instead.
     * @var int|null
     */
    private $listing_id;

    /**
     * String representation of the listing_id
     * @var string|null
     */
    private $listing_id_str;

    /**
     * The id of the relevant Special Offer or pre-approval. If none, this vaue is null.
     * @var int|null
     */
    private $special_offer_id;

    /**
     * Number of nights.
     * @var int|null
     */
    private $nights;

    /**
     * Deprecated. Use guest_details instead.
     * @var int|null
     */
    private $number_of_guests;

    /**
     * The status of this reservation at the time it was retrieved.
     * @var string|null
     */
    private $status_type;

    /**
     * The standard fees applied to the reservation.
     * @var array[]|null
     * array like
     * [['fee_type' => string, 'amount_native' => string], ...]
     * fee_type - fee type
     * amount_native - The amount charged in listing's currency.
     */
    private $standard_fees_details;

    /**
     * ID of the message thread asscoicated with reservation to use for Messaging API. Information about when and why
     * this field may be null can be found here. The number ID will be deprecated in the future, use string ID _str
     * field instead.
     * @var int|null
     */
    private $thread_id;

    /**
     * String representation of the thread_id field.
     * @var string|null
     */
    private $thread_id_str;

    /**
     * Identical to the thread_id field, provided for a previous migration. The number ID will be deprecated in the
     * future, use string ID _str field instead
     * @var int|null
     */
    private $thread_id_migration;

    /**
     * String representation of the thread_id_migration field.
     * @var string|null
     */
    private $thread_id_migration_str;

    /**
     * The cumulative sum of all payouts (consolidated of past and current) that have been released to the Host.
     * @var string|null
     */
    private $total_paid_amount_accurate;

    /**
     * The breakdown and description of promotions applied to this reservation. Values are provided in USD and the
     * listing's native currency.
     * @var array|null
     * array like
     * promotion_type - The type of the promotion. Promotions are grouped by promotion_type.
     * amount_usd - The amount reduced in USD. Promotions are represented with a negative amount.
     * amount_native - The amount charged in the listing's native currency.
     * native_currency - The listing's native currency.
     */
    private $promotion_details;

    /**
     * The breakdown and description of pricing rules applied to this reservation. Values are provided in USD and the
     * listing's native currency.
     * @var array
     * array like
     * pricing_rule_type - The type of pricing rule.
     * amount_usd - The amount reduced in USD.
     * amount_native - The amount charged in the listing's native currency.
     * native_currency - The listing's native currency.
     */
    private $pricing_rule_details;

    /**
     * If the value of this field is null, this reservation is not part of the Frontline program and the 3-day block
     * does not apply. Any other value is how many days were added to the original booking window. For more details,
     * see 3-Day Booking Window Extension.
     * @var int|null
     */
    private $cleanup_days;

    /**
     * The start of check in date and time window of the reservation. ISO-8601 format
     * @var string|null
     */
    private $check_in_datetime;

    /**
     * The end of check in date and time window of the reservation. ISO-8601 format
     * @var string|null
     */
    private $check_in_ends_at_datetime;

    /**
     * The check out date and time of the reservation. ISO-8601 format
     * @var string|null
     */
    private $check_out_datetime;

    /**
     * The local time zone of the listing
     * @var string|null
     */
    private $time_zone;

    /**
     * The apt info of the listing, if applicable
     * @var string|null
     */
    private $apt;

    /**
     * Airbnb ID for property listing The number ID will be deprecated in the future, use string ID _str field instead.
     * @var int|null
     */
    private $property_id;

    /**
     * String representation of the property_id
     * @var string|null
     */
    private $property_id_str;

    /**
     * Airbnb Rate Plan ID
     * @var int|null
     */
    private $rate_plan_id;

    /**
     * The amount of the payout before taxes and fees, generally referred to net rate.
     * @var string|null
     */
    private $expected_payout_amount_before_taxes_accurate;

    /**
     * The tax amount that Airbnb has collected and will remit directly. ISO 4217 format. This value appears in the
     * host's preferred currency.
     * @var string|null
     */
    private $airbnb_collected_tax_amount_accurate;

    /**
     * The breakdown and descriptions of the Airbnb collected tax amount. Values are provided in USD and listing native
     * currency.
     * @var array|null
     *
     * array like
     * ['name': string, 'tax_type': string, 'amount_usd': string, 'amount_native': string, 'native_currency': string,
     * 'defined_by': string]
     *
     * name - The name of the tax.
     * tax_type - For Airbnb collected taxes.
     * amount_usd - The amount charged in USD.
     * amount_native - The amount charged in the listing's native currency.
     * native_currency - The listing's native currency.
     * defined_by - The entity which defined the tax. One of HOST or AIRBNB.
     */
    private $airbnb_collected_tax_details;

    /**
     * The expected tax amount that will be remitted to hosts. Includes taxes from hosts using Occupancy Taxes,
     * calculated at booking time. This amount might change when the payout is made. See
     * pass_through_tax_amount_paid_to_host_accurate for the finalized amount
     * @var string|null
     */
    private $pass_through_tax_expected_amount_accurate;

    /**
     * The breakdown and descriptions of the pass through tax amount. Values are provided in USD and listing native
     * currency.
     * @var array|null
     *
     * array like
     * ['name': string, 'tax_type': string, 'amount_usd': string, 'amount_native': string, 'native_currency': string,
     * 'defined_by': string]
     *
     * name - The name of the tax.
     * tax_type - For pass through taxes.
     * amount_usd - The amount charged in USD.
     * amount_native - The amount charged in the listing's native currency.
     * native_currency - The listing's native currency.
     * defined_by - The entity which defined the tax. One of HOST or AIRBNB.
     */
    private $pass_through_tax_details;

    /**
     * The tax amount passed back to hosts who are using pass through Occupancy Taxes. This is the finalized amount
     * released in the payout and must be remitted to the appropriate tax authorities.
     * @var string|null
     */
    private $pass_through_tax_amount_paid_to_host_accurate;

    /**
     * Deprecated. Use airbnb_collected_tax_amount_accurate instead.
     * @var string|null
     * @deprecated
     */
    private $transient_occupancy_tax_paid_amount_accurate;

    /**
     * Deprecated. Use airbnb_collected_tax_details and pass_through_tax_details instead.
     * @var array|null
     * @deprecated
     *
     * array like
     * ['name': string, 'tax_type': string, 'amount_usd': string, 'amount_native': string, 'native_currency': string,
     * 'defined_by': string]
     *
     * name - Deprecated
     * tax_type - Deprecated
     * amount_usd - Deprecated
     * amount_native - Deprecated
     * native_currency - Deprecated
     * defined_by - Deprecated
     */
    private $transient_occupancy_tax_details;

    /**
     * Deprecated. Use pass_through_tax_amount_paid_to_host_accurate instead.
     * @var string|null
     * @deprecated
     */
    private $occupancy_tax_amount_paid_to_host_accurate;

    /**
     * @param bool $withoutNulls
     * @return array
     */
    public function exportAsArray(bool $withoutNulls = false): array
    {
        $reservation = get_object_vars($this);

        foreach (self::FIELDS_EXCLUDED_FROM_EXPORT as $field) {
            unset($reservation[$field]);
        }

        if ($withoutNulls) {
            foreach ($reservation as $fieldName => $value) {
                if (is_null($value)) {
                    unset($reservation[$fieldName]);
                }
            }
        }

        return $reservation;
    }

    /**
     * @param array $fields
     * @return ReservationEntity
     */
    public function fillByArray(array $fields): ReservationEntity
    {
        foreach ($fields as $name => $value) {
            $this->$name = $value;
        }

        return $this;
    }

    /**
     * @param array $data
     * @return ReservationEntity
     * @throws EmptyRequiredFieldsException
     */
    public static function createByArray(array $data): ReservationEntity
    {
        foreach (self::REQUIRED_FIELDS as $field) {
            if (!isset($data[$field])) {
                throw new EmptyRequiredFieldsException(sprintf(
                    'Some of required fields is absent: %s',
                    implode(',', self::REQUIRED_FIELDS)
                ));
            }
        }

        $reservation = new self();

        $reservation->fillByArray($data);

        return $reservation;
    }

    /**
     * @param string|null $cancellation_policy_category
     * @return ReservationEntity
     */
    public function setCancellationPolicyCategory(?string $cancellation_policy_category): ReservationEntity
    {
        $this->cancellation_policy_category = $cancellation_policy_category;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCancellationPolicyCategory(): ?string
    {
        return $this->cancellation_policy_category;
    }

    /**
     * @param string|null $confirmation_code
     * @return ReservationEntity
     */
    public function setConfirmationCode(?string $confirmation_code): ReservationEntity
    {
        $this->confirmation_code = $confirmation_code;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getConfirmationCode(): ?string
    {
        return $this->confirmation_code;
    }

    /**
     * @param string|null $created_at
     * @return ReservationEntity
     */
    public function setCreatedAt(?string $created_at): ReservationEntity
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }

    /**
     * @param string|null $updated_at
     * @return ReservationEntity
     */
    public function setUpdatedAt(?string $updated_at): ReservationEntity
    {
        $this->updated_at = $updated_at;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updated_at;
    }

    /**
     * @param string|null $booked_at
     * @return ReservationEntity
     */
    public function setBookedAt(?string $booked_at): ReservationEntity
    {
        $this->booked_at = $booked_at;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBookedAt(): ?string
    {
        return $this->booked_at;
    }

    /**
     * @param string|null $start_date
     * @return ReservationEntity
     */
    public function setStartDate(?string $start_date): ReservationEntity
    {
        $this->start_date = $start_date;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getStartDate(): ?string
    {
        return $this->start_date;
    }

    /**
     * @param string|null $end_date
     * @return ReservationEntity
     */
    public function setEndDate(?string $end_date): ReservationEntity
    {
        $this->end_date = $end_date;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEndDate(): ?string
    {
        return $this->end_date;
    }

    /**
     * @param array|null $guest_details
     * @return ReservationEntity
     */
    public function setGuestDetails(?array $guest_details): ReservationEntity
    {
        $this->guest_details = $guest_details;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getGuestDetails(): ?array
    {
        return $this->guest_details;
    }

    /**
     * @param string|null $guest_email
     * @return ReservationEntity
     */
    public function setGuestEmail(?string $guest_email): ReservationEntity
    {
        $this->guest_email = $guest_email;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getGuestEmail(): ?string
    {
        return $this->guest_email;
    }

    /**
     * @param string|null $guest_first_name
     * @return ReservationEntity
     */
    public function setGuestFirstName(?string $guest_first_name): ReservationEntity
    {
        $this->guest_first_name = $guest_first_name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getGuestFirstName(): ?string
    {
        return $this->guest_first_name;
    }

    /**
     * @param int|null $guest_id
     * @return ReservationEntity
     */
    public function setGuestId(?int $guest_id): ReservationEntity
    {
        $this->guest_id = $guest_id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getGuestId(): ?int
    {
        return $this->guest_id;
    }

    /**
     * @param string[]|null $guest_phone_numbers
     * @return ReservationEntity
     */
    public function setGuestPhoneNumbers(?array $guest_phone_numbers): ReservationEntity
    {
        $this->guest_phone_numbers = $guest_phone_numbers;
        return $this;
    }

    /**
     * @return string[]|null
     */
    public function getGuestPhoneNumbers(): ?array
    {
        return $this->guest_phone_numbers;
    }

    /**
     * @param string|null $guest_preferred_locale
     * @return ReservationEntity
     */
    public function setGuestPreferredLocale(?string $guest_preferred_locale): ReservationEntity
    {
        $this->guest_preferred_locale = $guest_preferred_locale;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getGuestPreferredLocale(): ?string
    {
        return $this->guest_preferred_locale;
    }

    /**
     * @param string|null $host_currency
     * @return ReservationEntity
     */
    public function setHostCurrency(?string $host_currency): ReservationEntity
    {
        $this->host_currency = $host_currency;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHostCurrency(): ?string
    {
        return $this->host_currency;
    }

    /**
     * @param int|null $host_id
     * @return ReservationEntity
     */
    public function setHostId(?int $host_id): ReservationEntity
    {
        $this->host_id = $host_id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getHostId(): ?int
    {
        return $this->host_id;
    }

    /**
     * @param string|null $expected_payout_amount_accurate
     * @return ReservationEntity
     */
    public function setExpectedPayoutAmountAccurate(?string $expected_payout_amount_accurate): ReservationEntity
    {
        $this->expected_payout_amount_accurate = $expected_payout_amount_accurate;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getExpectedPayoutAmountAccurate(): ?string
    {
        return $this->expected_payout_amount_accurate;
    }

    /**
     * @param string|null $listing_base_price_accurate
     * @return ReservationEntity
     */
    public function setListingBasePriceAccurate(?string $listing_base_price_accurate): ReservationEntity
    {
        $this->listing_base_price_accurate = $listing_base_price_accurate;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getListingBasePriceAccurate(): ?string
    {
        return $this->listing_base_price_accurate;
    }

    /**
     * @param string|null $host_fee_base_accurate
     * @return ReservationEntity
     */
    public function setHostFeeBaseAccurate(?string $host_fee_base_accurate): ReservationEntity
    {
        $this->host_fee_base_accurate = $host_fee_base_accurate;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHostFeeBaseAccurate(): ?string
    {
        return $this->host_fee_base_accurate;
    }

    /**
     * @param string|null $host_fee_vat_accurate
     * @return ReservationEntity
     */
    public function setHostFeeVatAccurate(?string $host_fee_vat_accurate): ReservationEntity
    {
        $this->host_fee_vat_accurate = $host_fee_vat_accurate;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHostFeeVatAccurate(): ?string
    {
        return $this->host_fee_vat_accurate;
    }

    /**
     * @deprecated
     * @param string|null $listing_host_fee_accurate
     * @return ReservationEntity
     */
    public function setListingHostFeeAccurate(?string $listing_host_fee_accurate): ReservationEntity
    {
        $this->listing_host_fee_accurate = $listing_host_fee_accurate;
        return $this;
    }

    /**
     * @deprecated
     * @return string|null
     */
    public function getListingHostFeeAccurate(): ?string
    {
        return $this->listing_host_fee_accurate;
    }

    /**
     * @param string|null $listing_security_price_accurate
     * @return ReservationEntity
     */
    public function setListingSecurityPriceAccurate(?string $listing_security_price_accurate): ReservationEntity
    {
        $this->listing_security_price_accurate = $listing_security_price_accurate;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getListingSecurityPriceAccurate(): ?string
    {
        return $this->listing_security_price_accurate;
    }

    /**
     * @param string|null $listing_cleaning_fee_accurate
     * @return ReservationEntity
     */
    public function setListingCleaningFeeAccurate(?string $listing_cleaning_fee_accurate): ReservationEntity
    {
        $this->listing_cleaning_fee_accurate = $listing_cleaning_fee_accurate;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getListingCleaningFeeAccurate(): ?string
    {
        return $this->listing_cleaning_fee_accurate;
    }

    /**
     * @param string|null $listing_cancellation_payout_accurate
     * @return ReservationEntity
     */
    public function setListingCancellationPayoutAccurate(
        ?string $listing_cancellation_payout_accurate
    ): ReservationEntity {
        $this->listing_cancellation_payout_accurate = $listing_cancellation_payout_accurate;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getListingCancellationPayoutAccurate(): ?string
    {
        return $this->listing_cancellation_payout_accurate;
    }

    /**
     * @param string|null $listing_cancellation_host_fee_accurate
     * @return ReservationEntity
     */
    public function setListingCancellationHostFeeAccurate(?string $listing_cancellation_host_fee_accurate): ReservationEntity
    {
        $this->listing_cancellation_host_fee_accurate = $listing_cancellation_host_fee_accurate;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getListingCancellationHostFeeAccurate(): ?string
    {
        return $this->listing_cancellation_host_fee_accurate;
    }

    /**
     * @param int|null $listing_id
     * @deprecated
     * @return ReservationEntity
     */
    public function setListingId(?int $listing_id): ReservationEntity
    {
        $this->listing_id = $listing_id;
        return $this;
    }

    /**
     * @deprecated
     * @return int|null
     */
    public function getListingId(): ?int
    {
        return $this->listing_id;
    }

    /**
     * @param string|null $listing_id_str
     * @return ReservationEntity
     */
    public function setListingIdStr(?string $listing_id_str): ReservationEntity
    {
        $this->listing_id_str = $listing_id_str;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getListingIdStr(): ?string
    {
        return $this->listing_id_str;
    }

    /**
     * @param int|null $special_offer_id
     * @return ReservationEntity
     */
    public function setSpecialOfferId(?int $special_offer_id): ReservationEntity
    {
        $this->special_offer_id = $special_offer_id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getSpecialOfferId(): ?int
    {
        return $this->special_offer_id;
    }

    /**
     * @param int|null $nights
     * @return ReservationEntity
     */
    public function setNights(?int $nights): ReservationEntity
    {
        $this->nights = $nights;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getNights(): ?int
    {
        return $this->nights;
    }

    /**
     * @param int|null $number_of_guests
     * @return ReservationEntity
     */
    public function setNumberOfGuests(?int $number_of_guests): ReservationEntity
    {
        $this->number_of_guests = $number_of_guests;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getNumberOfGuests(): ?int
    {
        return $this->number_of_guests;
    }

    /**
     * @param string|null $status_type
     * @return ReservationEntity
     */
    public function setStatusType(?string $status_type): ReservationEntity
    {
        $this->status_type = $status_type;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getStatusType(): ?string
    {
        return $this->status_type;
    }

    /**
     * @param array[]|null $standard_fees_details
     * @return ReservationEntity
     */
    public function setStandardFeesDetails(?array $standard_fees_details): ReservationEntity
    {
        $this->standard_fees_details = $standard_fees_details;
        return $this;
    }

    /**
     * @return array[]|null
     */
    public function getStandardFeesDetails(): ?array
    {
        return $this->standard_fees_details;
    }

    /**
     * @param int|null $thread_id
     * @return ReservationEntity
     */
    public function setThreadId(?int $thread_id): ReservationEntity
    {
        $this->thread_id = $thread_id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getThreadId(): ?int
    {
        return $this->thread_id;
    }

    /**
     * @param string|null $thread_id_str
     * @return ReservationEntity
     */
    public function setThreadIdStr(?string $thread_id_str): ReservationEntity
    {
        $this->thread_id_str = $thread_id_str;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getThreadIdStr(): ?string
    {
        return $this->thread_id_str;
    }

    /**
     * @param int|null $thread_id_migration
     * @return ReservationEntity
     */
    public function setThreadIdMigration(?int $thread_id_migration): ReservationEntity
    {
        $this->thread_id_migration = $thread_id_migration;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getThreadIdMigration(): ?int
    {
        return $this->thread_id_migration;
    }

    /**
     * @param string|null $thread_id_migration_str
     * @return ReservationEntity
     */
    public function setThreadIdMigrationStr(?string $thread_id_migration_str): ReservationEntity
    {
        $this->thread_id_migration_str = $thread_id_migration_str;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getThreadIdMigrationStr(): ?string
    {
        return $this->thread_id_migration_str;
    }

    /**
     * @param string|null $total_paid_amount_accurate
     * @return ReservationEntity
     */
    public function setTotalPaidAmountAccurate(?string $total_paid_amount_accurate): ReservationEntity
    {
        $this->total_paid_amount_accurate = $total_paid_amount_accurate;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTotalPaidAmountAccurate(): ?string
    {
        return $this->total_paid_amount_accurate;
    }

    /**
     * @param array|null $promotion_details
     * @return ReservationEntity
     */
    public function setPromotionDetails(?array $promotion_details): ReservationEntity
    {
        $this->promotion_details = $promotion_details;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getPromotionDetails(): ?array
    {
        return $this->promotion_details;
    }

    /**
     * @param array $pricing_rule_details
     * @return ReservationEntity
     */
    public function setPricingRuleDetails(array $pricing_rule_details): ReservationEntity
    {
        $this->pricing_rule_details = $pricing_rule_details;
        return $this;
    }

    /**
     * @return array
     */
    public function getPricingRuleDetails(): array
    {
        return $this->pricing_rule_details;
    }

    /**
     * @param int|null $cleanup_days
     * @return ReservationEntity
     */
    public function setCleanupDays(?int $cleanup_days): ReservationEntity
    {
        $this->cleanup_days = $cleanup_days;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCleanupDays(): ?int
    {
        return $this->cleanup_days;
    }

    /**
     * @param string|null $check_in_datetime
     * @return ReservationEntity
     */
    public function setCheckInDatetime(?string $check_in_datetime): ReservationEntity
    {
        $this->check_in_datetime = $check_in_datetime;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCheckInDatetime(): ?string
    {
        return $this->check_in_datetime;
    }

    /**
     * @param string|null $check_in_ends_at_datetime
     * @return ReservationEntity
     */
    public function setCheckInEndsAtDatetime(?string $check_in_ends_at_datetime): ReservationEntity
    {
        $this->check_in_ends_at_datetime = $check_in_ends_at_datetime;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCheckInEndsAtDatetime(): ?string
    {
        return $this->check_in_ends_at_datetime;
    }

    /**
     * @param string|null $check_out_datetime
     * @return ReservationEntity
     */
    public function setCheckOutDatetime(?string $check_out_datetime): ReservationEntity
    {
        $this->check_out_datetime = $check_out_datetime;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCheckOutDatetime(): ?string
    {
        return $this->check_out_datetime;
    }

    /**
     * @param string|null $time_zone
     * @return ReservationEntity
     */
    public function setTimeZone(?string $time_zone): ReservationEntity
    {
        $this->time_zone = $time_zone;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTimeZone(): ?string
    {
        return $this->time_zone;
    }

    /**
     * @param string|null $apt
     * @return ReservationEntity
     */
    public function setApt(?string $apt): ReservationEntity
    {
        $this->apt = $apt;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getApt(): ?string
    {
        return $this->apt;
    }

    /**
     * @param int|null $property_id
     * @return ReservationEntity
     */
    public function setPropertyId(?int $property_id): ReservationEntity
    {
        $this->property_id = $property_id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPropertyId(): ?int
    {
        return $this->property_id;
    }

    /**
     * @param string|null $property_id_str
     * @return ReservationEntity
     */
    public function setPropertyIdStr(?string $property_id_str): ReservationEntity
    {
        $this->property_id_str = $property_id_str;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPropertyIdStr(): ?string
    {
        return $this->property_id_str;
    }

    /**
     * @param int|null $rate_plan_id
     * @return ReservationEntity
     */
    public function setRatePlanId(?int $rate_plan_id): ReservationEntity
    {
        $this->rate_plan_id = $rate_plan_id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getRatePlanId(): ?int
    {
        return $this->rate_plan_id;
    }

    /**
     * @param string|null $expected_payout_amount_before_taxes_accurate
     * @return ReservationEntity
     */
    public function setExpectedPayoutAmountBeforeTaxesAccurate(?string $expected_payout_amount_before_taxes_accurate): ReservationEntity
    {
        $this->expected_payout_amount_before_taxes_accurate = $expected_payout_amount_before_taxes_accurate;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getExpectedPayoutAmountBeforeTaxesAccurate(): ?string
    {
        return $this->expected_payout_amount_before_taxes_accurate;
    }

    /**
     * @param string|null $airbnb_collected_tax_amount_accurate
     * @return ReservationEntity
     */
    public function setAirbnbCollectedTaxAmountAccurate(?string $airbnb_collected_tax_amount_accurate): ReservationEntity
    {
        $this->airbnb_collected_tax_amount_accurate = $airbnb_collected_tax_amount_accurate;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAirbnbCollectedTaxAmountAccurate(): ?string
    {
        return $this->airbnb_collected_tax_amount_accurate;
    }

    /**
     * @param array|null $airbnb_collected_tax_details
     * @return ReservationEntity
     */
    public function setAirbnbCollectedTaxDetails(?array $airbnb_collected_tax_details): ReservationEntity
    {
        $this->airbnb_collected_tax_details = $airbnb_collected_tax_details;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getAirbnbCollectedTaxDetails(): ?array
    {
        return $this->airbnb_collected_tax_details;
    }

    /**
     * @param string|null $pass_through_tax_expected_amount_accurate
     * @return ReservationEntity
     */
    public function setPassThroughTaxExpectedAmountAccurate(?string $pass_through_tax_expected_amount_accurate): ReservationEntity
    {
        $this->pass_through_tax_expected_amount_accurate = $pass_through_tax_expected_amount_accurate;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassThroughTaxExpectedAmountAccurate(): ?string
    {
        return $this->pass_through_tax_expected_amount_accurate;
    }

    /**
     * @param array|null $pass_through_tax_details
     * @return ReservationEntity
     */
    public function setPassThroughTaxDetails(?array $pass_through_tax_details): ReservationEntity
    {
        $this->pass_through_tax_details = $pass_through_tax_details;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getPassThroughTaxDetails(): ?array
    {
        return $this->pass_through_tax_details;
    }

    /**
     * @param string|null $pass_through_tax_amount_paid_to_host_accurate
     * @return ReservationEntity
     */
    public function setPassThroughTaxAmountPaidToHostAccurate(?string $pass_through_tax_amount_paid_to_host_accurate): ReservationEntity
    {
        $this->pass_through_tax_amount_paid_to_host_accurate = $pass_through_tax_amount_paid_to_host_accurate;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassThroughTaxAmountPaidToHostAccurate(): ?string
    {
        return $this->pass_through_tax_amount_paid_to_host_accurate;
    }

    /**
     * @param string|null $transient_occupancy_tax_paid_amount_accurate
     * @return ReservationEntity
     * @deprecated
     */
    public function setTransientOccupancyTaxPaidAmountAccurate(?string $transient_occupancy_tax_paid_amount_accurate): ReservationEntity
    {
        $this->transient_occupancy_tax_paid_amount_accurate = $transient_occupancy_tax_paid_amount_accurate;
        return $this;
    }

    /**
     * @return string|null
     * @deprecated
     */
    public function getTransientOccupancyTaxPaidAmountAccurate(): ?string
    {
        return $this->transient_occupancy_tax_paid_amount_accurate;
    }

    /**
     * @param array|null $transient_occupancy_tax_details
     * @return ReservationEntity
     * @deprecated
     */
    public function setTransientOccupancyTaxDetails(?array $transient_occupancy_tax_details): ReservationEntity
    {
        $this->transient_occupancy_tax_details = $transient_occupancy_tax_details;
        return $this;
    }

    /**
     * @return array|null
     * @deprecated
     */
    public function getTransientOccupancyTaxDetails(): ?array
    {
        return $this->transient_occupancy_tax_details;
    }

    /**
     * @param string|null $occupancy_tax_amount_paid_to_host_accurate
     * @return ReservationEntity
     * @deprecated
     */
    public function setOccupancyTaxAmountPaidToHostAccurate(?string $occupancy_tax_amount_paid_to_host_accurate): ReservationEntity
    {
        $this->occupancy_tax_amount_paid_to_host_accurate = $occupancy_tax_amount_paid_to_host_accurate;
        return $this;
    }

    /**
     * @return string|null
     * @deprecated
     */
    public function getOccupancyTaxAmountPaidToHostAccurate(): ?string
    {
        return $this->occupancy_tax_amount_paid_to_host_accurate;
    }

    /**
     * @param string|null $guest_last_name
     * @return ReservationEntity
     */
    public function setGuestLastName(?string $guest_last_name): ReservationEntity
    {
        $this->guest_last_name = $guest_last_name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getGuestLastName(): ?string
    {
        return $this->guest_last_name;
    }
}
