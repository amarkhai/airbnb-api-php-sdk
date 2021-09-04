<?php

namespace Amarkhai\AirbnbSdk\Services\Listings;

use Amarkhai\AirbnbSdk\Entities\Parameters\AcceptOrDenyPendingReservationRequestParameters;
use Amarkhai\AirbnbSdk\Entities\Parameters\CancelActiveReservationParameters;
use Amarkhai\AirbnbSdk\Entities\Parameters\RetrieveAllReservationsParameters;
use Amarkhai\AirbnbSdk\Entities\ReservationEntity;
use Amarkhai\AirbnbSdk\Services\AirbnbBaseService;

/**
 * The service for working with the "reservations/" endpoint
 */
class ReservationService extends AirbnbBaseService
{
    /**
     * Reservation API endpoint
     */
    private const ENDPOINT = 'reservations/';

    /**
     * @param RetrieveAllReservationsParameters $parametersEntity
     * @param string $userToken
     * @return ReservationEntity[]
     * @throws \Amarkhai\AirbnbSdk\Exceptions\EmptyRequiredFieldsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function retrieveAllReservations(
        RetrieveAllReservationsParameters $parametersEntity,
        string $userToken
    ): array {
        $url = self::BASE_URL . self::ENDPOINT;

        $response = $this->httpClient->get($url, [
        'headers' => [
            'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
            'X-Airbnb-Oauth-Token' => $userToken,
        ],
        'query' => $parametersEntity->exportAsArray(true)
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        $reservationsData = $data['reservations'];

        $result = [];
        foreach ($reservationsData as $reservationData) {
            $result[] = ReservationEntity::createByArray($reservationData);
        }

        return [
            'reservations' => $result,
            'paging' => $data['paging'],
        ];
    }

    /**
     * @param string $confirmationCode
     * @param AcceptOrDenyPendingReservationRequestParameters $bodyParameters
     * @param string $userToken
     * @return ReservationEntity
     * @throws \Amarkhai\AirbnbSdk\Exceptions\EmptyRequiredFieldsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function acceptOrDenyPendingRequest(
        string $confirmationCode,
        AcceptOrDenyPendingReservationRequestParameters $bodyParameters,
        string $userToken
    ): ReservationEntity {
        $url = self::BASE_URL . self::ENDPOINT . $confirmationCode;

        $response = $this->httpClient->put($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ],
            'json' => $bodyParameters->exportAsArray(true),
        ]);

        $reservationData = json_decode($response->getBody()->getContents(), true)['reservation'];

        return ReservationEntity::createByArray($reservationData);
    }

    /**
     * @param string $confirmationCode
     * @param string $userToken
     * @return ReservationEntity
     * @throws \Amarkhai\AirbnbSdk\Exceptions\EmptyRequiredFieldsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getReservation(string $confirmationCode, string $userToken): ReservationEntity
    {
        $url = self::BASE_URL . self::ENDPOINT . $confirmationCode;

        $response = $this->httpClient->get($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ],
        ]);

        $listingData = json_decode($response->getBody()->getContents(), true)['reservation'];

        return ReservationEntity::createByArray($listingData);
    }

    /**
     * @param string $confirmationCode
     * @param CancelActiveReservationParameters $bodyParameters
     * @param string $userToken
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function cancelActiveReservation(
        string $confirmationCode,
        CancelActiveReservationParameters $bodyParameters,
        string $userToken
    ): void {
        $url = self::BASE_URL . self::ENDPOINT . $confirmationCode;

        $this->httpClient->put($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ],
            'json' => $bodyParameters->exportAsArray(true),
        ]);
    }
}
