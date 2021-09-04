<?php

namespace Amarkhai\AirbnbSdk\Http;

use GuzzleHttp\Client;
use Psr\Http\Message\UriInterface;

/**
 * HTTP Client based on GuzzleHttp\Client
 */
class AirbnbClient extends Client
{
    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    /**
     * @param UriInterface|string $uri
     * @param array $options
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(string $uri, array $options = []): \Psr\Http\Message\ResponseInterface
    {
        return $this->query('get', $uri, $options);
    }

    /**
     * @param UriInterface|string $uri
     * @param array $options
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post(string $uri, array $options = []): \Psr\Http\Message\ResponseInterface
    {
        return $this->query('post', $uri, $options);
    }

    /**
     * @param UriInterface|string $uri
     * @param array $options
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function put(string $uri, array $options = []): \Psr\Http\Message\ResponseInterface
    {
        return $this->query('put', $uri, $options);
    }

    /**
     * @param UriInterface|string $uri
     * @param array $options
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function patch(string $uri, array $options = []): \Psr\Http\Message\ResponseInterface
    {
        return $this->query('patch', $uri, $options);
    }

    /**
     * @param UriInterface|string $uri
     * @param array $options
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete(string $uri, array $options = []): \Psr\Http\Message\ResponseInterface
    {
        return $this->query('delete', $uri, $options);
    }


    /**
     * @param string $method
     * @param UriInterface|string $uri
     * @param array $options
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function query(
        string $method,
        string $uri,
        array $options = []
    ): \Psr\Http\Message\ResponseInterface {
        // Required headers for requests to Airbnb API
        $options['headers']['User-Agent'] = config('airbnb.api.app_name');
        $options['headers']['Content-Type'] = 'application/json';
        $options['headers']['Accept'] = 'application/json';
        $options['auth'] = [
            config('airbnb.api.client_id'),
            config('airbnb.api.client_secret')
        ];
        return parent::request(strtoupper($method), $uri, $options);
    }
}
