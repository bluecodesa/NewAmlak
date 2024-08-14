<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NafathService
{
    protected $appId;
    protected $appKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->appId = '1b93b92a'; // Replace with your actual Application ID
        $this->appKey = '5a6c7fe47172db303bcc4e9adfd9a4aa'; // Replace with your actual Application Key
        $this->baseUrl = 'http://iam2-qa-api.dev-apps.elm.sa';
    }

    /**
     * Validate an ID number with Nafath.
     *
     * @param string $idNumber
     * @return array
     */
    public function validateId($idNumber)
    {
        try {
            $response = Http::timeout(60)->withHeaders([
                'APP-ID' => $this->appId,
                'APP-KEY' => $this->appKey,
            ])->post("{$this->baseUrl}/validate-id", [
                'id_number' => $idNumber,
            ]);
            dd($idNumber);

            if ($response->successful()) {
                return $response->json();
            } else {
                return [
                    'status' => 'error',
                    'message' => 'API returned an error: ' . $response->status() . ' - ' . $response->body(),
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Request failed: ' . $e->getMessage(),
            ];
        }
    }
}
