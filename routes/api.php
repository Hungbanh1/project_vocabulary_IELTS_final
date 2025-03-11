<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/get-list-parapharse/{id}', 'Api\VocabularyAPIController@getParapharse');
Route::get('/parapharse/{type_id}', function ($type_id) {
    // Parapharse::where('type_id', $type_id)->get();
    $vocabulary = $this->VocabularyServices->getAllParapharse();
    return $vocabulary;
});