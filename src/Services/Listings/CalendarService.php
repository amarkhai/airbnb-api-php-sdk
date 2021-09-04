<?php

namespace Amarkhai\AirbnbSdk\Services\Listings;

use Amarkhai\AirbnbSdk\Services\AirbnbBaseService;
use Amarkhai\AirbnbSdk\Entities\CalendarOperationEntity;

/**
 * The service for working with the "calendars/" endpoint
 */
class CalendarService extends AirbnbBaseService
{
    /**
     * Calendar API endpoint
     */
    private const ENDPOINT = 'calendars/';

    /**
     * @param int $listingID
     * @param \DateTime $dateStart
     * @param \DateTime $dateEnd
     * @param string $userToken
     * @return array|null
     * array like
     * [['availability' => string, 'availability_sub_type' => string, 'availability_type' => string,
     *   'closed_to_arrival' => bool, 'closed_to_departure' => bool, 'daily_price' => float, 'date' => string
     *   'max_nights' => int, 'min_nights' => int, 'notes' => string?], ...]
     *
     * availability - Either "available", "unavailable" or "default". Please use "default" instead of "available" if
     *   you want the day to comply with any availability rules you set, since "available" overwrites any availability
     *   rules.
     * availability_sub_type - A detailed breakdown of the availability_type field.
     * availability_type - A detailed breakdown of the availability field.
     * closed_to_arrival - When true, the guest cannot check in on this day. default is false
     * closed_to_departure - When true, the guest cannot check out on this day. default is false
     * daily_price - Nightly price for this day. Minimum = 10 USD, maximum = 25000 USD.0 is allowed for test listings
     *   created in sandbox app for making test reservations. Non-zero value less than minimum is not allowed for test
     *   listings.
     * date - Date in ISO 8601 YYYY-MM-DD format.
     * max_nights - Maximum length of stay if the trip starts on this day. Use null to unset this value.
     * min_nights - Minimum length of stay if the trip starts on this day. Use null to unset this value.
     * notes - Optional notes.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getDaysBetweenStartAndEnd(
        int $listingID,
        \DateTime $dateStart,
        \DateTime $dateEnd,
        string $userToken
    ): ?array {
        $url = sprintf(
            '%s/%s/%s/%s',
            self::BASE_URL . self::ENDPOINT,
            $listingID,
            $dateStart->format('Y-m-d'),
            $dateEnd->format('Y-m-d')
        );

        $response = $this->httpClient->get($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true)['calendar']['days'] ?? null;
    }

    /**
     * @param int $listingID
     * @param \DateTime $dateStart
     * @param \DateTime $dateEnd
     * @param CalendarOperationEntity $calendarOperationEntity
     * @param string $userToken
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateCalendar(
        int $listingID,
        \DateTime $dateStart,
        \DateTime $dateEnd,
        CalendarOperationEntity $calendarOperationEntity,
        string $userToken
    ): ?array {
        $url = sprintf(
            '%s/%s/%s/%s',
            self::BASE_URL . self::ENDPOINT,
            $listingID,
            $dateStart->format('Y-m-d'),
            $dateEnd->format('Y-m-d')
        );

        $response = $this->httpClient->put($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ],
            'json' => $calendarOperationEntity->exportAsArray(true),
        ]);

        return json_decode(
            $response->getBody()->getContents(),
            true
        )['calendar']['days'] ?? null;
    }
}
