<?php

namespace Amarkhai\AirbnbSdk\Entities;

use Amarkhai\AirbnbSdk\Exceptions\EmptyRequiredFieldsException;

/**
 * The entity for Seasonal Rule Groups
 */
class SeasonalRuleGroupEntity
{
    public const DAY_MONDAY = 'MONDAY';
    public const DAY_TUESDAY = 'TUESDAY';
    public const DAY_WEDNESDAY = 'WEDNESDAY';
    public const DAY_THURSDAY = 'THURSDAY';
    public const DAY_FRIDAY = 'FRIDAY';
    public const DAY_SATURDAY = 'SATURDAY';
    public const DAY_SUNDAY = 'SUNDAY';
    public const DAY_UNSPECIFIED = 'UNSPECIFIED';

    /** Seasonal rule adjustment */
    public const RULE_TYPE_SEASONAL_ADJUSTMENT = 'SEASONAL_ADJUSTMENT';
    /** Long-term stay adjustment */
    public const RULE_TYPE_STAYED_AT_LEAST_X_DAYS = 'STAYED_AT_LEAST_X_DAYS';
    /** Last-minute discount */
    public const RULE_TYPE_BOOKED_WITHIN_AT_MOST_X_DAYS = 'BOOKED_WITHIN_AT_MOST_X_DAYS';
    /** Booking ahead discount */
    public const RULE_TYPE_BOOKED_BEYOND_AT_LEAST_X_DAYS = 'BOOKED_BEYOND_AT_LEAST_X_DAYS';
    /** For 'price_change_type' use PERCENT only. The "ABSOLUTE" type has been deprecated. */
    public const PRICE_CHANGE_TYPE_PERCENT = 'PERCENT';
    /**
     * For 'price_change_type' use PERCENT only. The "ABSOLUTE" type has been deprecated.
     * @deprecated
     */
    public const PRICE_CHANGE_TYPE_ABSOLUTE = 'ABSOLUTE';

    private const REQUIRED_FIELDS = [];

    private const FIELDS_EXCLUDED_FROM_EXPORT = [
        'id',
    ];

    /**
     * Rule Group ID
     * @var int|null
     */
    private $id;
    /**
     * User ID of the person who created this group.
     * @var int|null
     */
    private $created_by_user_id;
    /**
     * Color to show on the UI Airbnb calendar for the rule group. Value from 0 to 8. See the guide on color coding
     * the calendar.
     * @var int|null
     */
    private $color;

    /**
     * Title to show on the UI Airbnb calendar for this rule group. Example: Summer Sale!
     * @var string|null
     */
    private $title;

    /**
     * @var array[]|null
     * array like
     * [['rule_type' => string, 'price_change' => int, 'price_change_type' => string, 'threshold_one' => int], ... ]
     * rule_type - SEASONAL_ADJUSTMENT is not applicable to listings as default pricing rules, it can only be used in
     *   seasonal rule sets.
     * price_change - If rule_type is SEASONAL_ADJUSTMENT, this field can be either positive or negative. Otherwise,
     *   price_change must be a negative value, meaning price decrease.
     * price_change_type - Use PERCENT only. The "ABSOLUTE" type has been deprecated.
     * threshold_one - Not used for seasonal adjustments. Specifies the X value in the X_DAYS rules. Must be a multiple
     *   of 28 or 30 for "BOOKED_BEYOND_AT_LEAST_X_DAYS". Must be equal to or less than 28 for
     *   "BOOKED_WITHIN_AT_MOST_X_DAYS". Cannot be negative.
     */
    private $pricing_rules;

    /**
     * @var array|null
     * array like
     * ['closed_for_checkout' => string[], 'closed_for_checkin' => string[], 'max_nights' => array,
     *   'min_nights' => array]
     * closed_for_checkout - Days in week that guest cannot check out. Comma-separated array of enum strings.
     * closed_for_checkin - Days in week that guest cannot check in. Comma-separated array of enum strings.
     * max_nights - Map from day of week to corresponding max nights value, which is the maximum length of stay if the
     *   trip starts on this day. Day should be one of "MONDAY", "TUESDAY", "WEDNESDAY", "THURSDAY", "FRIDAY",
     *   "SATURDAY", "SUNDAY" or "UNSPECIFIED". If any days are missing, the "UNSPECIFIED" value is used. If there is no
     *   "UNSPECIFIED" value, then 1095 days is used.
     * min_nights - Map from day of week to corresponding min nights value, which is the minimum length of stay if the
     *   trip starts on this day. Day should be one of "MONDAY", "TUESDAY", "WEDNESDAY", "THURSDAY", "FRIDAY",
     *   "SATURDAY", "SUNDAY" or "UNSPECIFIED".
     */
    private $availability_rules;

    /**
     * @param bool $withoutNulls
     * @return array
     */
    public function exportAsArray(bool $withoutNulls = false): array
    {
        $ruleGroupData = get_object_vars($this);

        foreach (self::FIELDS_EXCLUDED_FROM_EXPORT as $field) {
            unset($ruleGroupData[$field]);
        }

        if ($withoutNulls) {
            foreach ($ruleGroupData as $fieldName => $value) {
                if (is_null($value)) {
                    unset($ruleGroupData[$fieldName]);
                }
            }
        }

        return $ruleGroupData;
    }

    /**
     * @param array $fields
     * @return SeasonalRuleGroupEntity
     */
    public function fillByArray(array $fields): SeasonalRuleGroupEntity
    {
        foreach ($fields as $name => $value) {
            $this->$name = $value;
        }

        return $this;
    }

    /**
     * @param array $data
     * @return SeasonalRuleGroupEntity
     * @throws EmptyRequiredFieldsException
     */
    public static function createByArray(array $data): SeasonalRuleGroupEntity
    {
        foreach (self::REQUIRED_FIELDS as $field) {
            if (!isset($data[$field])) {
                throw new EmptyRequiredFieldsException(sprintf(
                    'Some of required fields is absent: %s',
                    implode(',', self::REQUIRED_FIELDS)
                ));
            }
        }

        $ruleGroup = new self();

        $ruleGroup->fillByArray($data);

        return $ruleGroup;
    }

    /**
     * @param int|null $color
     * @return SeasonalRuleGroupEntity
     */
    public function setColor(?int $color): SeasonalRuleGroupEntity
    {
        $this->color = $color;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getColor(): ?int
    {
        return $this->color;
    }

    /**
     * @param string|null $title
     * @return SeasonalRuleGroupEntity
     */
    public function setTitle(?string $title): SeasonalRuleGroupEntity
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param array[] $pricing_rules
     * @return SeasonalRuleGroupEntity
     */
    public function setPricingRules(array $pricing_rules): SeasonalRuleGroupEntity
    {
        $this->pricing_rules = $pricing_rules;
        return $this;
    }

    /**
     * @return array[]
     */
    public function getPricingRules(): array
    {
        return $this->pricing_rules;
    }

    /**
     * @param array|null $availability_rules
     * @return SeasonalRuleGroupEntity
     */
    public function setAvailabilityRules(?array $availability_rules): SeasonalRuleGroupEntity
    {
        $this->availability_rules = $availability_rules;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getAvailabilityRules(): ?array
    {
        return $this->availability_rules;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getCreatedByUserId(): ?int
    {
        return $this->created_by_user_id;
    }

    /**
     * @param int|null $id
     * @return SeasonalRuleGroupEntity
     */
    public function setId(?int $id): SeasonalRuleGroupEntity
    {
        $this->id = $id;
        return $this;
    }
}
