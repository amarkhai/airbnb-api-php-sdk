<?php

namespace Amarkhai\AirbnbSdk\Services\Message;

use Amarkhai\AirbnbSdk\Entities\MessageEntity;
use Amarkhai\AirbnbSdk\Entities\Nested\ThreadMessage;
use Amarkhai\AirbnbSdk\Services\AirbnbBaseService;

/**
 * The service for working with the "messages/" endpoint
 */
class MessageService extends AirbnbBaseService
{
    /**
     * Listings photos API endpoint
     */
    private const ENDPOINT = 'messages/';

    /**
     * Send text or image as a single message.
     * @param MessageEntity $messageEntity
     * @param string $userToken
     * @return ThreadMessage
     * @throws \Amarkhai\AirbnbSdk\Exceptions\EmptyRequiredFieldsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendMessage(MessageEntity $messageEntity, string $userToken): ThreadMessage
    {
        $url = self::BASE_URL . self::ENDPOINT;

        $response = $this->httpClient->post($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ],
            'json' => $messageEntity->exportAsArray(true)
        ]);

        $messageData = json_decode($response->getBody()->getContents(), true)['message'];

        return ThreadMessage::createByArray($messageData);
    }
}
