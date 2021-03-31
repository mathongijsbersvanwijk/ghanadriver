<?php
use App\Http\Resources\TestConfigurationResource;
use App\Models\TestConfiguration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
 * |--------------------------------------------------------------------------
 * | API Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register API routes for your application. These
 * | routes are loaded by the RouteServiceProvider within a group which
 * | is assigned the "api" middleware group. Enjoy building your API!
 * |
 */

Route::get('/tests/all', function () {
    return TestConfigurationResource::collection(TestConfiguration::all());
});
Route::get('/z/start/{tstId}/{op}/{mode}', 'ZebraController@starttestApi')->name('startapi');
Route::get('/z/render/{id}', 'ZebraController@renderApi')->name('renderapi');
Route::post('/z/stop', 'ZebraController@stoptestApi')->name('stopapi');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user', function(Request $request) {
        return auth()->user();
    });
    Route::post('/logout', function (Request $request) {
        auth()->user()->currentAccessToken()->delete();
        
        return [
            'message' => 'token revoked'
        ];
    });
});

Route::post('/login', function (Request $request) {
    $data = $request->validate(['email' => 'required|email','password' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response(['message' => ['These credentials do not match our records.'
        ]
        ], 404);
    }

    $token = $user->createToken('my-app-token')->plainTextToken;

    $response = ['user' => $user,'token' => $token
    ];

    return response($response, 201);
});
