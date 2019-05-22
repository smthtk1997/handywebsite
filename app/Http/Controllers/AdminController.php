<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Insurance;
use App\Shop;
use App\ShopType;
use App\Type;
use App\User;
use App\UserCars;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Alert;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('active');
        $this->middleware('admin');
    }

    public function index()
    {
        $shops = Shop::all();
        $users = User::all();
        $insurances = Insurance::all();
        $brands = Brand::all();
        $lasted_add = Shop::orderBy('created_at','desc')->take(20)->get();
        return view('admin.maintenance.dashboard',[
            'shops'=>$shops,
            'users'=>$users,
            'insurances'=>$insurances,
            'brands'=>$brands,
            'lasted_add'=>$lasted_add
        ]);
    }

    public function myFuelLog_brand()
    {
        $brands = Brand::all();
        return view('admin.maintenance.fuelLogApp.allBrand',['brands'=>$brands]);
    }

    public function myFuelLog_brand_store(Request $request)
    {
        $this->validate($request,[
            'addBrand' => 'required' ,
            'img_logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg'
        ]);

        $checkExist = Brand::where('name',strtolower($request->addBrand))->first();
        if ($checkExist){
            Alert::error('มียี่ห้อนี้แล้ว','กรุณาลองอีกครั้ง!')->persistent('ปิด');
            return redirect()->back()->withInput();
        }

        if($request->hasFile('img_logo')) {
            $files = $request->file('img_logo');
            $file = Input::file('img_logo')->getClientOriginalName();
            $filename = pathinfo($file, PATHINFO_FILENAME);
            $path = $filename.'-'.time() . '.' . $files->getClientOriginalExtension();
            $destinationPath = storage_path('/imgs/logo_Car/');
            $files->move($destinationPath, $path);
            $file_path_toDB = $path;

        }

        $brand = new Brand([
            'name'=>strtolower($request->addBrand),
            'img_logo'=>$file_path_toDB,
            'token'=>str_random(16)
        ]);

        try{
            $brand->save();
            Alert::success('บันทึกข้อมูลแล้ว','สำเร็จ!')->autoclose(2000);
            return redirect()->back();

        }catch (\Exception $x){
            Alert::error('เกิดข้อผิดพลาด','กรุณาลองอีกครั้ง!')->persistent('ปิด');
            return back()->withInput();
        }
    }


    public function insurance_Data()
    {
        $all_insurance = ['กรุงเทพประกันภัย','ทิพยประกันภัย','วิริยะประกันภัย','เมืองไทยประกันภัย','อาคเนย์ประกันภัย','ไทยวิวัฒน์ประกันภัย',
            'เอเชียประกันภัย','สินมั่นคงประกันภัย','นวกิจประกันภัย','แอลเอ็มจีประกันภัย'];
        foreach ($all_insurance as $insurance){
            $type = Type::where('name',$insurance)->first();
            if ($type){
                $new_insurance = new Insurance([
                   'name'=>$insurance,
                   'type_id'=>$type->id,
                   'token'=>str_random(16)
                ]);
                try{
                    $new_insurance->save();
                }catch (\Exception $x){
                }
            }
        }
    }

    public function myFuelLog_brand_delete(Brand $brand)
    {
        try{
            $brand->delete();
            Alert::success('ลบข้อมูลแล้ว','สำเร็จ!')->autoclose(2000);
            return redirect()->back();

        }catch (\Exception $x){
            Alert::error('เกิดข้อผิดพลาด','กรุณาลองอีกครั้ง!')->persistent('ปิด');
            return back()->withInput();
        }
    }

    public function maintenance_AllShop()
    {
        $shops = Shop::orderBy('rating','desc')->paginate(100);
        return view('admin.maintenance.shop.allShop',['shops'=>$shops]);
    }

    public function maintenance_DeleteShop(Shop $shop)
    {
        try{
            $shop->delete();
            Alert::success('ลบข้อมูลแล้ว','สำเร็จ!')->autoclose(2000);
            return redirect()->back();

        }catch (\Exception $x){
            Alert::error('เกิดข้อผิดพลาด','กรุณาลองอีกครั้ง!')->persistent('ปิด');
            return back()->withInput();
        }
    }

    public function maintenance_AllInsurance()
    {
        $insurances = Insurance::all();
        return view('admin.maintenance.insurance.allInsurance',['insurances'=>$insurances]);
    }

    public function maintenance_DeleteInsurance(Insurance $insurance)
    {
        try{
            $insurance->delete();
            Alert::success('ลบข้อมูลแล้ว','สำเร็จ!')->autoclose(2000);
            return redirect()->back();

        }catch (\Exception $x){
            Alert::error('เกิดข้อผิดพลาด','กรุณาลองอีกครั้ง!')->persistent('ปิด');
            return back()->withInput();
        }
    }

    public function maintenance_ActionShop(Request $request)
    {
        $this->validate($request,[
            'searchType' => 'required' ,
            'searchRange' => 'required',
            'lat'=> 'required|numeric',
            'lng'=> 'required|numeric'
        ]);

        $lat = $request->lat;
        $lng = $request->lng;
        $range = $request->searchRange;
        $type = [
            'car'=>'car',
            '6'=>'car%20repair',
            '1'=>'car%20dealer',
            '8'=>'car%20wash',
            '5'=>'gas%20station',
            '15'=>'tire',
            '16'=>'car%20audio',
            '17'=>'car%20accessory',
            '9'=>'car%20rental'
        ];

        $type_search = $type[$request->searchType];

//        if ($request->searchType == 'car'){
//            $type = 'car';
//        }else{
//            $type = Type::findOrFail($request->searchType);
//        }

        $endpoint = "https://maps.googleapis.com/maps/api/place/textsearch/json?query=$type_search&location=$lat,$lng&radius=$range&key=AIzaSyCCfe5aS3YBeRqcAevRwJMzUwO5LCbZ2jk";
        $headers = [];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        // SSL important
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $outputs = curl_exec($ch);
        curl_close($ch);


        $outputs = json_decode($outputs,true);
        $add_shop = 0;
        if ($outputs){
            if ($outputs['status'] == 'OK'){
                foreach ($outputs['results'] as $each){
                    $check = Shop::where('map_id',$each['id'])->first();
                    if (!$check){
                        $shop = new Shop();
                        $shop->name = $each['name'];
                        $shop->formatted_address = $each['formatted_address'];
                        $shop->lat = $each['geometry']['location']['lat'];
                        $shop->lng = $each['geometry']['location']['lng'];
                        $shop->map_id = $each['id'];
                        $shop->place_id = $each['place_id'];
                        $shop->rating = $each['rating'];
                        $shop->token = str_random(16);
                        if (array_key_exists('photos',$each)){
                            $shop->photo_ref = $each['photos'][0]['photo_reference'];
                        }

                        // ไปเอา detail
                        $urlGetdata = "https://maps.googleapis.com/maps/api/place/details/json?placeid=$shop->place_id&key=AIzaSyCCfe5aS3YBeRqcAevRwJMzUwO5LCbZ2jk";
                        $jsonDetail = file_get_contents($urlGetdata);
                        $dataDetail = json_decode($jsonDetail,true);

                        if (array_key_exists('result',$dataDetail)) {
                            if (array_key_exists('international_phone_number',$dataDetail['result'])){
                                $phone_number = $dataDetail['result']['international_phone_number'];
                                $phone_number = str_replace(' ','-',$phone_number);
                            }else{
                                $phone_number = null;
                            }

                            if (array_key_exists('url',$dataDetail['result'])){
                                $urlNav = $dataDetail['result']['url'];
                            }else{
                                $urlNav = null;
                            }
                        }
                        $shop->phone_number = $phone_number;
                        $shop->url_nav = $urlNav;
                        $shop->save();
                        $add_shop++;
                    }else{
                        $shop = $check;
                        $add_shop++;
                    }

                    if ($type_search == 'car'){
                        foreach ($each['types'] as $type){
                            $checktype = Type::where('name',$type)->first();
                            if (!$checktype){
                                $checktype = new Type();
                                $checktype->name = $type;
                                $checktype->token = str_random(16);
                                $checktype->save();
                            }

                            $checkShoptype = ShopType::where('shop_id',$shop->id)->where('type_id',$checktype->id)->first();
                            if (!$checkShoptype){
                                $shoptype = new ShopType();
                                $shoptype->shop_id = $shop->id;
                                $shoptype->type_id = $checktype->id;
                                $shoptype->token = str_random(16);
                                $shoptype->save();
                            }
                        }
                    }else{
                        $offer_type = str_replace('%20','_',$type_search);
                        $checktype = Type::where('name',$offer_type)->first(); //เอาไว้เวลาจะเพิ่มแบบ manual
                        if (!$checktype){
                            $checktype = new Type();
                            $checktype->name = $offer_type;
                            $checktype->token = str_random(16);
                            $checktype->save();
                        }

                        $checkShoptype = ShopType::where('shop_id',$shop->id)->where('type_id',$checktype->id)->first();
                        if (!$checkShoptype){
                            $shoptype = new ShopType();
                            $shoptype->shop_id = $shop->id;
                            $shoptype->type_id = $checktype->id;
                            $shoptype->token = str_random(16);
                            $shoptype->save();
                        }
                    }
                }
                Alert::success('สำเร็จ!','เพิ่ม/อัพเดททั้งหมด '.$add_shop.' สถานที่')->persistent('Ok');
                return redirect()->back();
            }
        }
        Alert::warning('ไม่พบสถานที่!','กรุณาลองใหม่อีกครั้ง')->autoclose(2000);
        return redirect()->back();
    }

    public function maintenance_allUser()
    {
        $users = User::all();
        return view('admin.maintenance.user.allUser',['users'=>$users]);
    }

    public function maintenance_updateUserStatus(User $user,$status)
    {
        if (md5('0') == $status){
            $to_update = "0";
        }
        elseif (md5('1') == $status){
            $to_update = "1";
        }else{
            Alert::error('เกิดข้อผิดพลาด','กรุณาลองอีกครั้ง!')->persistent('ปิด');
            return back()->withInput();
        }
        try{
            $user->status = $to_update;
            $user->save();
            Alert::success('อัพเดทสถานะผู้ใช้แล้ว','สำเร็จ!')->autoclose(2000);
            return redirect()->back();

        }catch (\Exception $x){
            Alert::error('เกิดข้อผิดพลาด','กรุณาลองอีกครั้ง!')->persistent('ปิด');
            return back()->withInput();
        }
    }
}
