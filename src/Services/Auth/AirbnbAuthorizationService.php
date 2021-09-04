<?php

namespace Amarkhai\AirbnbSdk\Services\Auth;

use Amarkhai\AirbnbSdk\Services\AirbnbBaseService;

/**
 * The service for working with the "oauth2/authorizations/" endpoint
 */
class AirbnbAuthorizationService extends AirbnbBaseService
{
    /**
     * OAuth API endpoint
     */
    private const ENDPOINT = 'oauth2/authorizations/';

    /**
     * Exchange Code for Tokens
     *
     * @param string $code
     * @return array{access_token: string, expires_at: int, refresh_token: string, user_id: int}
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function exchangeCodeForTokens(string $code): array
    {
        $url = self::BASE_URL . self::ENDPOINT;

        $response = $this->httpClient->post($url, [
            'query' => [
                '_unwrapped' => true
            ],
            'json' => [
                'code' => $code
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Check Token Status. Return true if token is valid, false otherwise
     *
     * @param string $token
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function checkTokenStatus(string $token): bool
    {
        $url = self::BASE_URL . self::ENDPOINT . $token;

        $response = $this->httpClient->get($url, [
            'query' => [
                '_unwrapped' => true
            ],
        ]);

        $tokenInfo = json_decode($response->getBody()->getContents(), true);

        if ($tokenInfo['oauth2_authorization']['valid'] === true) {
            return true;
        }

        return false;
    }

    /**
     * Refresh a token. If $resetRefreshToken == true method will refresh refresh_token too
     * Returned array is like
     * ['access_token' => string, 'expires_at' => int, 'refresh_token' => string, 'user_id' => int]
     *
     * @param string $refreshToken
     * @param bool $resetRefreshToken Only use this parameter if you think your refresh token was compromised
     * @return array{access_token: string, expires_at: int, refresh_token: string, user_id: int}
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function refreshToken(string $refreshToken, bool $resetRefreshToken = false): array
    {
        $url = self::BASE_URL . self::ENDPOINT;

        $response = $this->httpClient->post($url, [
            'query' => [
                '_unwrapped' => true
            ],
            'json' => [
                'refresh_token' => $refreshToken,
                'reset_refresh_token' => intval($resetRefreshToken),
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Revoke token
     *
     * @param string $refreshToken
     * @return array{user_id: int, valid: bool}
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function revokeToken(string $refreshToken): array
    {
        $url = self::BASE_URL . self::ENDPOINT . $refreshToken;

        $response = $this->httpClient->delete($url, [
            'query' => [
                '_unwrapped' => true
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
