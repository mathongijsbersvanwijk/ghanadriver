<?php
use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/ridehailing', 'HomeController@ridehailing')->name('ridehailing');
Route::get('/dvla', 'HomeController@dvla')->name('dvla');

Route::post('/z/start', 'ZebraController@starttest')->name('start');
Route::post('/z/question', 'ZebraController@answerQuestionAndProceed')->name('question');
Route::get('/z/restart', 'ZebraController@redoFaults')->name('restart');
Route::get('/z/render/{id}/{op}', 'ZebraController@render')->name('render');
Route::get('/z/book/{title}', 'ZebraController@book')->name('book');
Route::get('/z/booknav/{title}', 'ZebraController@book')->name('booknav');

Route::get('questions/check','QuestionUgcController@check')->name('check');
Route::post('questions/fetch','QuestionUgcController@fetch')->name('fetch');
Route::get('questions/{id}/editphoto','QuestionUgcController@editphoto')->name('questions.editphoto');
Route::post('questions/updatephoto','QuestionUgcController@updatephoto')->name('questions.updatephoto');
Route::resource('questions','QuestionUgcController');
Route::resource('tests','TestUgcController');

Route::get('/dynform', 'ContentController@dynform')->name('dynform');
Route::post('/dynsubmit', 'ContentController@dynsubmit')->name('dynsubmit');

Auth::routes();

Route::group(['middleware'=>['auth']], function(){
    Route::get('/momo/dvlaform', 'MomoController@momoDvlaForm')->name('momoDvlaForm');
    Route::get('/momo/checkout', 'MomoController@momoCheckout')->name('momoCheckout');
    Route::post('/momo/requesttopay', 'MomoController@momoRequestToPay')->name('momoRequestToPay');
    Route::put('/momocallback', 'MomoController@momoCallback')->name('momoCallback');
});
    