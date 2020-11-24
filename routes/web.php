<?php

use Illuminate\Support\Facades\Route;

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

Route::get('logout','UserController@logout');
Route::any('{any}', 'UserController@index')->where('any', '.*');
Route::post('login','UserController@login');

Route::get('/','UserController@index');

//Route::group(['middleware' => 'admin'],function (){

    Route::post('tag/create', 'TagController@createTag');
    Route::post('tag/edit', 'TagController@editTag');
    Route::post('tag/delete', 'TagController@deleteTag');
    Route::get('tag/list', 'TagController@getTag');

    Route::post('category/create', 'CategoryController@createCategory');
    Route::post('category/edit', 'CategoryController@editCategory');
    Route::post('category/delete', 'CategoryController@deleteCategory');
    Route::get('category/list', 'CategoryController@getCategory');
    Route::post('category/upload', 'CategoryController@upload');
    Route::post('upload/deleteimage', 'CategoryController@deleteImage');

//user section
    Route::get('user/list','UserController@userList');
    Route::post('user/create','UserController@createUser');
    Route::post('user/edit','UserController@editUser');
    Route::post('user/delete','UserController@deleteUser');

//});
