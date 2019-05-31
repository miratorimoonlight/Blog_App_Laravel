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

Route::get('/', 'PagesController@index');   

Route::get('/about','PagesController@about');

Route::get('/services','PagesController@services');

//automatically create routes for PostsController
Route::resource('posts','PostsController');

//route parameters or Dynamic routing
// Route::get('/users/{id}/{name}',function($id, $name){
//     return $id;
// });
Auth::routes();

Route::get('/home', 'HomeController@index');
