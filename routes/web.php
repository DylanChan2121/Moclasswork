<?php
# @Date:   2019-09-24T15:32:43+01:00
# @Last modified time: 2019-10-08T15:15:15+01:00




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

Route::get('/', function () {//your index
    return redirect()->route('todos.index');
});
Route::get('/todos','TodoController@index')->name('todos.index');


Route::get('/todos/create','TodoController@create')->name('todos.create');
Route::post('/todos/store','TodoController@store')->name('todos.store');
Route::get('/todos/{id}','TodoController@show')->name('todos.show');
Route::get('/todos/{id}/edit','TodoController@edit')->name('todos.edit');
Route::put('/todos{id}','TodoController@update')->name('todos.update');
Route::delete('/todos{id}','TodoController@destroy')->name('todos.destroy');

Auth::routes(['verify'=>true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');
