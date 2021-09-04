<?php

namespace Amarkhai\AirbnbSdk\Services\Listings;

use Amarkhai\AirbnbSdk\Entities\PricingSettingsEntity;
use Amarkhai\AirbnbSdk\Services\AirbnbBaseService;

/**
 * The service for working with the "pricing_settings/" endpoint
 */
class PricingSettingsService extends AirbnbBaseService
{
    /**
     * Pricing settings API endpoint
     */
    private const ENDPOINT = 'pricing_settings/';

    /**
     * @param int $listingID
     * @param string $userToken
     * @return PricingSettingsEntity
     * @throws \Amarkhai\AirbnbSdk\Exceptions\EmptyRequiredFieldsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPricingSettings(int $listingID, string $userToken): PricingSettingsEntity
    {
        $url = self::BASE_URL . self::ENDPOINT . $listingID;

        $response = $this->httpClient->get($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ],
        ]);

        $pricingSettingsData = json_decode($response->getBody()->getContents(), true)['pricing_setting'];

        return PricingSettingsEntity::createByArray($pricingSettingsData);
    }

    /**
     * @param int $listingID
     * @param PricingSettingsEntity $pricingSettings
     * @param string $userToken
     * @param bool $updateCurrency if we want to update currency, we need to send only currency filed, without others
     * @return PricingSettingsEntity
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updatePricingSettings(
        int $listingID,
        PricingSettingsEntity $pricingSettings,
        string $userToken,
        bool $updateCurrency = false
    ): PricingSettingsEntity {
        $url = self::BASE_URL . self::ENDPOINT . $listingID;

        $data = $pricingSettings->exportAsArray(true);
        // The currency field cannot be saved with other price fields.
        if ($updateCurrency) {
            $data = [
                'listing_currency' => $data['listing_currency']
            ];
        } else {
            unset($data['listing_currency']);
        }
        $response = $this->httpClient->put($url, [
            'headers' => [
                'X-Airbnb-API-Key' => config('airbnb.api.client_id'),
                'X-Airbnb-Oauth-Token' => $userToken,
            ],
            'json' => $data
        ]);

        $updatedPricingSettingsData = json_decode($response->getBody()->getContents(), true)['pricing_setting'];

        return $pricingSettings->fillByArray($updatedPricingSettingsData);
    }
}
