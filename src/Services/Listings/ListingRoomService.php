<?php

namespace Amarkhai\AirbnbSdk\Services\Listings;

use Amarkhai\AirbnbSdk\Entities\ListingRoomEntity;
use Amarkhai\AirbnbSdk\Services\AirbnbBaseService;

/**
 * The service for working with the "listing_rooms/" endpoint
 */
class ListingRoomService extends AirbnbBaseService
{
    /**
     * Listings rooms API endpoint
     */
    private const ENDPOINT = 'listing_rooms/';

    /**
     * describe a new room associated with an existing listing.
     *
     * @param ListingRoomEntity $room
     * @param string $userToken
     * @return ListingRoomEntity
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function describeNewRoom(ListingRoomEntity $room, string $userToken): ListingRoomEntity
    {
        $url = self::BASE_URL . self::ENDPOINT;

        $response = $this->httpClient->post($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ],
            'json' => $room->exportAsArray(true)
        ]);

        $roomData = json_decode($response->getBody()->getContents(), true)['listing_room'];

        return $room->fillByArray($roomData);
    }

    /**
     * Gets all rooms for a given listing.
     *
     * @param string $listingID
     * @param string $userToken
     * @return ListingRoomEntity[]
     * @throws \Amarkhai\AirbnbSdk\Exceptions\EmptyRequiredFieldsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAllListingRooms(string $listingID, string $userToken): array
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

        $photos = json_decode($response->getBody()->getContents(), true)['listing_rooms'];

        $result = [];
        foreach ($photos as $photo) {
            $result[] = ListingRoomEntity::createByArray($photo);
        }

        return $result;
    }

    /**
     * You can update the bed and bathroom configurations for each room. Note that the fields not passed in the payload
     * will not be updated.
     *
     * @param ListingRoomEntity $room
     * @param string $userToken
     * @return ListingRoomEntity
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateRoom(ListingRoomEntity $room, string $userToken): ListingRoomEntity
    {
        $url = self::BASE_URL . self::ENDPOINT . $room->getListingId() . '/' . $room->getId();

        $response = $this->httpClient->put($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ],
            'json' => $room->exportAsArray(true)
        ]);

        $roomData = json_decode($response->getBody()->getContents(), true)['listing_room'];

        return $room->fillByArray($roomData);
    }

    /**
     * Gets a room with a given room ID
     *
     * @param int $roomID
     * @param int $listingID
     * @param string $userToken
     * @return ListingRoomEntity
     * @throws \Amarkhai\AirbnbSdk\Exceptions\EmptyRequiredFieldsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRoom(int $roomID, int $listingID, string $userToken): ListingRoomEntity
    {
        $url = self::BASE_URL . self::ENDPOINT . $listingID . '/' . $roomID;

        $response = $this->httpClient->get($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ],
        ]);

        $roomData = json_decode($response->getBody()->getContents(), true)['listing_room'];

        return ListingRoomEntity::createByArray($roomData);
    }

    /**
     * Delete a room with a given listing ID and room ID
     *
     * @param ListingRoomEntity $room
     * @param string $userToken
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteRoom(ListingRoomEntity $room, string $userToken): void
    {
        $url = self::BASE_URL . self::ENDPOINT . $room->getListingId() . '/' . $room->getId();

        $this->httpClient->delete($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ],
        ]);
    }
}
