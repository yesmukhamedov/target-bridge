<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/form', 'FormController@store');

Route::get('/business-areas', 'ReferencesController@fetchBusinessAreaOptions');
Route::get('/locations', 'ReferencesController@fetchLocationOptions');
Route::get('/source-appeals', 'ReferencesController@fetchSourceAppealOptions');
