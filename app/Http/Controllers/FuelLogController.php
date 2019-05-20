<?php

namespace App\Http\Controllers;

use App\FuelLog;
use App\UserCars;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Alert;

class FuelLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('active');
    }

    public function fuelLogIndex(){
        $cars = UserCars::where('user_id',Auth::user()->id)->get();
        return view('users.FuelLog.fuellogIndex',['cars'=>$cars]);
    }


    public function myLogIndex(UserCars $car)
    {
        $logs = FuelLog::orderBy('filling_date','desc')->where('car_id',$car->id)->get();

        if ($logs->count() > 0){
            $last_year = $logs[count($logs)-1]->filling_date;
        }else{
            $logs = null;
            $last_year = null;
        }
        $month = Carbon::now()->format('F Y');
        return view('users.FuelLog.myLog',['car'=>$car,'logs'=>$logs,'last_year'=>$last_year,'month'=>$month]);
    }

    public function myLogRefuel(UserCars $car){
        //$last_fuel = FuelLog::where('car_id',$car->id)->orderBy('created_at','desc')->first();
        return view('users.FuelLog.reFuel',['car'=>$car]);
    }

    public function myLogRefuel_save(Request $request,UserCars $car)
    {
        $this->validate($request,[
            'selectorDate' => 'required',
            'selectorTime' => 'required',
            'mileage' => 'required|integer|min:'.$car->mileage,
            'gas_station'=> 'required',
            'fuel_type'=>'required',
            'price_liter'=>'required',
            'total_price'=>'required',
            'total_liter'=>'required',
            'user_lat'=>'required',
            'user_lng'=>'required',
        ]);

//        if($request->hasFile('slip_img')) {
//            $files = $request->file('slip_img');
//            $file = Input::file('slip_img')->getClientOriginalName();
//            $filename = pathinfo($file, PATHINFO_FILENAME);
//            $path = $filename.'-'.time() . '.' . $files->getClientOriginalExtension();
//            $destinationPath = storage_path('/files/fuel_log_slip/');
//            $files->move($destinationPath, $path);
//            $file_path_toDB = $path;
//
//        }else{
//            $file_path_toDB = null;
//        }

        $date_format = Carbon::createFromFormat('d/m/y',$request->selectorDate);
        $date_format = Carbon::parse($date_format)->toDateString();

        $refuel = new FuelLog([
            'car_id'=>$car->id,
            'img_slip'=>null,
            'filling_date'=>$date_format,
            'filling_time'=>Carbon::parse($request->selectorTime)->format('H:i:s'),
            'mileage'=>$request->mileage,
            'gas_station'=>$request->gas_station,
            'fuel_type'=>$request->fuel_type,
            'price_liter'=>$request->price_liter,
            'total_price'=>$request->total_price,
            'total_liter'=>$request->total_liter,
            'filling_lat'=>$request->user_lat,
            'filling_lng'=>$request->user_lng,
            'token'=>str_random(16),
        ]);

        $car->mileage = $request->mileage;

        try{
            $refuel->save();
            $car->save();
            Alert::success('บันทึกข้อมูลเรียบร้อย','สำเร็จ!')->autoclose(2000);
            return redirect()->route('fuellog.myLog',['car'=>$car]);

        }catch (\Exception $x){
            Alert::error('เกิดข้อผิดพลาด','กรุณาลองอีกครั้ง!')->persistent('ปิด');
            return back()->withInput();
        }

    }


    public function inMonth()
    {
        $form_data = array();
        $date_toquery = '1-'.$_POST['date'];
        $carID_toquery = $_POST['car'];

        $date_format = Carbon::createFromFormat('d-M-Y',$date_toquery);
        $date_format = Carbon::parse($date_format)->toDateString();
        $month = Carbon::parse($date_format)->month;
        $year = Carbon::parse($date_format)->year;

        $logs = FuelLog::orderBy('filling_date','desc')->whereYear('filling_date', '=', $year)
            ->whereMonth('filling_date', '=', $month)
            ->where('car_id',$carID_toquery)
            ->get();

        if ($logs->count() > 0){
            $form_data['logs'] = $logs;
            $form_data['date_Show'] = Carbon::parse($date_format)->format('F Y');
            $form_data['status'] = true;
        }else{
            $form_data['status'] = false;
        }

        return json_encode($form_data, JSON_UNESCAPED_UNICODE);
    }



    public function myLogConclude(UserCars $car)
    {
        $month = ['Jan','Feb','Mar','Apr','May','Jun','July','Aug','Sept','Oct','Nov','Dec'];
        $this_year = Carbon::now()->year;
        $all_year = FuelLog::where('car_id',$car->id)->distinct()->get([DB::raw('YEAR(filling_date) as all_year')]);


        $sended = array();

        $sended['data'] = FuelLog::orderBy('filling_date','desc')
            ->where('car_id',$car->id)
            ->whereYear('filling_date', '=', $this_year)
            ->get();

        if ($all_year->count() == 0 && sizeof($sended) == 0){
            $all_year = null;
            $sended = null;
        }

        if (sizeof($sended) > 0){
            $total_price = 0;
            $total_liter = 0;
            for ($i = 0; $i < 12 ; $i++){
                $month_price = 0;
                $month_liter = 0;
                foreach ($sended['data'] as $log){
                    if (Carbon::parse($log->filling_date)->month -1 == $i){
                        $month_price += (int)$log->total_price;
                        $month_liter += (float)$log->total_liter;
                    }
                }
                $sended['month_price'][$month[$i]] = $month_price;
                $sended['month_liter'][$month[$i]] = $month_liter;
                $total_price += (int)$month_price;
                $total_liter += (float)$month_liter;
            }
            $sended['total_price'] = $total_price;
            $sended['total_liter'] = $total_liter;
            $sended = json_encode($sended, JSON_UNESCAPED_UNICODE);
        }else{
            $sended = null;
        }

        return view('users.FuelLog.LogConclude',
            [
                'car'=>$car,
                'this_year'=>$this_year,
                'all_year'=>$all_year,
                'logs_data'=>$sended
            ]);
    }

    public function queryYear()
    {
        $sended = array();
        $month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];
        $year = $_POST['year'];
        $carID_toquery = $_POST['car_id'];

        $sended['data'] = FuelLog::orderBy('filling_date', 'desc')
            ->where('car_id', $carID_toquery)
            ->whereYear('filling_date', '=', $year)
            ->get();

        if (sizeof($sended) > 0) {
            $total_price = 0;
            $total_liter = 0;
            for ($i = 0; $i < 12; $i++) {
                $month_price = 0;
                $month_liter = 0;
                foreach ($sended['data'] as $log) {
                    if (Carbon::parse($log->filling_date)->month - 1 == $i) {
                        $month_price += (int)$log->total_price;
                        $month_liter += (float)$log->total_liter;
                    }
                }
                $sended['month_price'][$month[$i]] = $month_price;
                $sended['month_liter'][$month[$i]] = $month_liter;
                $total_price += (int)$month_price;
                $total_liter += (float)$month_liter;
            }
            $sended['total_price'] = $total_price;
            $sended['total_liter'] = $total_liter;
            $sended['year'] = $year;

            $sended['status'] = true;

        }else{
            $sended['status'] = false;
        }

        return json_encode($sended, JSON_UNESCAPED_UNICODE);
    }


    public function myLogRefuelEdit(FuelLog $log)
    {
        return view('users.FuelLog.reFuelEdit',['log'=>$log]);
    }

    public function myLogRefuelUpdate(Request $request,FuelLog $log)
    {
        $this->validate($request,[
            'selectorDate' => 'required',
            'selectorTime' => 'required',
            'mileage' => 'required',
            'gas_station'=> 'required',
            'fuel_type'=>'required',
            'price_liter'=>'required',
            'total_price'=>'required',
            'total_liter'=>'required'
        ]);

        try{
            $date_format = Carbon::createFromFormat('d/m/y',$request->selectorDate);
            $date_format = Carbon::parse($date_format)->toDateString();

        }catch (\Exception $x){
            $date_format = Carbon::createFromFormat('d/m/Y',$request->selectorDate);
            $date_format = Carbon::parse($date_format)->toDateString();
        }

        $log->filling_date = $date_format;
        $log->filling_time = Carbon::parse($request->selectorTime)->format('H:i:s');
        $log->mileage = $request->mileage;
        $log->gas_station = $request->gas_station;
        $log->fuel_type = $request->fuel_type;
        $log->price_liter = $request->price_liter;
        $log->total_price = $request->total_price;
        $log->total_liter = $request->total_liter;

        try{
            $log->save();
            Alert::success('อัพเดทข้อมูลเรียบร้อย','สำเร็จ!')->autoclose(2000);
            return redirect()->route('fuellog.myLog',['car'=>$log->get_car()->first()]);

        }catch (\Exception $x){
            Alert::error('เกิดข้อผิดพลาด','กรุณาลองอีกครั้ง!')->persistent('ปิด');
            return back()->withInput();
        }

    }


}
