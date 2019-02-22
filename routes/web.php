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

//Route::get('/handy', [
//    'as' => 'home',
//    'uses' => 'Controller@index']);

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

Route::get('/crud', [
    'as' => 'guest.stampspv',
    'uses' => 'Controller@stampspv']);

// Admin Route

Route::get('/admin', [
    'as' => 'admin.index',
    'uses' => 'AdminController@index']);


// api
Route::get('/api/{lat}/{lng}', [
    'as' => 'api',
    'uses' => 'PlaceAPIController@getPlaceAPI']);


// Map
Route::get('/map', [
    'as' => 'admin.map',
    'uses' => function(){
        return view('admin.mappage');
    }]);

//GoHandyHome
Route::get('/', [
    'as' => 'home',
    'uses' => 'HomeController@Handy']);

// Testดึงข้อมูล Type
Route::get('/test', [
    'as' => 'test',
    'uses' => 'Controller@test']);

// Test Google เก็บ store
Route::get('/google/map/place', [
    'as' => 'google.place',
    'uses' => 'PlaceAPIController@MarkerPin']);

Route::get('/google/map/place/update', [
    'as' => 'google.place.update',
    'uses' => function(){
        return view('Home.updateMap');
    }]);

