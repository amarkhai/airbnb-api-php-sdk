<?php

namespace Amarkhai\AirbnbSdk\Services\Listings;

use Amarkhai\AirbnbSdk\Services\AirbnbBaseService;

/**
 * The service for working with the "calendar_operations_requests/" endpoint
 *
 * The number of total dates in one call can be no more than 731 (2 years).One call can have multiple operations, and
 * each operation can have multiple dates, but the aggregated total number of dates of all operations must be equal to
 * or less than 731.
 */
class CalendarBatchOperationsService extends AirbnbBaseService
{
    public const MIN_PRICE = 10;
    /**
     * Calendar operations API endpoint
     */
    private const ENDPOINT = 'calendar_operations_requests/';

    /**
     * @param int $listingID
     * @param array[] $operations - Batch changes to the listing's calendar into an Operations array. You can include
     * multiple Operations arrays in one call.
     *
     * array like
     * [['dates' => string[], 'daily_price' => int, 'availability' => string, 'min_nights' => int, 'max_nights' => int,
     * 'closed_to_arrival' => bool, 'closed_to_departure' => bool, 'notes' => string, 'available_count' => int], ...]
     *
     * dates - To specify a single date, the string should be one date in ISO-8601 format. For example: YYYY-MM-DD.
     *   To specify a date range, specify the start and end date separated by a colon.
     *   For example: YYYY-MM-DD:YYYY-MM-DD
     * daily_price - Nightly price for days in this range. Minimum is the equivalent of 25 USD; max is the equivalent
     *   of 25000 USD. 0 is allowed for test listings created in sandbox app for making test reservations. Non-zero
     *   value less than minimum is not allowed for test listings.
     * availability - Explicitly setting this range to un/available will override the default value.
     * min_nights - Minimum length of stay.
     * max_nights - Maximum length of stay.
     * closed_to_arrival - When true, the guest cannot check in on the specified day(s).
     * closed_to_departure - When true, the guest cannot check out on the specified day(s).
     * notes - Optional notes.
     * available_count - This parameter only applies to listings using Room Type inventory. The total number of a
     *   specific room type. Booking a room does not remove it from this total. Minimum: 0 Maximum: 500.
     * @param string $userToken
     * @param bool $allowDatesOverlap When true, dates can overlap across operations in the same request. Operations
     *   are executed in order as they are in the array. If dates overlap, the latter operation will override the
     *   previous operation for the same date. When false, dates cannot overlap and the API will raise an error if
     *   overlapped dates are detected. Default is false.
     *
     * @return bool is calendar updated successfully or not
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateCalendar(
        int $listingID,
        array $operations,
        string $userToken,
        bool $allowDatesOverlap = false
    ): bool {
        $url = self::BASE_URL . self::ENDPOINT;

        $queryParameters = [];
        if ($allowDatesOverlap) {
            $queryParameters['_allow_dates_overlap'] = true;
        }

        $response = $this->httpClient->post($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ],
            'query' => $queryParameters,
            'json' => [
                'listing_id' => $listingID,
                'operations' => $operations,
            ]
        ]);

        return json_decode(
            $response->getBody()->getContents(),
            true
        )['success'];
    }
}
