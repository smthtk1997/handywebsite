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

Auth::routes();

Route::get('/', [
    'as' => 'home',
    'uses' => 'Controller@index']);

Route::get('/home', [
    'as' => 'redirect',
    'uses' => 'HomeController@redirect']);

Route::get('/dashboard', [
    'as' => 'dashboard',
    'uses' => 'HomeController@index']);

Route::get('/notpermission', [
    'as' => 'notpermission',
    'uses' => 'GuestController@notpermission']);

Route::get('imgs/{filename}', function($filename) {

    $filePath = storage_path().'/imgs/'.$filename;
    if (!File::exists($filePath)) {
        return response()->view('guest.404', [], 404);
    }
    $fileContents = File::get($filePath);
    return Response::make($fileContents, 200);

});



// Guest Route

Route::get('/stampspv', [
    'as' => 'guest.stampspv',
    'uses' => 'Controller@stampspv']);

// Admin Route

Route::get('/admin', [
    'as' => 'admin.index',
    'uses' => 'AdminController@index']);

