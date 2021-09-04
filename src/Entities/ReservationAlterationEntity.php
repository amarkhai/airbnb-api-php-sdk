<?php

namespace Amarkhai\AirbnbSdk\Entities;

use Amarkhai\AirbnbSdk\Exceptions\EmptyRequiredFieldsException;

/**
 * The entity for the representation Reservation Alterations
 */
class ReservationAlterationEntity
{
    public const STATUS_ACCEPTED = 'ACCEPTED';
    public const STATUS_PENDING = 'PENDING';
    public const STATUS_CANCELED = 'CANCELED';
    public const STATUS_DECLINED = 'DECLINED';
    public const STATUS_VOID = 'VOID';
    public const STATUS_AWAITING_PAYMENT = 'AWAITING_PAYMENT';

    public const INITIATED_BY_HOST = 'host';
    public const INITIATED_BY_GUEST = 'guest';
    public const INITIATED_BY_ADMIN = 'admin';

    private const REQUIRED_FIELDS = [];
    private const FIELDS_EXCLUDED_FROM_EXPORT = [];

    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $id_str;
    /**
     * Confirmation code (10 chars)
     * @var string|null
     */
    private $confirmation_code;
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
     * The time that the guest initiated the alteration. ISO-8601 format
     * @var string|null
     */
    private $created_at;
    /**
     * The time this alteration was last updated. ISO-8601 format
     * @var string|null
     */
    private $updated_at;
    /**
     *
     * @var string|null
     */
    private $response_at;
    /**
     * The status field in the Alterations object can be one of PENDING, ACCEPTED, DECLINED, VOID, CANCELED, or
     * AWAITING_PAYMENT. You can only modify the state of an alteration while it is PENDING.
     * @var string|null
     */
    private $status;
    /**
     * Can be "guest" or "host"
     * @var string
     */
    private $initiated_by;
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
     * Number of nights.
     * @var int|null
     */
    private $nights;
    /**
     * @var array{number_of_adults: int, number_of_children: int, number_of_infants: int}|null
     * number_of_adults - The number of adults
     * number_of_children - The number of children
     * number_of_infants - The number of infants. Infants are not included in the total maximum guest count.
     */
    private $guest_details;
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
     * Deprecated. Use host_fee_base_accurate and host_fee_vat_accurate instead.
     * @var string|null
     * @deprecated
     */
    private $listing_host_fee_accurate;
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
     * The standard fees applied to the reservation.
     * @var array[]|null
     * array like
     * [['fee_type' => string, 'amount_native' => string], ...]
     * fee_type - fee type
     * amount_native - The amount charged in listing's currency.
     */
    private $standard_fees_details;
    /**
     * The breakdown and description of promotions applied to this reservation. Values are provided in USD and the
     * listing's native currency.
     * @var array{promotion_type: string, amount_usd: string, amount_native: string, native_currency: string}|array[]|null
     * promotion_type - The type of the promotion. Promotions are grouped by promotion_type.
     * amount_usd - The amount reduced in USD. Promotions are represented with a negative amount.
     * amount_native - The amount charged in the listing's native currency.
     * native_currency - The listing's native currency.
     */
    private $promotion_details;
    /**
     * The breakdown and description of pricing rules applied to this reservation. Values are provided in USD and the
     * listing's native currency.
     * @var array{pricing_rule_type: string, amount_usd: string, amount_native: string, native_currency: string}|array[]
     * pricing_rule_type - The type of pricing rule.
     * amount_usd - The amount reduced in USD.
     * amount_native - The amount charged in the listing's native currency.
     * native_currency - The listing's native currency.
     */
    private $pricing_rule_details;
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
     * @var array{name: string, tax_type: string, amount_usd: string, amount_native: string, native_currency: string, defined_by: string}|null
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
     * The breakdown and descriptions of the pass through tax amount. Values are provided in USD and listing native
     * currency.
     * @var array{name: string, tax_type: string, amount_usd: string, amount_native: string, native_currency: string, defined_by: string}|null
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
     * The expected tax amount that will be remitted to hosts. Includes taxes from hosts using Occupancy Taxes,
     * calculated at booking time. This amount might change when the payout is made. See
     * pass_through_tax_amount_paid_to_host_accurate for the finalized amount
     * @var string|null
     */
    private $pass_through_tax_expected_amount_accurate;

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
     * @return ReservationAlterationEntity
     */
    public function fillByArray(array $fields): ReservationAlterationEntity
    {
        foreach ($fields as $name => $value) {
            $this->$name = $value;
        }

        return $this;
    }

    /**
     * @param array $data
     * @return ReservationAlterationEntity
     * @throws EmptyRequiredFieldsException
     */
    public static function createByArray(array $data): ReservationAlterationEntity
    {
        foreach (self::REQUIRED_FIELDS as $field) {
            if (!isset($data[$field])) {
                throw new EmptyRequiredFieldsException(sprintf(
                    'Some of required fields is absent: %s',
                    implode(',', self::REQUIRED_FIELDS)
                ));
            }
        }

        $reservationAlteration = new self();

        $reservationAlteration->fillByArray($data);

        return $reservationAlteration;
    }

    /**
     * @param string|null $confirmation_code
     * @return ReservationAlterationEntity
     */
    public function setConfirmationCode(?string $confirmation_code): ReservationAlterationEntity
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
     * @return ReservationAlterationEntity
     */
    public function setCreatedAt(?string $created_at): ReservationAlterationEntity
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
     * @return ReservationAlterationEntity
     */
    public function setUpdatedAt(?string $updated_at): ReservationAlterationEntity
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
     * @param string|null $start_date
     * @return ReservationAlterationEntity
     */
    public function setStartDate(?string $start_date): ReservationAlterationEntity
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
     * @return ReservationAlterationEntity
     */
    public function setEndDate(?string $end_date): ReservationAlterationEntity
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
     * @return ReservationAlterationEntity
     */
    public function setGuestDetails(?array $guest_details): ReservationAlterationEntity
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
     * @param string|null $expected_payout_amount_accurate
     * @return ReservationAlterationEntity
     */
    public function setExpectedPayoutAmountAccurate(?string $expected_payout_amount_accurate): ReservationAlterationEntity
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
     * @return ReservationAlterationEntity
     */
    public function setListingBasePriceAccurate(?string $listing_base_price_accurate): ReservationAlterationEntity
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
     * @return ReservationAlterationEntity
     */
    public function setHostFeeBaseAccurate(?string $host_fee_base_accurate): ReservationAlterationEntity
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
     * @return ReservationAlterationEntity
     */
    public function setHostFeeVatAccurate(?string $host_fee_vat_accurate): ReservationAlterationEntity
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
     * @return ReservationAlterationEntity
     */
    public function setListingHostFeeAccurate(?string $listing_host_fee_accurate): ReservationAlterationEntity
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
     * @param string|null $listing_cleaning_fee_accurate
     * @return ReservationAlterationEntity
     */
    public function setListingCleaningFeeAccurate(?string $listing_cleaning_fee_accurate): ReservationAlterationEntity
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
     * @return ReservationAlterationEntity
     */
    public function setListingCancellationPayoutAccurate(
        ?string $listing_cancellation_payout_accurate
    ): ReservationAlterationEntity {
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
     * @return ReservationAlterationEntity
     */
    public function setListingCancellationHostFeeAccurate(?string $listing_cancellation_host_fee_accurate): ReservationAlterationEntity
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
     * @return ReservationAlterationEntity
     */
    public function setListingId(?int $listing_id): ReservationAlterationEntity
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
     * @return ReservationAlterationEntity
     */
    public function setListingIdStr(?string $listing_id_str): ReservationAlterationEntity
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
     * @param int|null $nights
     * @return ReservationAlterationEntity
     */
    public function setNights(?int $nights): ReservationAlterationEntity
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
     * @param array[]|null $standard_fees_details
     * @return ReservationAlterationEntity
     */
    public function setStandardFeesDetails(?array $standard_fees_details): ReservationAlterationEntity
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
     * @param array|null $promotion_details
     * @return ReservationAlterationEntity
     */
    public function setPromotionDetails(?array $promotion_details): ReservationAlterationEntity
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
     * @return ReservationAlterationEntity
     */
    public function setPricingRuleDetails(array $pricing_rule_details): ReservationAlterationEntity
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
     * @param string|null $expected_payout_amount_before_taxes_accurate
     * @return ReservationAlterationEntity
     */
    public function setExpectedPayoutAmountBeforeTaxesAccurate(?string $expected_payout_amount_before_taxes_accurate): ReservationAlterationEntity
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
     * @return ReservationAlterationEntity
     */
    public function setAirbnbCollectedTaxAmountAccurate(?string $airbnb_collected_tax_amount_accurate): ReservationAlterationEntity
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
     * @return ReservationAlterationEntity
     */
    public function setAirbnbCollectedTaxDetails(?array $airbnb_collected_tax_details): ReservationAlterationEntity
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
     * @return ReservationAlterationEntity
     */
    public function setPassThroughTaxExpectedAmountAccurate(?string $pass_through_tax_expected_amount_accurate): ReservationAlterationEntity
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
     * @return ReservationAlterationEntity
     */
    public function setPassThroughTaxDetails(?array $pass_through_tax_details): ReservationAlterationEntity
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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getIdStr(): string
    {
        return $this->id_str;
    }

    /**
     * @param string|null $response_at
     * @return ReservationAlterationEntity
     */
    public function setResponseAt(?string $response_at): ReservationAlterationEntity
    {
        $this->response_at = $response_at;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getResponseAt(): ?string
    {
        return $this->response_at;
    }

    /**
     * @param string|null $status
     * @return ReservationAlterationEntity
     */
    public function setStatus(?string $status): ReservationAlterationEntity
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string $initiated_by
     * @return ReservationAlterationEntity
     */
    public function setInitiatedBy(string $initiated_by): ReservationAlterationEntity
    {
        $this->initiated_by = $initiated_by;
        return $this;
    }

    /**
     * @return string
     */
    public function getInitiatedBy(): string
    {
        return $this->initiated_by;
    }
}
