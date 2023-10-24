<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\ReferencesController;
use Illuminate\Http\Client\Response;

class FormController extends Controller
{
    private function getReferenceData(): array
    {
        $referenceController = new ReferencesController();

        $referenceData = [];

        $referenceData['businessAreaOptions'] = $referenceController->fetchBusinessAreaOptions()->getData();
        $referenceData['locationOptions'] = $referenceController->fetchLocationOptions()->getData();
        $referenceData['sourceAppealOptions'] = $referenceController->fetchSourceAppealOptions()->getData();

        return $referenceData;
    }

    private function validateForm($formData, $referenceData)
    {
        $rules = [
            'businessAreaId' => 'required',
            'fullName' => 'required|string',
            'locationId' => 'required',
            'note' => 'string',
            'phoneNumber' => 'string',
            'sourceAppealId' => 'required',
        ];

        //    $rules = [
        //        'businessAreaId' => 'required|in:' . implode(',', array_column($referenceData['businessAreaOptions'], 'id')),
        //        'fullName' => 'required|string',
        //        'locationId' => 'required|in:' . implode(',', array_column($referenceData['locationOptions'], 'id')),
        //        'note' => 'string',
        //        'phoneNumber' => 'string',
        //        'sourceAppealId' => 'required|in:' . implode(',', array_column($referenceData['sourceAppealOptions'], 'id')),
        //    ];

        $messages = [
            'businessAreaId.in' => 'Неверное значение для businessAreaId',
            'locationId.in' => 'Неверное значение для locationId',
            'sourceAppealId.in' => 'Неверное значение для sourceAppealId',
        ];

        if (!empty($referenceData['businessAreaOptions'])) {
            $rules['businessAreaId'] .= '|in:' . implode(',', array_column($referenceData['businessAreaOptions'], 'id'));
        } else {
            $rules['businessAreaId'] .= '|in:0';
        }

        if (!empty($referenceData['locationOptions'])) {
            $rules['locationId'] .= '|in:' . implode(',', array_column($referenceData['locationOptions'], 'id'));
        } else {
            $rules['locationId'] .= '|in:0';
        }

        if (!empty($referenceData['sourceAppealOptions'])) {
            $rules['sourceAppealId'] .= '|in:' . implode(',', array_column($referenceData['sourceAppealOptions'], 'id'));
        } else {
            $rules['sourceAppealId'] .= '|in:0';
        }

        $validator = validator()->make($formData, $rules, $messages);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    public function store(Request $request, ReferencesController $referencesController)
    {
        $formData = $request->all();
        if (empty($formData))
            return response()->json(['error' => 'Пустой запрос'], 400);

        $referenceData = $this->getReferenceData();

        try {
            $this->validateForm($formData, $referenceData);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->validator->errors()], 400); // Обработка ошибки валидации
        }

        $environment = app()->environment();
        $apiUrl = Config::get("api.$environment");
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->post("$apiUrl/api/crm2/target/save", [
                'json' => $formData,
            ]);
            if ($response->getStatusCode() === 200) {
                return response()->json(['message' => 'Данные успешно отправлены']);
            } else {
                return response()->json(['error' => 'Ошибка при отправке данных'], 500);
            }
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return response()->json(['error' => 'Ошибка при отправке данных: ' . $e->getMessage()], 500);
        }
    }
}
