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

Route::get('/', 'QuestionsController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('email/verify/{token}',['as' => 'email.verify','uses' => 'EmailController@verify']);

Route::resource('/questions','QuestionsController');
Route::post('questions/{question}/answer','AnswersController@store');
Route::get('questions/{question}/follow','QuestionFollowController@follow');

Route::get('notifications','NotificationsController@index');
Route::get('notifications/{notification}','NotificationsController@show');

Route::get('avatar','UsersController@avatar');
Route::post('avatar','UsersController@changAvatar');

Route::get('password','PasswordController@password');
Route::post('password/update','PasswordController@update');

Route::get('setting','SettingController@index');
Route::post('setting','SettingController@store');

Route::get('inbox','InboxController@index');
Route::get('inbox/{dialog_id}','InboxController@show');
Route::post('inbox/{dialog_id}/store','InboxController@store');