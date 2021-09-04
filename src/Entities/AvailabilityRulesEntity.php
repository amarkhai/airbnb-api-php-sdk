<?php

namespace Amarkhai\AirbnbSdk\Entities;

/**
 * The entity for the representation Availability Rules
 */
class AvailabilityRulesEntity
{
    private const FIELDS_EXCLUDED_FROM_EXPORT = [];

    /**
     * The default minimum night requirement for reservations. Set 0 to reset to default value.
     * @var int|null
     */
    private $default_min_nights;
    /**
     * The default maximum night requirement for reservations. Set 0 to reset to default value.
     * @var int|null
     */
    private $default_max_nights;
    /**
     * @var array{hours: int, allow_request_to_book: int}|null
     *
     * hours - The number of hours required for minimum notice before booking. Valid values are 0-24, 48, 72, and 168.
     * allow_request_to_book - Bookings that do not meet the minimum notice requirement can become requests to book
     *   instead. Use -1 or 0 to prohibit requests and 1 to allow requests. The default value is -1; requests are not
     *   allowed.
     */
    private $booking_lead_time;
    /**
     * @deprecated
     * @var array{days: int}|null
     * DEPRECATED. Use booking_lead_time instead.
     */
    private $min_days_notice;
    /**
     * @var array{days: int}|null
     *
     * days - The maximum number of days between the booking date and the check in date.
     *   Valid values are -1, 0, 30, 60, 90, 120, 150, 180, 210, 240, 270, 300, 330, 365.
     *   Pass 0 to make ALL future days unavailable. Pass -1 to reset ALL future days to available.
     *   Default is all future days are available.
     */
    private $max_days_notice;
    /**
     * @var array[]|null
     * array like [['start_date' => string, 'end_date' => string, 'min_nights' => int], ... ]
     *
     * start_date - Start date of date range for this rule, as YYYY-MM-DD.
     * end_date - End date of date range for this rule, as YYYY-MM-DD.
     * min_nights - Minimum number of nights if the trip starts on a day within the range.
     */
    private $seasonal_min_nights;
    /**
     * @var array{days: int}|null
     *
     * days - days to block before and after each reservation
     */
    private $turnover_days;
    /**
     * @var array[]|null
     * array like [['day_of_week' => int], ... ]
     *
     * day_of_week - Day of week guests are allowed to check in. Value in range 0-6, representing Sunday - Saturday.
     */
    private $day_of_week_check_in;
    /**
     * @var array[]|null
     * array like [['day_of_week' => int], ... ]
     *
     * day_of_week - Day of week guests are allowed to check in. Value in range 0-6, represents Sun-Sat.
     */
    private $day_of_week_check_out;
    /**
     * @var array[]|null
     * array like [['day_of_week' => int, 'min_nights' => int], ...]
     *
     * day_of_week - Day of week guests are allowed to check in. Value in range 0-6, represents Sun-Sat.
     * min_nights - Minimum number of nights if the trip starts on a day within the range.
     */
    private $day_of_week_min_nights;
    /**
     * If TRUE, an attempt to book a stay longer than allowed by default_max_nights will be allowed but trigger the
     * request to book (RTB) flow instead of instant book. If FALSE, these bookings will not be permitted. This setting
     * applies when default_max_nights is 28 or more. Any seasonal/daily max nights setting overrides this option.
     * Example: if a listing has a default max nights of 60 but a seasonal max nights of 30, bookings above 30 nights
     * are not allowed even if this parameter is TRUE. Listings using LOS records for pricing and availability may use
     * a combination of a default_max_nights value and allow_rtb_above_max_nights to require RTB for bookings above a
     * certain LOS.
     * @var bool|null
     */
    private $allow_rtb_above_max_nights;
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
        $availabilityRuleData = get_object_vars($this);

        foreach (self::FIELDS_EXCLUDED_FROM_EXPORT as $field) {
            unset($availabilityRuleData[$field]);
        }

        if ($withoutNulls) {
            foreach ($availabilityRuleData as $fieldName => $value) {
                if (is_null($value)) {
                    unset($availabilityRuleData[$fieldName]);
                }
            }
        }

        return $availabilityRuleData;
    }

    /**
     * @param array $fields
     * @return AvailabilityRulesEntity
     */
    public function fillByArray(array $fields): AvailabilityRulesEntity
    {
        foreach ($fields as $name => $value) {
            $this->$name = $value;
        }

        return $this;
    }

    /**
     * @param array $data
     * @return AvailabilityRulesEntity
     */
    public static function createByArray(array $data): AvailabilityRulesEntity
    {
        $availabilityRule = new self();

        $availabilityRule->fillByArray($data);

        return $availabilityRule;
    }

    /**
     * @return int|null
     */
    public function getDefaultMinNights(): ?int
    {
        return $this->default_min_nights;
    }

    /**
     * @param int|null $default_min_nights
     * @return AvailabilityRulesEntity
     */
    public function setDefaultMinNights(?int $default_min_nights): AvailabilityRulesEntity
    {
        $this->default_min_nights = $default_min_nights;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getDefaultMaxNights(): ?int
    {
        return $this->default_max_nights;
    }

    /**
     * @param int|null $default_max_nights
     * @return AvailabilityRulesEntity
     */
    public function setDefaultMaxNights(?int $default_max_nights): AvailabilityRulesEntity
    {
        $this->default_max_nights = $default_max_nights;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getBookingLeadTime(): ?array
    {
        return $this->booking_lead_time;
    }

    /**
     * @param array|null $booking_lead_time
     * @return AvailabilityRulesEntity
     */
    public function setBookingLeadTime(?array $booking_lead_time): AvailabilityRulesEntity
    {
        $this->booking_lead_time = $booking_lead_time;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getMaxDaysNotice(): ?array
    {
        return $this->max_days_notice;
    }

    /**
     * @param array|null $max_days_notice
     * @return AvailabilityRulesEntity
     */
    public function setMaxDaysNotice(?array $max_days_notice): AvailabilityRulesEntity
    {
        $this->max_days_notice = $max_days_notice;
        return $this;
    }

    /**
     * @return array[]|null
     */
    public function getSeasonalMinNights(): ?array
    {
        return $this->seasonal_min_nights;
    }

    /**
     * @param array[]|null $seasonal_min_nights
     * @return AvailabilityRulesEntity
     */
    public function setSeasonalMinNights(?array $seasonal_min_nights): AvailabilityRulesEntity
    {
        $this->seasonal_min_nights = $seasonal_min_nights;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getTurnoverDays(): ?array
    {
        return $this->turnover_days;
    }

    /**
     * @param array|null $turnover_days
     * @return AvailabilityRulesEntity
     */
    public function setTurnoverDays(?array $turnover_days): AvailabilityRulesEntity
    {
        $this->turnover_days = $turnover_days;
        return $this;
    }

    /**
     * @return array[]|null
     */
    public function getDayOfWeekCheckIn(): ?array
    {
        return $this->day_of_week_check_in;
    }

    /**
     * @param array[]|null $day_of_week_check_in
     * @return AvailabilityRulesEntity
     */
    public function setDayOfWeekCheckIn(?array $day_of_week_check_in): AvailabilityRulesEntity
    {
        $this->day_of_week_check_in = $day_of_week_check_in;
        return $this;
    }

    /**
     * @return array[]|null
     */
    public function getDayOfWeekCheckOut(): ?array
    {
        return $this->day_of_week_check_out;
    }

    /**
     * @param array[]|null $day_of_week_check_out
     * @return AvailabilityRulesEntity
     */
    public function setDayOfWeekCheckOut(?array $day_of_week_check_out): AvailabilityRulesEntity
    {
        $this->day_of_week_check_out = $day_of_week_check_out;
        return $this;
    }

    /**
     * @return array[]|null
     */
    public function getDayOfWeekMinNights(): ?array
    {
        return $this->day_of_week_min_nights;
    }

    /**
     * @param array[]|null $day_of_week_min_nights
     * @return AvailabilityRulesEntity
     */
    public function setDayOfWeekMinNights(?array $day_of_week_min_nights): AvailabilityRulesEntity
    {
        $this->day_of_week_min_nights = $day_of_week_min_nights;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getAllowRtbAboveMaxNights(): ?bool
    {
        return $this->allow_rtb_above_max_nights;
    }

    /**
     * @param bool|null $allow_rtb_above_max_nights
     * @return AvailabilityRulesEntity
     */
    public function setAllowRtbAboveMaxNights(?bool $allow_rtb_above_max_nights): AvailabilityRulesEntity
    {
        $this->allow_rtb_above_max_nights = $allow_rtb_above_max_nights;
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
     * @param bool|null $skip_response
     * @return AvailabilityRulesEntity
     */
    public function setSkipResponse(?bool $skip_response): AvailabilityRulesEntity
    {
        $this->skip_response = $skip_response;
        return $this;
    }

    /**
     * @deprecated
     * @return array|null
     */
    public function getMinDaysNotice(): ?array
    {
        return $this->min_days_notice;
    }

    /**
     * @param array|null $min_days_notice
     * @return AvailabilityRulesEntity
     * @deprecated
     */
    public function setMinDaysNotice(?array $min_days_notice): AvailabilityRulesEntity
    {
        $this->min_days_notice = $min_days_notice;
        return $this;
    }
}
