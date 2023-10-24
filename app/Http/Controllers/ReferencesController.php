<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Config;

class ReferencesController extends Controller
{
    public function fetchBusinessAreaOptions()
    {
        $client = new Client();
        $environment = app()->environment();
        $apiUrl = config("api.$environment");

        try {
            $response = $client->get("$apiUrl/api/crm2/target/businessAreaOptions");
            $data = json_decode($response->getBody(), true);

            return response()->json($data);
        } catch (RequestException $e) {
            return response()->json(['error' => 'Ошибка при выполнении GET-запроса: ' . $e->getMessage()], 500);
        }
    }

    public function fetchLocationOptions()
    {
        $client = new Client();
        $environment = app()->environment();
        $apiUrl = config("api.$environment");

        try {
            $response = $client->get("$apiUrl/api/crm2/target/locationOptions");
            $data = json_decode($response->getBody(), true);

            return response()->json($data);
        } catch (RequestException $e) {
            return response()->json(['error' => 'Ошибка при выполнении GET-запроса: ' . $e->getMessage()], 500);
        }
    }

    public function fetchSourceAppealOptions()
    {
        $client = new Client();
        $environment = app()->environment();
        $apiUrl = Config::get("api.$environment");

        try {
            $response = $client->get("$apiUrl/api/crm2/target/sourceAppealOptions");
            $data = json_decode($response->getBody(), true);

            return response()->json($data);
        } catch (RequestException $e) {
            return response()->json(['error' => 'Ошибка при выполнении GET-запроса: ' . $e->getMessage()], 500);
        }
    }
}
