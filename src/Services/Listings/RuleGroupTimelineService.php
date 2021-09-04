<?php

namespace Amarkhai\AirbnbSdk\Services\Listings;

use Amarkhai\AirbnbSdk\Entities\RuleGroupTimelineEntity;
use Amarkhai\AirbnbSdk\Services\AirbnbBaseService;

/**
 * The service for working with the "listing_seasonal_rule_set_timelines/" endpoint
 */
class RuleGroupTimelineService extends AirbnbBaseService
{
    private const ENDPOINT = 'listing_seasonal_rule_set_timelines/';

    /**
     * Retrieve all seasonal rule groups for the consumed listing
     *
     * @param int $listingID Airbnb identifier for the listing
     * @param string $userToken
     * @return RuleGroupTimelineEntity[]
     * @throws \Amarkhai\AirbnbSdk\Exceptions\EmptyRequiredFieldsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAllRuleGroupsByListingID(int $listingID, string $userToken): array
    {
        $url = self::BASE_URL . self::ENDPOINT . $listingID;

        $response = $this->httpClient->get($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ],
        ]);

        $ruleGroups = json_decode($response->getBody()->getContents(), true)['listing_seasonal_rule_set_timeline']['rule_group_timeline'];

        $result = [];
        foreach ($ruleGroups as $ruleGroup) {
            $result[] = RuleGroupTimelineEntity::createByArray($ruleGroup);
        }

        return $result;
    }

    /**
     * This action lets you apply or remove a Rule Group to/from a listing for a given set of dates. If multiple rule
     * groups are applied to the same listing for the same date range, the latest one overrides the previous one - only
     * one rule group is applied to a listing on a specific date range.
     *
     * @param RuleGroupTimelineEntity $ruleGroup
     * @param int $listingID Airbnb identifier for the listing
     * @param string $userToken
     * @return RuleGroupTimelineEntity[]
     * @throws \Amarkhai\AirbnbSdk\Exceptions\EmptyRequiredFieldsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function applyOrRemoveRuleGroup(
        RuleGroupTimelineEntity $ruleGroup,
        int $listingID,
        string $userToken
    ): array {
        $url = self::BASE_URL . self::ENDPOINT . $listingID;

        $response = $this->httpClient->put($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ],
            'json' => $ruleGroup->exportAsArray(true)
        ]);

        $ruleGroups = json_decode($response->getBody()->getContents(), true)['listing_seasonal_rule_set_timeline']['rule_group_timeline'];

        $result = [];
        foreach ($ruleGroups as $ruleGroup) {
            $result[] = RuleGroupTimelineEntity::createByArray($ruleGroup);
        }

        return $result;
    }
}
