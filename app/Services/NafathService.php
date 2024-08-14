<?php
namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class NafathService
{
    protected $client;
    protected $baseUri;

    public function __construct()
    {
        $this->client = new Client();
        $this->baseUri = config('services.nafath.base_uri');
    }

    public function validateId($idNumber)
    {
        try {
            $response = $this->client->post($this->baseUri . '/validate-id', [
                'json' => [
                    'id_number' => $idNumber,
                ]
            ]);
            dd($response);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            // Handle exception
            return null;
        }
    }

    public function getUserDetails($token)
    {
        try {
            $response = $this->client->get($this->baseUri . '/user', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            // Handle exception
            return null;
        }
    }

    public function getAccessToken($authorizationCode)
    {
        try {
            $response = $this->client->post($this->baseUri . '/oauth/token', [
                'form_params' => [
                    'grant_type' => 'authorization_code',
                    'client_id' => env('NAFATH_CLIENT_ID'),
                    'client_secret' => env('NAFATH_CLIENT_SECRET'),
                    'code' => $authorizationCode,
                    'redirect_uri' => env('NAFATH_REDIRECT_URI'),
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            // Handle exception
            return null;
        }
    }
}
