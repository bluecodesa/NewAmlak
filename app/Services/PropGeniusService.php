<?php

namespace App\Services;

use GuzzleHttp\Client;

class PropGeniusService
{
    protected $client;
    protected $apiKey;
    protected $apiSecret;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = 'iwA5l5Q+npR4x501P/IxdZtyLZ//Rbsns1pZlBGo5Ig=';
        $this->apiSecret = 'KUEsUCUliINg6bvUy2K50wlTudgTNRFtdEHt/NA4JxdFNpVXrZ+mKH6zZu9U1YVP';
    }

    public function getAccessToken()
    {
        $response = $this->client->get('https://api.propgenius.ai/humantorch/v1/client/access-token', [
            'headers' => [
                'Content-Type' => 'application/json',
                'api_key' => $this->apiKey,
                'api_secret' => $this->apiSecret,
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        // dd($data); // Debugging line to check the response
        return $data['data']['token'];
    }

    public function generateDescription(array $propertyDetails)
    {
        $accessToken = $this->getAccessToken();

        $response = $this->client->post('https://api.propgenius.ai/thor/v1/products/client-explore-product', [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
                'locale' => 'en',
            ],
            'json' => $propertyDetails,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
