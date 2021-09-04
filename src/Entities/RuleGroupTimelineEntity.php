<?php

namespace Amarkhai\AirbnbSdk\Entities;

use Amarkhai\AirbnbSdk\Exceptions\EmptyRequiredFieldsException;

/**
 * The entity for the representation Listing Rule Groups Timelines
 */
class RuleGroupTimelineEntity
{
    private const REQUIRED_FIELDS = [];
    private const FIELDS_EXCLUDED_FROM_EXPORT = [];

    /**
     * Rule Group ID
     * @var int|null
     */
    private $seasonal_rule_group_id;
    /**
     * Start date in ISO 8601 YYYY-MM-DD format.
     * @var string|null
     */
    private $since_date;
    /**
     * Start date in ISO 8601 YYYY-MM-DD format.
     * @var string|null
     */
    private $end_date;

    /**
     * @param bool $withoutNulls
     * @return RuleGroupTimelineEntity[]
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
     * @return RuleGroupTimelineEntity
     */
    public function fillByArray(array $fields): RuleGroupTimelineEntity
    {
        foreach ($fields as $name => $value) {
            $this->$name = $value;
        }

        return $this;
    }

    /**
     * @param array $data
     * @return RuleGroupTimelineEntity
     * @throws EmptyRequiredFieldsException
     */
    public static function createByArray(array $data): RuleGroupTimelineEntity
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
     * @param int|null $seasonal_rule_group_id
     * @return RuleGroupTimelineEntity
     */
    public function setSeasonalRuleGroupId(?int $seasonal_rule_group_id): RuleGroupTimelineEntity
    {
        $this->seasonal_rule_group_id = $seasonal_rule_group_id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getSeasonalRuleGroupId(): ?int
    {
        return $this->seasonal_rule_group_id;
    }

    /**
     * @param string|null $since_date
     * @return RuleGroupTimelineEntity
     */
    public function setSinceDate(?string $since_date): RuleGroupTimelineEntity
    {
        $this->since_date = $since_date;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSinceDate(): ?string
    {
        return $this->since_date;
    }

    /**
     * @param string|null $end_date
     * @return RuleGroupTimelineEntity
     */
    public function setEndDate(?string $end_date): RuleGroupTimelineEntity
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
}
