<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/', 'QuestionsController@index');

Route::get('/home', 'HomeController@index');

Route::get('email/verify/{token}',['as' => 'email.verify', 'uses' => 'EmailController@verify']);

Route::resource('questions','QuestionsController',['names' => [
    'create' => 'question.create',
    'show'   => 'question.show'
]]);

Route::post('questions/{question}/answer','AnswersController@store');

Route::get('questions/{question}/follow','QuestionFollowController@follow');

Route::get('/notification','NotificationsController@index');
Route::get('/notification/{notification}','NotificationsController@show');

Route::get('/inbox','InboxController@index');
Route::get('/inbox/{dialogId}','InboxController@show');
Route::post('/inbox/{dialogId}/store','InboxController@store');