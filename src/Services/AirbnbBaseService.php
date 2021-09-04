<?php

namespace Amarkhai\AirbnbSdk\Services;

use Amarkhai\AirbnbSdk\Http\AirbnbClient;

/**
 * Base class for Airbnb API services
 */
abstract class AirbnbBaseService
{
    /**
     * Base URL for Airbnb API
     */
    protected const BASE_URL = 'https://api.airbnb.com/v2/';

    /**
     * @var AirbnbClient
     */
    protected $httpClient;

    /**
     * AirbnbBaseService constructor.
     */
    public function __construct(AirbnbClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }
}
