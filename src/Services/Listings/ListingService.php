<?php

namespace Amarkhai\AirbnbSdk\Services\Listings;

use Amarkhai\AirbnbSdk\Entities\ListingEntity;
use Amarkhai\AirbnbSdk\Entities\Parameters\GetAllListingsParameters;
use Amarkhai\AirbnbSdk\Services\AirbnbBaseService;

/**
 * The service for working with the "listings/" endpoint
 */
class ListingService extends AirbnbBaseService
{
    /**
     * Listings API endpoint
     */
    private const ENDPOINT = 'listings/';

    /**
     * Create new listing
     *
     * @param ListingEntity $listing
     * @param string $userToken
     * @return ListingEntity
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createListing(ListingEntity $listing, string $userToken): ListingEntity
    {
        $url = self::BASE_URL . self::ENDPOINT;

        $response = $this->httpClient->post($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ],
            'json' => $listing->exportAsArray(true)
        ]);

        $createdListing = json_decode($response->getBody()->getContents(), true)['listing'];

        return $listing->fillByArray($createdListing);
    }

    /**
     * Get all listings for this user
     *
     * @param int $userID ID of the Airbnb account
     * @param string $userToken
     * @param GetAllListingsParameters|null $parameters
     * @return array
     * array like
     * [
     *  listings => ListingEntity[],
     *  paging => [
     *      total_count: int,
     *      limit: int,
     *      prev_offset: int|null,
     *      next_offset: int,
     *      next_cursor: string
     *  ],
     * ]
     * @throws \Amarkhai\AirbnbSdk\Exceptions\EmptyRequiredFieldsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUsersListings(int $userID, string $userToken, GetAllListingsParameters $parameters = null): array
    {
        $url = self::BASE_URL . self::ENDPOINT;

        $queryParameters = [
            'user_id' => $userID
        ];

        if (!is_null($parameters)) {
            $parameters = (array)$parameters;
            $queryParameters = array_merge($queryParameters, $parameters);
        }

        $response = $this->httpClient->get($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ],
            'query' => $queryParameters,
        ]);

        $parsedResponse = json_decode($response->getBody()->getContents(), true);
        $listingsData = $parsedResponse['listings'];

        $listings = [];
        foreach ($listingsData as $listing) {
            $listings[] = ListingEntity::createByArray($listing);
        }

        return [
            'listings' => $listings,
            'paging' => $parsedResponse['paging'],
        ];
    }

    /**
     * Get listing's info by ID
     *
     * @param int $listingID
     * @param string $userToken
     * @return ListingEntity
     * @throws \Amarkhai\AirbnbSdk\Exceptions\EmptyRequiredFieldsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getListing(int $listingID, string $userToken): ListingEntity
    {
        $url = self::BASE_URL . self::ENDPOINT . $listingID;

        $response = $this->httpClient->get($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ],
        ]);

        $listingData = json_decode($response->getBody()->getContents(), true)['listing'];

        return ListingEntity::createByArray($listingData);
    }

    /**
     * Update listing
     *
     * @param ListingEntity $listing
     * @param string $userToken
     * @return ListingEntity
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateListing(ListingEntity $listing, string $userToken): ListingEntity
    {
        $url = self::BASE_URL . self::ENDPOINT . $listing->getId();

        $response = $this->httpClient->put($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ],
            'json' => $listing->exportAsArray(true)
        ]);

        $createdListing = json_decode($response->getBody()->getContents(), true)['listing'];

        return $listing->fillByArray($createdListing);
    }

    /**
     * Delete listing by ID. If this listing is already deleted, Airbnb response with code 403 and message: "You do
     * not have permission to access this resource."
     *
     * @param int $listingID
     * @param string $userToken
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteListing(int $listingID, string $userToken): void
    {
        $url = self::BASE_URL . self::ENDPOINT . $listingID;

        $this->httpClient->delete($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ],
        ]);
    }
}
