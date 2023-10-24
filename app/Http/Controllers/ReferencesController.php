<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ReferencesController extends Controller
{
    public function fetchBusinessAreaOptions()
    {
        $client = new Client();

        try {
            $response = $client->get('http://localhost:9090/api/crm2/target/businessAreaOptions');
            $data = json_decode($response->getBody(), true);

            return response()->json($data);
        } catch (RequestException $e) {
            return response()->json(['error' => 'Ошибка при выполнении GET-запроса: ' . $e->getMessage()], 500);
        }
    }

    public function fetchLocationOptions()
    {
        $client = new Client();

        try {
            $response = $client->get('http://localhost:9090/api/crm2/target/locationOptions');
            $data = json_decode($response->getBody(), true);

            return response()->json($data);
        } catch (RequestException $e) {
            return response()->json(['error' => 'Ошибка при выполнении GET-запроса: ' . $e->getMessage()], 500);
        }
    }

    public function fetchSourceAppealOptions()
    {
        $client = new Client();

        try {
            $response = $client->get('http://localhost:9090/api/crm2/target/sourceAppealOptions');
            $data = json_decode($response->getBody(), true);

            return response()->json($data);
        } catch (RequestException $e) {
            return response()->json(['error' => 'Ошибка при выполнении GET-запроса: ' . $e->getMessage()], 500);
        }
    }
}
