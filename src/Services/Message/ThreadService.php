<?php

namespace Amarkhai\AirbnbSdk\Services\Message;

use Amarkhai\AirbnbSdk\Entities\ThreadEntity;
use Amarkhai\AirbnbSdk\Services\AirbnbBaseService;

/**
 * The service for working with the "threads/" endpoint
 */
class ThreadService extends AirbnbBaseService
{
    /**
     * Listings descriptions API endpoint
     */
    private const ENDPOINT = 'threads/';

    /**
     * @param string $userToken
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Amarkhai\AirbnbSdk\Exceptions\EmptyRequiredFieldsException
     */
    public function getAllThreads(string $userToken): array
    {
        $url = self::BASE_URL . self::ENDPOINT;

        $response = $this->httpClient->get($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ]
        ]);

        $threads = json_decode($response->getBody()->getContents(), true)['threads'];

        $result = [];
        foreach ($threads as $thread) {
            $result[] = ThreadEntity::createByArray($thread);
        }

        return $result;
    }

    /**
     * @param int $threadID ID of the thread.
     * @param string $userToken
     * @return ThreadEntity
     * @throws \Amarkhai\AirbnbSdk\Exceptions\EmptyRequiredFieldsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getThreadByID(int $threadID, string $userToken): ThreadEntity
    {
        $url = self::BASE_URL . self::ENDPOINT . $threadID;

        $response = $this->httpClient->get($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ],
        ]);

        $threadData = json_decode($response->getBody()->getContents(), true)['thread'];

        return ThreadEntity::createByArray($threadData);
    }
}
