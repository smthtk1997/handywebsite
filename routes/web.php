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
    'uses' => function(){
    return view('Home.handy');
    }]);

// Testดึงข้อมูล Type
Route::get('/test', [
    'as' => 'test',
    'uses' => 'Controller@test']);

// Test Google เก็บ store
Route::get('/google/map/place', [
    'as' => 'google.place',
    'uses' => 'PlaceAPIController@MarkerPin']);

Route::get('/google/map/place/update/photo/ref', [
    'as' => 'google.place.update.photo.ref',
    'uses' => 'PlaceAPIController@updatePhoto_Ref']);

Route::get('/google/map/place/update', [
    'as' => 'google.place.update',
    'uses' => function(){
        return view('admin.maintenance.updateMap');
    }]);

Route::get('/search/on/map/view', [ // ค้นหาบนแผนที่
    'as' => 'search.on.map.view',
    'uses' => 'SearchEngineController@search_on_map_view']);


// ค้นหา
Route::post('/handy/shop/search', [
    'as' => 'shop.search',
    'uses' => 'SearchEngineController@shopSearch']);




//FuelLog App
Route::get('/fuellog/application/index', [ //หน้าแรกของการเติมน้ำมัน
    'as' => 'fuellog.app.index',
    'uses' => 'FuelLogController@fuelLogIndex']);

Route::get('/fuellog/application/create/car', [ // หน้าเพิ่มรถยนต์ใหม่
    'as' => 'fuellog.app.create.car',
    'uses' => 'UserCarsController@createCarIndex']);

Route::post('/fuellog/application/create/car/store', [ // เพิ่มรถยนต์ใหม่
    'as' => 'fuellog.app.create.car.store',
    'uses' => 'UserCarsController@storeCar']);

Route::get('/files/user_car_img/{filename}', function($filename) // แสดงรูปของหน้า app fuel index
{
    $filePath = storage_path().'/files/user_car_img/'.$filename;

    if (!File::exists($filePath))
    {
//        return Response::make("File does not exist.", 404);
        return null;
    }

    $fileContents = File::get($filePath);

    // Image
    return Response::make($fileContents, 200);
});

Route::get('/files/brand_logo/{filename}', function($filename) // แสดงรูปโลโก้ยี่ห้อ
{
    $filePath = storage_path().'/imgs/logo_Car/'.$filename;

    if (!File::exists($filePath))
    {
        return null;
    }

    $fileContents = File::get($filePath);

    // Image
    return Response::make($fileContents, 200);
});



Route::get('/fuellog/application/myLog/{car}', [ // หน้าดูประวัติแต่ละคัน
    'as' => 'fuellog.myLog',
    'uses' => 'FuelLogController@myLogIndex']);

Route::get('/fuellog/application/myLog/refuel/{car}', [ // ไปหน้าเติมน้ำมัน
    'as' => 'fuellog.myLog.refuel',
    'uses' => 'FuelLogController@myLogRefuel']);

Route::post('/fuellog/application/myLog/refuel/save/{car}', [ // save log
    'as' => 'fuellog.myLog.refuel.save',
    'uses' => 'FuelLogController@myLogRefuel_save']);

Route::get('admin/fuellog/application/brand', [ // ไปหน้ายี่ห้อทั้งหมด
    'as' => 'admin.fuellog.brand',
    'uses' => 'AdminController@myFuelLog_brand']);

Route::post('admin/fuellog/application/brand/store', [ // เก็บยี่ห้อใหม่
    'as' => 'admin.fuellog.brand.store',
    'uses' => 'AdminController@myFuelLog_brand_store']);


////////////// Map Bound API ////////////////

Route::post('/api/map/bound.api', [
    'as' => 'api.map.bound',
    'uses' => 'SearchEngineController@get_Place_inBound']);


////////////// Fuel Price API ////////////////
Route::post('/api/fuel/ptt/price.api', [
    'as' => 'api.fuel.ptt.price',
    'uses' => 'ApiController\FuelScrapingController@getFuelPriceApi_Ptt']);

Route::post('/api/fuel/shell/price.api', [
    'as' => 'api.fuel.shell.price',
    'uses' => 'ApiController\FuelScrapingController@getFuelPriceApi_Shell']);

////////////// Vision API ////////////////
Route::post('/api/vision/imageProcess.api', [
    'as' => 'api.vision.imageProcess',
    'uses' => 'ApiController\VisionController@imageProcessing_api']);



