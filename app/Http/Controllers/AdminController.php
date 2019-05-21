<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Insurance;
use App\Shop;
use App\Type;
use App\UserCars;
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
        return view('admin.index');
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
}
