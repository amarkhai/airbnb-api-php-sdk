<?php

namespace Amarkhai\AirbnbSdk\Services\Listings;

use Amarkhai\AirbnbSdk\Entities\ReservationAlterationEntity;
use Amarkhai\AirbnbSdk\Services\AirbnbBaseService;

/**
 * The service for working with the "reservation_alterations/" endpoint
 */
class AirbnbReservationAlterationService extends AirbnbBaseService
{
    /**
     * Reservation alteration API endpoint
     */
    private const ENDPOINT = 'reservation_alterations/';
    /**
     * List of statuses which we can send in the updatePendingReservationRequest
     */
    public const ALLOWED_STATUSES_FOR_UPDATE_REQUEST = [
        'ACCEPTED',
        'CANCELED',
        'DECLINED'
    ];

    /**
     * @param string $confirmationCode
     * @param string $userToken
     * @return array
     * @throws \Amarkhai\AirbnbSdk\Exceptions\EmptyRequiredFieldsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAllAlterationsByReservationCode(
        string $confirmationCode,
        string $userToken
    ): array {
        $url = self::BASE_URL . self::ENDPOINT;

        $response = $this->httpClient->get($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ],
            'query' => [
                'confirmation_codes[]' => $confirmationCode
            ]
        ]);

        $alterationsData = json_decode($response->getBody()->getContents(), true)['reservation_alterations'];

        $result = [];
        foreach ($alterationsData as $alterationData) {
            $result[] = ReservationAlterationEntity::createByArray($alterationData);
        }

        return $result;
    }

    /**
     * @param int $alterationID ID in Airbnb
     * @param string $userToken
     * @return ReservationAlterationEntity
     * @throws \Amarkhai\AirbnbSdk\Exceptions\EmptyRequiredFieldsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAlterationByID(int $alterationID, string $userToken): ReservationAlterationEntity
    {
        $url = self::BASE_URL . self::ENDPOINT . $alterationID;

        $response = $this->httpClient->get($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ],
        ]);

        $alterationData = json_decode($response->getBody()->getContents(), true)['reservation_alteration'];

        return ReservationAlterationEntity::createByArray($alterationData);
    }


    /**
     * @param int $alterationID ID in Airbnb
     * @param string $status must be one of [ACCEPTED, CANCELED, DECLINED]
     * @param string $userToken
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updatePendingReservationRequest(int $alterationID, string $status, string $userToken): void
    {
        $url = self::BASE_URL . self::ENDPOINT . $alterationID;

        $this->httpClient->put($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ],
            'json' => [
                'status' => $status
            ]
        ]);
    }
}
