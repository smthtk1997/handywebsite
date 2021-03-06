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

Route::get('user_img/{filename}', function($filename) {

    $filePath = storage_path().'/imgs/user_avatar/'.$filename;
    if (!File::exists($filePath)) {
        return response()->view('guest.404', [], 404);
    }
    $fileContents = File::get($filePath);
    return Response::make($fileContents, 200);

});


Route::get('/backpage', [
    'as' => 'back.page',
    'uses' => function(){
        return redirect()->back();
    }]);


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
    $insurances = \App\Insurance::all();
    return view('Home.handy',['insurances'=>$insurances]);
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
Route::get('/handy/shop/search', [
    'as' => 'shop.search',
    'uses' => 'SearchEngineController@shopSearch']);

Route::get('/handy/shop/detail/{place_id}', [
    'as' => 'shop.search.detail',
    'uses' => 'SearchEngineController@placeDetail']);




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

Route::get('/fuellog/application/edit/car/view/{car}', [ // แก้ไขรถยนต์
    'as' => 'fuellog.app.edit.car.view',
    'uses' => 'UserCarsController@showEditCar']);

Route::post('/fuellog/application/edit/car/update/{car}', [ // อัพเดทรถยนต์
    'as' => 'fuellog.app.edit.car.update',
    'uses' => 'UserCarsController@updateCar']);

Route::get('/fuellog/application/delete/car/{car}', [ // ลบรถยนต์
    'as' => 'fuellog.app.delete.car',
    'uses' => 'UserCarsController@deleteCar']);

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

Route::get('/fuellog/application/myLog/conclude/{car}', [ // ไปหน้าสรุปยอด
    'as' => 'fuellog.myLog.conclude',
    'uses' => 'FuelLogController@myLogConclude']);

Route::get('admin/fuellog/application/brand', [ // ไปหน้ายี่ห้อทั้งหมด
    'as' => 'admin.fuellog.brand',
    'uses' => 'AdminController@myFuelLog_brand']);

Route::post('admin/fuellog/application/brand/store', [ // เก็บยี่ห้อใหม่
    'as' => 'admin.fuellog.brand.store',
    'uses' => 'AdminController@myFuelLog_brand_store']);

Route::get('admin/fuellog/application/brand/delete/{brand}', [ // เก็บยี่ห้อใหม่
    'as' => 'admin.fuellog.brand.delete',
    'uses' => 'AdminController@myFuelLog_brand_delete']);

Route::get('/fuellog/application/myLog/refuel/edit/{log}', [ // ไปหน้าแก้ไขเติมน้ำมัน
    'as' => 'fuellog.myLog.refuel.edit',
    'uses' => 'FuelLogController@myLogRefuelEdit']);

Route::post('/fuellog/application/myLog/refuel/update/{log}', [ // อัพเดทเติมน้ำมัน
    'as' => 'fuellog.myLog.refuel.update',
    'uses' => 'FuelLogController@myLogRefuelUpdate']);



////////////// Map Bound API ////////////////

Route::post('/api/map/bound.api', [
    'as' => 'api.map.bound',
    'uses' => 'SearchEngineController@get_Place_inBound']);

Route::post('/api/map/type/bound.api', [
    'as' => 'api.map.type.bound',
    'uses' => 'SearchEngineController@get_type_inBound']);


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


////////////// Insurance Scraping /////////////
Route::get('/insurance/scraping/viriyah', [
    'as' => 'insurance.scraping.viriyah',
    'uses' => 'ApiController\InsuranceScrapingController@viriyahScraping']);

Route::get('/insurance/scraping/bangkok', [
    'as' => 'insurance.scraping.bangkok',
    'uses' => 'ApiController\InsuranceScrapingController@bangkokScraping']);

Route::get('/insurance/scraping/dhipaya', [
    'as' => 'insurance.scraping.dhipaya',
    'uses' => 'ApiController\InsuranceScrapingController@dhipayaScraping']);

Route::get('/insurance/scraping/muangthai', [
    'as' => 'insurance.scraping.muangthai',
    'uses' => 'ApiController\InsuranceScrapingController@MuangThaiScraping']);

Route::get('/insurance/scraping/seic', [
    'as' => 'insurance.scraping.seic',
    'uses' => 'ApiController\InsuranceScrapingController@SEICScraping']);

Route::get('/insurance/scraping/thaivivat', [
    'as' => 'insurance.scraping.thaivivat',
    'uses' => 'ApiController\InsuranceScrapingController@thaivivatScraping']);

Route::get('/insurance/scraping/asia', [
    'as' => 'insurance.scraping.asia',
    'uses' => 'ApiController\InsuranceScrapingController@asiaScraping']);

Route::get('/insurance/scraping/lmg', [
    'as' => 'insurance.scraping.lmg',
    'uses' => 'ApiController\InsuranceScrapingController@lmgScraping']);

Route::get('/insurance/scraping/smk', [
    'as' => 'insurance.scraping.smk',
    'uses' => 'ApiController\InsuranceScrapingController@smkScraping']);

Route::get('/insurance/scraping/navakij', [
    'as' => 'insurance.scraping.navakij',
    'uses' => 'ApiController\InsuranceScrapingController@navakijScraping']);


//////////// Review /////////////
Route::post('/save/review', [
    'as' => 'save.review',
    'uses' => 'ShopController@save_review']);


////////////// MyLog Query ////////////////
Route::post('/api/fuel/mylog/query', [
    'as' => 'api.fuel.mylog.query',
    'uses' => 'FuelLogController@inMonth']);

Route::post('/api/fuel/mylog/query/year.api', [
    'as' => 'api.fuel.mylog.query.year',
    'uses' => 'FuelLogController@queryYear']);

////////////// User ///////////////////
Route::get('user/information/view', [ // ข้อมูลผู้ใช้
    'as' => 'user.information.view',
    'uses' => 'UserController@user_detail']);

Route::post('user/change/password', [ // ข้อมูลผู้ใช้
    'as' => 'user.change.password',
    'uses' => 'UserController@change_password']);

Route::post('user/edit/user/information', [ // ข้อมูลผู้ใช้
    'as' => 'user.edit.user.information',
    'uses' => 'UserController@edit_detail']);


////////////// Admin ////////////////////
Route::get('admin/maintenance/all/shop', [ // ร้านค้าในระบบทั้งหมด
    'as' => 'admin.maintenance.all.shop',
    'uses' => 'AdminController@maintenance_AllShop']);

Route::get('admin/maintenance/delete/shop/{shop}', [ // ลบร้านค้าในระบบ
    'as' => 'admin.maintenance.delete.shop',
    'uses' => 'AdminController@maintenance_DeleteShop']);

Route::post('admin/maintenance/action/shop/', [ // ลบร้านค้าในระบบ
    'as' => 'admin.maintenance.action.shop',
    'uses' => 'AdminController@maintenance_ActionShop']);

Route::get('admin/maintenance/all/insurance', [ // ประกันในระบบ
    'as' => 'admin.maintenance.all.insurance',
    'uses' => 'AdminController@maintenance_AllInsurance']);

Route::get('admin/maintenance/delete/insurance/{insurance}', [ // ลบประกันในระบบ
    'as' => 'admin.maintenance.delete.insurance',
    'uses' => 'AdminController@maintenance_DeleteInsurance']);

Route::get('admin/maintenance/all/user/page', [ // user ทั้งหมด
    'as' => 'admin.maintenance.all.user.page',
    'uses' => 'AdminController@maintenance_allUser']);

Route::get('admin/maintenance/update/user/status/{user}/{status}', [ // user ทั้งหมด
    'as' => 'admin.maintenance.update.user.status',
    'uses' => 'AdminController@maintenance_updateUserStatus']);


////////// Facebook /////////
Route::get('/redirect/{provider}', 'SocialAuthFacebookController@redirect');


Route::get('/callback/{provider}', [ // fb
    'as' => 'facebook.callback',
    'uses' => 'SocialAuthFacebookController@callback']);

Route::get('/logout', 'SocialAuthFacebookController@logout');

Route::get('/policy',[
    'as' => 'policy',
    'uses' => function(){
        return view('policy');
    }]);



