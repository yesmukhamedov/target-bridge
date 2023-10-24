<?php
//
//namespace App\Services;
//
//use Illuminate\Support\Facades\Cache;
//use GuzzleHttp\Client;
//use GuzzleHttp\Exception\RequestException;
//
//class TokenService
//{
//    public function getToken()
//    {
//        return Cache::remember('access_token', now()->addMinutes(60), function () {
//            return $this->fetchNewToken();
//        });
//    }
//
//    public function fetchNewToken()
//    {
//        $client = new Client();
//        $credentials = [
//            'grant_type' => 'password',
//            'username' => 'Azamat',
//            'password' => 'Almaty2020',
//        ];
//
//        try {
//            $response = $client->post('http://192.168.0.25:32001/oauth/token', [
//                'form_params' => $credentials,
//            ]);
//
//            $data = json_decode($response->getBody(), true);
//            return $data['access_token'];
//        } catch (RequestException $e) {
//            // Обработка ошибки при получении нового токена
//            throw $e;
//        }
//    }
//}
