<?php

namespace Amarkhai\AirbnbSdk\Services\Listings;

use Amarkhai\AirbnbSdk\Entities\BookingSettingsEntity;
use Amarkhai\AirbnbSdk\Services\AirbnbBaseService;

/**
 * The service for working with the "booking_settings/" endpoint
 */
class BookingSettingsService extends AirbnbBaseService
{
    /**
     * Booking settings API endpoint
     */
    private const ENDPOINT = 'booking_settings/';


    /**
     * @param int $listingID
     * @param string $userToken
     * @return BookingSettingsEntity
     * @throws \Amarkhai\AirbnbSdk\Exceptions\EmptyRequiredFieldsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getBookingSettings(int $listingID, string $userToken): BookingSettingsEntity
    {
        $url = self::BASE_URL . self::ENDPOINT . $listingID;

        $response = $this->httpClient->get($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ],
        ]);

        $bookingSettingsData = json_decode($response->getBody()->getContents(), true)['booking_setting'];

        return BookingSettingsEntity::createByArray($bookingSettingsData);
    }

    /**
     * @param int $listingID
     * @param BookingSettingsEntity $bookingSettings
     * @param string $userToken
     * @return BookingSettingsEntity
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateBookingSettings(
        int $listingID,
        BookingSettingsEntity $bookingSettings,
        string $userToken
    ): BookingSettingsEntity {
        $url = self::BASE_URL . self::ENDPOINT . $listingID;

        $response = $this->httpClient->put($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ],
            'json' => $bookingSettings->exportAsArray(true)
        ]);

        $updatedBookingSettingsData = json_decode($response->getBody()->getContents(), true)['booking_setting'];

        return $bookingSettings->fillByArray($updatedBookingSettingsData);
    }
}
