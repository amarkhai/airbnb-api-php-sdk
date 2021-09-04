<?php

namespace Amarkhai\AirbnbSdk\Services\Listings;

use Amarkhai\AirbnbSdk\Entities\ListingPhotoEntity;
use Amarkhai\AirbnbSdk\Services\AirbnbBaseService;

/**
 * The service for working with the "listing_photos/" endpoint
 */
class ListingPhotoService extends AirbnbBaseService
{
    /**
     * Listings photos API endpoint
     */
    private const ENDPOINT = 'listing_photos/';

    /**
     * Upload a new photo associated with an existing listing.
     *
     * @param ListingPhotoEntity $photo
     * @param string $userToken
     * @return ListingPhotoEntity
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function uploadPhoto(ListingPhotoEntity $photo, string $userToken): ListingPhotoEntity
    {
        $url = self::BASE_URL . self::ENDPOINT;

        $response = $this->httpClient->post($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ],
            'json' => $photo->exportAsArray(true)
        ]);

        $uploadedPhoto = json_decode($response->getBody()->getContents(), true)['listing_photo'];

        return $photo->fillByArray($uploadedPhoto);
    }

    /**
     * The two photo properties you can update are caption and sort_order.
     *
     * @param ListingPhotoEntity $photo
     * @param string $userToken
     * @return ListingPhotoEntity
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updatePhoto(ListingPhotoEntity $photo, string $userToken): ListingPhotoEntity
    {
        $url = self::BASE_URL . self::ENDPOINT . $photo->getId();

        $body = [];

        if (!is_null($photo->getCaption())) {
            $body['caption'] = $photo->getCaption();
        }

        if (!is_null($photo->getSortOrder())) {
            $body['sort_order'] = $photo->getSortOrder();
        }

        $response = $this->httpClient->put($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ],
            'json' => $body
        ]);

        $uploadedPhoto = json_decode($response->getBody()->getContents(), true)['listing_photo'];

        return $photo->fillByArray($uploadedPhoto);
    }

    /**
     * Gets all photos for a given listing.
     *
     * @param string $listingID
     * @param string $userToken
     * @return ListingPhotoEntity[]
     * @throws \Amarkhai\AirbnbSdk\Exceptions\EmptyRequiredFieldsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAllListingPhotos(string $listingID, string $userToken): array
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

        $photos = json_decode($response->getBody()->getContents(), true)['listing_photos'];

        $result = [];
        foreach ($photos as $photo) {
            $result[] = ListingPhotoEntity::createByArray($photo);
        }

        return $result;
    }

    /**
     * Gets a photo with a given photo ID
     *
     * @param string $photoID
     * @param string $userToken
     * @return ListingPhotoEntity
     * @throws \Amarkhai\AirbnbSdk\Exceptions\EmptyRequiredFieldsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getListingPhoto(string $photoID, string $userToken): ListingPhotoEntity
    {
        $url = self::BASE_URL . self::ENDPOINT . $photoID;

        $response = $this->httpClient->get($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ],
        ]);

        $photo = json_decode($response->getBody()->getContents(), true)['listing_photo'];

        return ListingPhotoEntity::createByArray($photo);
    }

    /**
     * Delete photo with a given photo ID
     *
     * @param ListingPhotoEntity $photo
     * @param string $userToken
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteListingPhoto(ListingPhotoEntity $photo, string $userToken): void
    {
        $url = self::BASE_URL . self::ENDPOINT . $photo->getId();

        $this->httpClient->delete($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ],
        ]);
    }
}
