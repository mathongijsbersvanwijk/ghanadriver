<?php
use App\Http\Resources\TestConfigurationResource;
use App\Models\TestConfiguration;
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

Route::get('/tests/all', function () {
    return TestConfigurationResource::collection(TestConfiguration::all());
});
Route::get('/z/start/{tstId}/{op}/{mode}', 'ZebraController@starttestApi')->name('startapi');
Route::get('/z/render/{id}', 'ZebraController@renderApi')->name('renderapi');
Route::post('/z/stop', 'ZebraController@stoptestApi')->name('stopapi');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
