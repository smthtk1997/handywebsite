<?php

namespace App\Http\Controllers;

use App\UserCars;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Alert;

class UserCarsController extends Controller
{
    public function createCarIndex(){
        return view('users.FuelLog.createCar');
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
            'brand'=>strtolower($request->brand),
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
            Alert::error('เกิดข้อผิดพลาด','กรุณาลองอีกครั้ง!')->persistent('Close');
            return back()->withInput();
        }
    }
}
