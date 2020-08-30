<?php
use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/createyourown', 'HomeController@createyourown')->name('createyourown');
Route::get('/dvla', 'HomeController@dvla')->name('dvla');
Route::get('/privacypolicy', 'HomeController@privacypolicy')->name('privacypolicy');
Route::get('/ridehailing', 'HomeController@ridehailing')->name('ridehailing');
Route::get('/tests/all','TestUgcController@all')->name('tests.all');
Route::get('/tests/results','TestUgcController@results')->name('tests.results');

Route::post('/z/start', 'ZebraController@starttest')->name('start');
Route::post('/z/question', 'ZebraController@answerQuestionAndProceed')->name('question');
Route::get('/z/restart', 'ZebraController@redoFaults')->name('restart');
Route::get('/z/render/{id}/{op}', 'ZebraController@render')->name('render');
Route::get('/z/book/{title}', 'ZebraController@book')->name('book');
Route::get('/z/booknav/{title}', 'ZebraController@book')->name('booknav');

Route::get('/dynform', 'ContentController@dynform')->name('dynform');
Route::post('/dynsubmit', 'ContentController@dynsubmit')->name('dynsubmit');

Auth::routes();
//Auth::routes(['verify' => true]);

Route::group(['middleware'=>['auth']], function() { //add 'verified' in array
    Route::get('/momo/dvlaform', 'MomoController@momoDvlaForm')->name('momoDvlaForm');
    Route::get('/momo/checkout', 'MomoController@momoCheckout')->name('momoCheckout');
    Route::post('/momo/requesttopay', 'MomoController@momoRequestToPay')->name('momoRequestToPay');
    Route::put('/momocallback', 'MomoController@momoCallback')->name('momoCallback');

    Route::get('questions/check','QuestionUgcController@check')->name('check');
    Route::get('questions/{queid}/editphoto','QuestionUgcController@editphoto')->name('questions.editphoto');
    Route::get('questions/{queid}/edittext','QuestionUgcController@edittext')->name('questions.edittext');
    Route::post('questions/updatephoto','QuestionUgcController@updatephoto')->name('questions.updatephoto');
    Route::post('questions/updatetext','QuestionUgcController@updatetext')->name('questions.updatetext');
    Route::resource('questions','QuestionUgcController');
    
    Route::post('tests/chosenquestions','TestUgcController@chosenquestions')->name('tests.chosenquestions');
    Route::get('tests/{id}/sortquestions','TestUgcController@sortquestions')->name('tests.sortquestions');
    Route::resource('tests','TestUgcController');
});

Route::group(['middleware'=>['auth', 'admin']], function() {
    Route::get('admin/questions/index/{status}','AdminController@index')->name('admin.questions.index');
    Route::get('admin/questions/index','AdminController@index')->name('admin.questions.index');
    Route::get('admin/questions/{id}','AdminController@show')->name('admin.questions.show');
    Route::post('admin/questions/updatestatus','AdminController@updatestatus')->name('admin.questions.updatestatus');
});
    
    