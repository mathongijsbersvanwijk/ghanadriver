<?php
use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/ridehailing', 'HomeController@ridehailing')->name('ridehailing');

Route::post('/z/start', 'ZebraController@starttest');
Route::post('/z/question', 'ZebraController@answerQuestionAndProceed');
Route::get('/z/restart', 'ZebraController@redoFaults');
Route::get('/z/render/{id}/{op}', 'ZebraController@render');
Route::get('/z/book/{title}', 'ZebraController@book');
Route::get('/z/booknav/{title}', 'ZebraController@book');
Route::resource('/z', 'ZebraController');

Route::get('/momo', 'MomoController@momo')->name('momo');
Route::get('/momo/checkout', 'MomoController@momoCheckout')->name('momoCheckout');
Route::post('/momo/requesttopay', 'MomoController@momoRequestToPay')->name('momoRequestToPay');
Route::put('/momocallback', 'MomoController@momoCallback')->name('momoCallback');

Auth::routes();

