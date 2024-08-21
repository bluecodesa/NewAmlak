<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

// class NafathService
// {
//     protected $appId;
//     protected $appKey;
//     protected $baseUrl;

//     public function __construct()
//     {
//         $this->appId = '1b93b92a'; 
//         $this->appKey = '5a6c7fe47172db303bcc4e9adfd9a4aa'; 
//         $this->baseUrl = 'http://iam2-qa-api.dev-apps.elm.sa';
//     }


//     public function validateId($idNumber)
//     {
//         try {
//             $response = Http::timeout(60)->withHeaders([
//                 'APP-ID' => $this->appId,
//                 'APP-KEY' => $this->appKey,
//             ])->post("{$this->baseUrl}/validate-id", [
//                 'id_number' => $idNumber,
//             ]);
//             dd($idNumber);

//             if ($response->successful()) {
//                 return $response->json();
//             } else {
//                 return [
//                     'status' => 'error',
//                     'message' => 'API returned an error: ' . $response->status() . ' - ' . $response->body(),
//                 ];
//             }
//         } catch (\Exception $e) {
//             return [
//                 'status' => 'error',
//                 'message' => 'Request failed: ' . $e->getMessage(),
//             ];
//         }
//     }
// }


class NafathService
{
    protected $appId;
    protected $appKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->appId = env('NAFATH_APP_ID');
        $this->appKey = env('NAFATH_APP_KEY');
        $this->baseUrl = 'https://Iam2-qa-api.dev-apps.elm.sa:433'; // Pre-production URL
    }

    protected function headers()
    {
        return [
            'APP-ID' => $this->appId,
            'APP-KEY' => $this->appKey,
        ];
    }

    // Method to retrieve URL for IAM page
    public function retrieveIamPage($locale = 'ar', $requestId)
    {
        $response = Http::withHeaders($this->headers())
            ->get("{$this->baseUrl}/api/v1/oidc/session", [
                'locale' => $locale,
                'requestId' => $requestId,
            ]);

        return $response->json();
    }

    // Method to retrieve JWK
    public function retrieveJwk()
    {
        $response = Http::withHeaders($this->headers())
            ->get("{$this->baseUrl}/api/v1/oidc/jwk");

        return $response->json();
    }

    // Method to verify JWK
    public function verifyJwk($organizationNumber, $platformKey, $requestNumber, $token)
    {
        $response = Http::withHeaders([
            'ORGANIZATION-NUMBER' => $organizationNumber,
            'PLATFORM-KEY' => $platformKey,
            'REQUEST-NUMBER' => $requestNumber,
        ])->put("{$this->baseUrl}/api/oidc/jwt/valid", $token);

        return $response->json();
    }
}
