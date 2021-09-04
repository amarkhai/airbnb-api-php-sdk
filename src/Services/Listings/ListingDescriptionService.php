<?php

namespace Amarkhai\AirbnbSdk\Services\Listings;

use Amarkhai\AirbnbSdk\Entities\ListingDescriptionEntity;
use Amarkhai\AirbnbSdk\Services\AirbnbBaseService;

/**
 * The service for working with the "listing_descriptions/" endpoint
 */
class ListingDescriptionService extends AirbnbBaseService
{
    /**
     * Listings descriptions API endpoint
     */
    private const ENDPOINT = 'listing_descriptions/';

    /**
     * Create a listing description in the given locale for a listing with a given ID.
     *
     * @param ListingDescriptionEntity $description
     * @param string $userToken
     * @param int $listingID
     * @param string $locale
     * @return ListingDescriptionEntity
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createListingDescription(
        ListingDescriptionEntity $description,
        string $userToken,
        int $listingID,
        string $locale = 'en'
    ): ListingDescriptionEntity {
        $url = self::BASE_URL . self::ENDPOINT . $listingID . '/' . $locale;

        $response = $this->httpClient->put($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ],
            'json' => $description->exportAsArray(true)
        ]);

        $createdDescription = json_decode($response->getBody()->getContents(), true)['listing_description'];

        return $description->fillByArray($createdDescription);
    }

    /**
     * Create, update or delete listing descriptions to match the given payload for a listing.
     *
     * @param array $descriptions
     * @param string $userToken
     * @param string $listingID
     * @return array
     * @throws \Amarkhai\AirbnbSdk\Exceptions\EmptyRequiredFieldsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function setAllListingDescriptions(array $descriptions, string $userToken, string $listingID): array
    {
        $url = self::BASE_URL . self::ENDPOINT . $listingID;

        $body = [];
        /** @var ListingDescriptionEntity $description */
        foreach ($descriptions as $description) {
            $body[] = $description->exportAsArray(true);
        }

        $response = $this->httpClient->put($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ],
            'json' => [
                'listing_descriptions' => $body
            ]
        ]);

        $updatedDescriptions = json_decode($response->getBody()->getContents(), true)['listing_descriptions'];

        $result = [];
        foreach ($updatedDescriptions as $d) {
            $result[] = ListingDescriptionEntity::createByArray($d);
        }

        return $result;
    }

    /**
     * Retrieve all descriptions for listing with id = $listingID
     *
     * @param int $listingID
     * @param string $userToken
     * @return array
     * @throws \Amarkhai\AirbnbSdk\Exceptions\EmptyRequiredFieldsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAllListingDescriptions(int $listingID, string $userToken): array
    {
        $url = self::BASE_URL . self::ENDPOINT;

        $response = $this->httpClient->get($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ],
            'query' => [
                'listing_id' => $listingID
            ],
        ]);

        $descriptions = json_decode($response->getBody()->getContents(), true)['listing_descriptions'];

        $result = [];
        foreach ($descriptions as $description) {
            $result[] = ListingDescriptionEntity::createByArray($description);
        }

        return $result;
    }

    /**
     * Retrieve listing description
     *
     * @param int $listingID
     * @param string $userToken
     * @param string $locale
     * @return ListingDescriptionEntity
     * @throws \Amarkhai\AirbnbSdk\Exceptions\EmptyRequiredFieldsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getListingDescription(
        int $listingID,
        string $userToken,
        string $locale = 'en'
    ): ListingDescriptionEntity {
        $url = self::BASE_URL . self::ENDPOINT . $listingID . '/' . $locale;

        $response = $this->httpClient->get($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ],
        ]);

        $descriptionData = json_decode($response->getBody()->getContents(), true)['listing_description'];

        return ListingDescriptionEntity::createByArray($descriptionData);
    }

    /**
     * Delete a listing's description for a locale.
     *
     * @param int $listingID
     * @param string $userToken
     * @param string $locale
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteListingDescription(int $listingID, string $userToken, string $locale = 'en'): void
    {
        $url = self::BASE_URL . self::ENDPOINT . $listingID . '/' . $locale;

        $this->httpClient->delete($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ],
        ]);
    }
}
