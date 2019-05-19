<?php

namespace App\Http\Controllers;

use App\Brand;
use App\FuelLog;
use App\UserCars;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Alert;

class UserCarsController extends Controller
{
    public function createCarIndex(){
        $brands = Brand::orderBy('name','asc')->get();
        return view('users.FuelLog.createCar',['brands'=>$brands]);
    }

    public function storeCar(Request $request){
        $this->validate($request,[
            'carName' => 'required' ,
            'carLicense' => 'required',
            'brand' => 'required',
            'modelCar' => 'required',
            'milleage' => 'required'
        ]);

        if($request->hasFile('car_img')) {
            $files = $request->file('car_img');
            $file = Input::file('car_img')->getClientOriginalName();
            $filename = pathinfo($file, PATHINFO_FILENAME);
            $path = $filename.'-'.time() . '.' . $files->getClientOriginalExtension();
            $destinationPath = storage_path('/files/user_car_img/');
            $files->move($destinationPath, $path);
            $file_path_toDB = $path;

        }else{
            $file_path_toDB = $request->no_img;
        }

        $userCar = new UserCars([
            'user_id'=>Auth::user()->id,
            'name'=>$request->carName,
            'license'=>$request->carLicense,
            'brand_id'=>$request->brand,
            'model'=>strtolower($request->modelCar),
            'mileage'=>$request->milleage,
            'img_path'=>$file_path_toDB,
            'token'=>str_random(16)
        ]);

        try{
            $userCar->save();
            Alert::success('บันทึกข้อมูลแล้ว','สำเร็จ!')->autoclose(2000);
            return redirect()->route('fuellog.app.index');

        }catch (\Exception $x){
            Alert::error('เกิดข้อผิดพลาด','กรุณาลองอีกครั้ง!')->persistent('ปิด');
            return back()->withInput();
        }
    }

    public function deleteCar(UserCars $car)
    {
        try{
            FuelLog::where('car_id',$car->id)->delete();
            $car->delete();
            Alert::success('ลบเรียบร้อย','สำเร็จ!')->autoclose(2000);
            return redirect()->route('fuellog.app.index');

        }catch (\Exception $x){
            Alert::error('เกิดข้อผิดพลาด','กรุณาลองอีกครั้ง!')->persistent('ปิด');
            return back()->withInput();
        }
    }

    public function showEditCar(UserCars $car)
    {
        $brands = Brand::orderBy('name','asc')->get();
        return view('users.FuelLog.editCar',['brands'=>$brands,'car'=>$car]);
    }

    public function updateCar(Request $request,UserCars $car)
    {
        $this->validate($request,[
            'carName' => 'required' ,
            'carLicense' => 'required',
            'brand' => 'required',
            'modelCar' => 'required',
            'milleage' => 'required'
        ]);

        if($request->hasFile('car_img')) {
            $files = $request->file('car_img');
            $file = Input::file('car_img')->getClientOriginalName();
            $filename = pathinfo($file, PATHINFO_FILENAME);
            $path = $filename.'-'.time() . '.' . $files->getClientOriginalExtension();
            $destinationPath = storage_path('/files/user_car_img/');
            $files->move($destinationPath, $path);
            $file_path_toDB = $path;

            $car->img_path = $file_path_toDB;

        }

        $car->name = $request->carName;
        $car->license = $request->carLicense;
        $car->brand_id = $request->brand;
        $car->model = strtolower($request->modelCar);
        $car->mileage = $request->milleage;

        try{
            $car->save();
            Alert::success('อัพเดทข้อมูลแล้ว','สำเร็จ!')->autoclose(2000);
            return redirect()->route('fuellog.app.index');

        }catch (\Exception $x){
            Alert::error('เกิดข้อผิดพลาด','กรุณาลองอีกครั้ง!')->persistent('ปิด');
            return back()->withInput();
        }
    }
}
