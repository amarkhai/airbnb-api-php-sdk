<?php

namespace Amarkhai\AirbnbSdk\Services\Listings;

use Amarkhai\AirbnbSdk\Entities\SeasonalRuleGroupEntity;
use Amarkhai\AirbnbSdk\Services\AirbnbBaseService;

/**
 * The service for working with the "seasonal_rule_sets/" endpoint
 */
class SeasonRuleGroupService extends AirbnbBaseService
{
    /**
     * Listings seasonal rule group API endpoint
     */
    private const ENDPOINT = 'seasonal_rule_sets/';

    /**
     * Create seasonal rule group
     *
     * @param SeasonalRuleGroupEntity $ruleGroup
     * @param string $userToken
     * @return SeasonalRuleGroupEntity
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createRuleGroup(
        SeasonalRuleGroupEntity $ruleGroup,
        string $userToken
    ): SeasonalRuleGroupEntity {
        $url = self::BASE_URL . self::ENDPOINT;

        $response = $this->httpClient->post($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ],
            'json' => $ruleGroup->exportAsArray(true)
        ]);

        $createdRuleGroup = json_decode($response->getBody()->getContents(), true)['seasonal_rule_set'];

        return $ruleGroup->fillByArray($createdRuleGroup);
    }

    /**
     * Retrieve all seasonal rule groups
     *
     * @param int $userID user_id The Airbnb UserID of the user to retrieve rules for
     * @param string $userToken
     * @return SeasonalRuleGroupEntity[]
     * @throws \Amarkhai\AirbnbSdk\Exceptions\EmptyRequiredFieldsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAllRuleGroupsByUserID(int $userID, string $userToken): array
    {
        $url = self::BASE_URL . self::ENDPOINT;

        $response = $this->httpClient->get($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ],
            'query' => [
                'user_id' => $userID,
            ],
        ]);

        $ruleGroups = json_decode($response->getBody()->getContents(), true)['seasonal_rule_sets'];

        $result = [];
        foreach ($ruleGroups as $ruleGroup) {
            $result[] = SeasonalRuleGroupEntity::createByArray($ruleGroup);
        }

        return $result;
    }

    /**
     * Retrieve seasonal rule group by ID
     *
     * @param int $ruleGroupID
     * @param string $userToken
     * @return SeasonalRuleGroupEntity
     * @throws \Amarkhai\AirbnbSdk\Exceptions\EmptyRequiredFieldsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRuleGroupByID(
        int $ruleGroupID,
        string $userToken
    ): SeasonalRuleGroupEntity {
        $url = self::BASE_URL . self::ENDPOINT . $ruleGroupID;

        $response = $this->httpClient->get($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ],
        ]);

        $ruleGroupData = json_decode($response->getBody()->getContents(), true)['seasonal_rule_set'];

        return SeasonalRuleGroupEntity::createByArray($ruleGroupData);
    }

    /**
     * Delete seasonal rule group
     *
     * @param int $ruleGroupID
     * @param string $userToken
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteRuleGroupByID(int $ruleGroupID, string $userToken): void
    {
        $url = self::BASE_URL . self::ENDPOINT . $ruleGroupID;

        $this->httpClient->delete($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ],
        ]);
    }

    /**
     * @param SeasonalRuleGroupEntity $ruleGroup
     * @param string $userToken
     * @return SeasonalRuleGroupEntity
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendChangesForRuleGroup(
        SeasonalRuleGroupEntity $ruleGroup,
        string $userToken
    ): SeasonalRuleGroupEntity {
        $url = self::BASE_URL . self::ENDPOINT . $ruleGroup->getId();

        $response = $this->httpClient->put($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ],
            'json' => $ruleGroup->exportAsArray(true)
        ]);

        $createdRuleGroup = json_decode($response->getBody()->getContents(), true)['seasonal_rule_set'];

        return $ruleGroup->fillByArray($createdRuleGroup);
    }
}
