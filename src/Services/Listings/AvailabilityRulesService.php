<?php

namespace Amarkhai\AirbnbSdk\Services\Listings;

use Amarkhai\AirbnbSdk\Entities\AvailabilityRulesEntity;
use Amarkhai\AirbnbSdk\Services\AirbnbBaseService;

/**
 * The service for working with the "availability_rules/" endpoint
 */
class AvailabilityRulesService extends AirbnbBaseService
{
    /**
     * Availability Rules API endpoint
     */
    private const ENDPOINT = 'availability_rules/';


    /**
     * @param int $listingID
     * @param string $userToken
     * @return AvailabilityRulesEntity
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAvailabilityRules(int $listingID, string $userToken): AvailabilityRulesEntity
    {
        $url = self::BASE_URL . self::ENDPOINT . $listingID;

        $response = $this->httpClient->get($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ],
        ]);

        $availabilityRulesData = json_decode($response->getBody()->getContents(), true)['availability_rule'];

        return AvailabilityRulesEntity::createByArray($availabilityRulesData);
    }

    /**
     * @param int $listingID
     * @param AvailabilityRulesEntity $availabilityRules
     * @param string $userToken
     * @return AvailabilityRulesEntity
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateAvailabilityRules(
        int $listingID,
        AvailabilityRulesEntity $availabilityRules,
        string $userToken
    ): AvailabilityRulesEntity {
        $url = self::BASE_URL . self::ENDPOINT . $listingID;

        $response = $this->httpClient->put($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ],
            'json' => $availabilityRules->exportAsArray(true)
        ]);

        $updatedRulesData = json_decode($response->getBody()->getContents(), true)['availability_rule'];

        return $availabilityRules->fillByArray($updatedRulesData);
    }
}
