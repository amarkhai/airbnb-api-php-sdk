<?php

namespace Amarkhai\AirbnbSdk\Entities;

use Amarkhai\AirbnbSdk\Exceptions\EmptyRequiredFieldsException;

/**
 * The entities for representation Pricing Settings
 */
class PricingSettingsEntity
{
    /** Seasonal rule adjustment */
    public const RULE_TYPE_SEASONAL_ADJUSTMENT = 'SEASONAL_ADJUSTMENT';
    /** Long-term stay adjustment */
    public const RULE_TYPE_STAYED_AT_LEAST_X_DAYS = 'STAYED_AT_LEAST_X_DAYS';
    /** Last-minute discount */
    public const RULE_TYPE_BOOKED_WITHIN_AT_MOST_X_DAYS = 'BOOKED_WITHIN_AT_MOST_X_DAYS';
    /** Booking ahead discount */
    public const RULE_TYPE_BOOKED_BEYOND_AT_LEAST_X_DAYS = 'BOOKED_BEYOND_AT_LEAST_X_DAYS';
    /**
     * For 'price_change_type' use PERCENT only. The "ABSOLUTE" type has been deprecated.
     */
    public const PRICE_CHANGE_TYPE_PERCENT = 'PERCENT';
    /**
     * For 'price_change_type' use PERCENT only. The "ABSOLUTE" type has been deprecated.
     * @deprecated
     */
    public const PRICE_CHANGE_TYPE_ABSOLUTE = 'ABSOLUTE';

    private const REQUIRED_FIELDS = [];
    private const FIELDS_EXCLUDED_FROM_EXPORT = [
        'listing_id',
        'listing_id_str',
        'eligible_for_pass_through_taxes',
        'pass_through_taxes_collection_type',
    ];

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
     * Currency used for listing prices. Do not include any other pricing fields when updating the currency; send this
     * request separately to ensure proper processing order. Only supported currencies are accepted. Format: ISO 4217
     * @var string
     */
    private $listing_currency = 'USD';

    /**
     * The default daily price for the listing. Must be between 10 and 25,000 USD.
     * 0 is allowed for test listings created in sandbox app for making test reservations. Non-zero value less than
     * minimum is not allowed for test listings.
     * @var int|null
     */
    private $default_daily_price;

    /**
     * The default price to apply for the weekend days. Must be between 10 and 25,000 USD.
     * @var int|null
     */
    private $weekend_price;

    /**
     * A security deposit held by Airbnb and refunded to the guest unless the host makes a claim within 48 hours after
     * guest checks out. Must be between 100 and 5000 USD. To remove the security deposit, set the value to 0.
     * @var int|null
     */
    private $security_deposit;

    /**
     * Cleaning fee, denoted in listing_currency currency. Maximum cleaning fee is (600 USD + 25% nightly price).
     * Minimum cleaning fee is 5 USD. To remove the cleaning fee, set the value to 0.
     * @var int|null
     */
    private $cleaning_fee;

    /**
     * Number of guests permitted without any additional fees. Default is 1.
     * @var int|null
     */
    private $guests_included;

    /**
     * Amount added to the listing's nightly price for each guest beyond the number specified in guests_included.
     * Minimum is 5 USD. Maximum is 300 USD. To remove the price per extra person, set the value to 0.
     * @var int|null
     */
    private $price_per_extra_person;

    /**
     * If set, multiply the price by this factor for trips of 28 days or more. Range from 0 to 1. For example, 0.7
     * means 30% off. Note that this is treated as an LOS pricing rule, so be careful to avoid conflicts. Must be less
     * than weekly_price_factor.
     * @var float|null
     */
    private $monthly_price_factor;

    /**
     * If set, multiply the price by this factor for trips between 7 and 28 days. Range from 0 to 1. For example, 0.7
     * means 30% off. Must be greater than monthly_price_factor. Note that this is treated as an LOS pricing rule, so
     * be careful to avoid conflicts.
     * @var float|null
     */
    private $weekly_price_factor;

    /**
     * Array of standard fees to be applied to the listing. For more information, see the Standard Fees guide. Click
     * below to open the Standard Fee object.
     * @var array[]|null
     * array like
     * [['fee_type' => string, 'offline' => bool, 'amount_type' => string, 'amount' => float,
     * 'fee_unit_type' => string, 'charge_type' => string], ...]
     *
     * fee_type - The type of fee being charged. Some fees are a flat rate, some are a percentage, and some are
     *   consumption fees charged each time a unit is consumed.
     * offline - If true, this is an offline fee that will be charged when the guest checks in or out. If false, this
     *   fee will be collected at time of booking.
     * amount_type - 'Percent' or 'flat'. The PASS_THROUGH_LINEN_FEE and all measured consumption fees must be 'flat'.
     * amount - If amount_type is percent, this is a float between 0 and 100 (inclusive). If amount_type is flat, this
     *   is an integer in micros of the listing currency. For example, $1 USD is 1000000 micros, and five cents would be
     *   50000 micros.
     * fee_unit_type - This field only applies to fees charged each time a measured unit is consumed: electricity,
     *   water, heat, air conditioning, or other utilities. This field defines the unit being measured. For these fee
     *   types, the amount_type must be flat.
     * charge_type - This field defines the basis on which the fee will be charged. The default value is PER_GROUP, but
     *   a value of PER_PERSON is available exclusively for PASS_THROUGH_LINEN_FEE type fees.
     */
    private $standard_fees = [];

    /**
     * Array of standard fees to be applied to the listing. For more information, see the Standard Fees guide. Click
     * below to open the Standard Fee object.
     * @var array[]|null
     * array like:
     * [['tax_type' => string, 'amount' => float, 'amount_type' => string, 'business_tax_id' => string,
     *   'tot_registration_id' => string, 'attestation' => bool, 'long_term_stay_exemption' => int], ...]
     *
     * tax_type - tax type
     * amount - If amount_type is "percent_per_reservation", this is a float between 0 and 100 (inclusive). If
     *   amount_type is "flat_per_guest" , "flat_per_night", or "flat_per_guest_per_night", this is a float in the
     *   listing currency.
     * amount_type - type of amount
     * business_tax_id - The business tax id identifies the business as a taxpayer. For example, in the US, it would be
     *   the EIN.
     * tot_registration_id - Represents the ID number that a host receives from a jurisdiction when it registers to
     *   collect, remit, and report the applicable occupancy tax, and demonstrates that the host likely will do so.
     * attestation - A confirmation that the tax information is true and the host accepts responsibility to remit the
     *   tax given to them as a business.
     * long_term_stay_exemption - A length of stay (in number of days). Pass through taxes do not apply to stays longer
     *   than this value. The minimum value for this field is 13 days. If set to null or 0, no exemption applies and
     *   taxes are applied to all bookings regardless of length.
     */
    private $pass_through_taxes = [];

    /**
     * Array of default pricing rules to be applied to the listing. Note that SEASONAL_ADJUSTMENT is not supported as
     * default pricing rules. For more information, see the Promotions and Discounts Guide.
     * @var array[]|null
     * [['rule_type' => string, 'price_change' => int, 'price_change_type' => string, 'threshold_one' => int], ...]
     *
     * rule_type - SEASONAL_ADJUSTMENT: Seasonal rule adjustment; STAYED_AT_LEAST_X_DAYS: Long-term stay adjustment;
     *   BOOKED_WITHIN_AT_MOST_X_DAYS: Last-minute discount; BOOKED_BEYOND_AT_LEAST_X_DAYS: Booking ahead discount.
     *   SEASONAL_ADJUSTMENT is not applicable to listings as default pricing rules, it can only be used in seasonal
     *   rule sets.
     * price_change - If rule_type is SEASONAL_ADJUSTMENT, this field can be either positive or negative. Otherwise,
     *   price_change must be a negative value, meaning price decrease.
     * price_change_type - Use PERCENT only. The "ABSOLUTE" type has been deprecated.
     *   threshold_one - Not used for seasonal adjustments. Specifies the X value in the X_DAYS rules. Must be a
     *   multiple of 28 or 30 for "BOOKED_BEYOND_AT_LEAST_X_DAYS". Must be equal to or less than 28 for
     *   "BOOKED_WITHIN_AT_MOST_X_DAYS". Cannot be negative.
     */
    private $default_pricing_rules = [];

    /**
     * True if this listing is eligible for collecting pass through occupancy taxes. For the exact tax collection
     * scenario, see the value of pass_through_taxes_collection_type.
     * @var bool|null
     */
    private $eligible_for_pass_through_taxes;

    /**
     * To determine if a listing is eligible for pass through occupancy taxes.
     * @var string|null
     */
    private $pass_through_taxes_collection_type;

    /**
     * @param bool $withoutNulls
     * @return array
     */
    public function exportAsArray(bool $withoutNulls = false): array
    {
        $pricingSettings = get_object_vars($this);

        foreach (self::FIELDS_EXCLUDED_FROM_EXPORT as $field) {
            unset($pricingSettings[$field]);
        }

        if ($withoutNulls) {
            foreach ($pricingSettings as $fieldName => $value) {
                if (is_null($value)) {
                    unset($pricingSettings[$fieldName]);
                }
            }
        }

        return $pricingSettings;
    }

    /**
     * @param array $fields
     * @return PricingSettingsEntity
     */
    public function fillByArray(array $fields): PricingSettingsEntity
    {
        foreach ($fields as $name => $value) {
            $this->$name = $value;
        }

        return $this;
    }

    /**
     * @param array $data
     * @return PricingSettingsEntity
     * @throws EmptyRequiredFieldsException
     */
    public static function createByArray(array $data): PricingSettingsEntity
    {
        foreach (self::REQUIRED_FIELDS as $field) {
            if (!isset($data[$field])) {
                throw new EmptyRequiredFieldsException(sprintf(
                    'Some of required fields is absent: %s',
                    implode(',', self::REQUIRED_FIELDS)
                ));
            }
        }

        $pricingSettings = new self();

        $pricingSettings->fillByArray($data);

        return $pricingSettings;
    }

    /**
     * @param string $listing_currency
     * @return PricingSettingsEntity
     */
    public function setListingCurrency(string $listing_currency): PricingSettingsEntity
    {
        $this->listing_currency = $listing_currency;
        return $this;
    }

    /**
     * @return string
     */
    public function getListingCurrency(): string
    {
        return $this->listing_currency;
    }

    /**
     * @param int|null $default_daily_price
     * @return PricingSettingsEntity
     */
    public function setDefaultDailyPrice(?int $default_daily_price): PricingSettingsEntity
    {
        $this->default_daily_price = $default_daily_price;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getDefaultDailyPrice(): ?int
    {
        return $this->default_daily_price;
    }

    /**
     * @param int|null $weekend_price
     * @return PricingSettingsEntity
     */
    public function setWeekendPrice(?int $weekend_price): PricingSettingsEntity
    {
        $this->weekend_price = $weekend_price;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getWeekendPrice(): ?int
    {
        return $this->weekend_price;
    }

    /**
     * @param int|null $security_deposit
     * @return PricingSettingsEntity
     */
    public function setSecurityDeposit(?int $security_deposit): PricingSettingsEntity
    {
        $this->security_deposit = $security_deposit;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getSecurityDeposit(): ?int
    {
        return $this->security_deposit;
    }

    /**
     * @param int|null $cleaning_fee
     * @return PricingSettingsEntity
     */
    public function setCleaningFee(?int $cleaning_fee): PricingSettingsEntity
    {
        $this->cleaning_fee = $cleaning_fee;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCleaningFee(): ?int
    {
        return $this->cleaning_fee;
    }

    /**
     * @param int|null $guests_included
     * @return PricingSettingsEntity
     */
    public function setGuestsIncluded(?int $guests_included): PricingSettingsEntity
    {
        $this->guests_included = $guests_included;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getGuestsIncluded(): ?int
    {
        return $this->guests_included;
    }

    /**
     * @param int|null $price_per_extra_person
     * @return PricingSettingsEntity
     */
    public function setPricePerExtraPerson(?int $price_per_extra_person): PricingSettingsEntity
    {
        $this->price_per_extra_person = $price_per_extra_person;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPricePerExtraPerson(): ?int
    {
        return $this->price_per_extra_person;
    }

    /**
     * @param float|null $monthly_price_factor
     * @return PricingSettingsEntity
     */
    public function setMonthlyPriceFactor(?float $monthly_price_factor): PricingSettingsEntity
    {
        $this->monthly_price_factor = $monthly_price_factor;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getMonthlyPriceFactor(): ?float
    {
        return $this->monthly_price_factor;
    }

    /**
     * @param array[]|null $standard_fees
     * @return PricingSettingsEntity
     */
    public function setStandardFees(?array $standard_fees): PricingSettingsEntity
    {
        $this->standard_fees = $standard_fees;
        return $this;
    }

    /**
     * @return array[]|null
     */
    public function getStandardFees(): ?array
    {
        return $this->standard_fees;
    }

    /**
     * @param array[]|null $pass_through_taxes
     * @return PricingSettingsEntity
     */
    public function setPassThroughTaxes(?array $pass_through_taxes): PricingSettingsEntity
    {
        $this->pass_through_taxes = $pass_through_taxes;
        return $this;
    }

    /**
     * @return array[]|null
     */
    public function getPassThroughTaxes(): ?array
    {
        return $this->pass_through_taxes;
    }

    /**
     * @param array[]|null $default_pricing_rules
     * @return PricingSettingsEntity
     */
    public function setDefaultPricingRules(?array $default_pricing_rules): PricingSettingsEntity
    {
        $this->default_pricing_rules = $default_pricing_rules;
        return $this;
    }

    /**
     * @return array[]|null
     */
    public function getDefaultPricingRules(): ?array
    {
        return $this->default_pricing_rules;
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
     * @return bool|null
     */
    public function getEligibleForPassThroughTaxes(): ?bool
    {
        return $this->eligible_for_pass_through_taxes;
    }

    /**
     * @return string|null
     */
    public function getPassThroughTaxesCollectionType(): ?string
    {
        return $this->pass_through_taxes_collection_type;
    }

    /**
     * @param float|null $weekly_price_factor
     * @return PricingSettingsEntity
     */
    public function setWeeklyPriceFactor(?float $weekly_price_factor): PricingSettingsEntity
    {
        $this->weekly_price_factor = $weekly_price_factor;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getWeeklyPriceFactor(): ?float
    {
        return $this->weekly_price_factor;
    }
}
