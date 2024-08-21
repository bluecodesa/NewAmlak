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

    public function __construct()
    {
        $this->appId = env('NAFATH_APP_ID');
        $this->appKey = env('NAFATH_APP_KEY');
    }

    public function validateIdNumber($idNumber)
    {
        $response = Http::withHeaders([
            'Application-ID' => $this->appId,
            'Application-Key' => $this->appKey,
            ])->timeout(60) // Increase timeout to 30 seconds
            ->post('https://iam2-qa-api.dev-apps.elm.sa:433/validate-id', [
                'id_number' => $idNumber,
            ]);

        return $response->json();
    }
}
