<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormController extends Controller
{
    public function store(Request $request)
    {
        $formData = $request->all();
        if (empty($formData))
            return response()->json(['error' => 'Пустой запрос'], 400);

        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->post('http://localhost:9090/api/crm2/target/save', [
                'json' => $formData,
            ]);
            if ($response->getStatusCode() === 200) {
                $responseBody = $response->getBody()->getContents();
                return response()->json(['message' => 'Данные успешно отправлены на Spring Boot']);
            } else {
                return response()->json(['error' => 'Ошибка при отправке данных на Spring Boot'], 500);
            }
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return response()->json(['error' => 'Ошибка при отправке данных на Spring Boot: ' . $e->getMessage()], 500);
        }
    }
}
