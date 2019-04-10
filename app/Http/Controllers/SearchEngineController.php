<?php

namespace App\Http\Controllers;

use App\Shop;
use App\ShopType;
use App\Type;
use Illuminate\Http\Request;
use Alert;
class SearchEngineController extends Controller
{

    public function shopSearch(Request $request){
        $lat = $request->inputLat;
        $lng = $request->inputLng;
        if ($request->inputRange == 0){
            $range = 0;
        }else{
            $range = $request->inputRange;
            $kmInLongitudeDegree = 111.320 * cos( $lng / 180.0 * M_PI);
            $deltaLat = (($range/4)/1000) / 111.1;
            $deltaLong = (($range/4)/1000) / $kmInLongitudeDegree;

            $minLat = $lat - $deltaLat;
            $maxLat = $lat + $deltaLat;
            $minLong = $lng - $deltaLong;
            $maxLong = $lng + $deltaLong;
        }

        //dd($minLat.'--'.$maxLat.'--lng--'.$minLong.'--'.$maxLong );


        if (!$lat || !$lng){
            Alert::error('เกิดข้อผิดพลาดในการระบุตำแหน่ง!', 'กรุณาลองใหม่อีกครั้ง')->persistent('ปิด');
            return back();
        }

        $typeArray = [6,1,8,5,15,9,16,17];
        if (!in_array($request->inputType,$typeArray) && $request->inputType){
            Alert::error('ประเภทผิด!', 'กรุณาลองใหม่อีกครั้ง')->persistent('ปิด');
            return back();
        }
        if ($request->inputName){ // มีชื่ออู่
            $nameSearch = $request->inputName;
            if ($range != 0){ // จำกัด
                $shops = Shop::where('name','LIKE','%'.$request->inputName.'%')->whereBetween('lng',[$maxLong,$minLong])->get();
            }else{ // ไม่จำกัด มีชื่อ
                $shops = Shop::where('name','LIKE','%'.$request->inputName.'%')->get();
            }

        }else{ // ไม่มีชื่อ ก็เอาทั้งหมด ในระยะ
            $nameSearch = null;
            if ($range != 0){ // ไม่มีชื่อ จำกัด
                $shops = Shop::whereBetween('lat',[$minLat,$maxLat])->whereBetween('lng',[$maxLong,$minLong])->get();
            }else{ // ไม่มีชื่อ ไม่จำกัด
                $shops = Shop::all();
            }
        }

        $shop_and_type = array();
        if ($request->inputType){ // ไม่ type
            foreach ($shops as $shop){
                foreach ($shop->shop_types as $type){
                    if ($type->type_id == $request->inputType){
                        $inarr = array();
                        array_push($inarr,$shop->name,$shop->lat,$shop->lng,$shop->formatted_address,$shop->rating);
                        array_push($shop_and_type,$inarr);
                        continue;
                    }
                }
            }
            if ($request->inputType == 6){
                $typeInput = 'อู่ซ่อมรถยนต์';
            }elseif ($request->inputType == 1){
                $typeInput = 'ศูนย์รถยนต์';
            }elseif ($request->inputType == 8){
                $typeInput = 'ล้างรถ-เคลือบสี';
            }elseif ($request->inputType == 5){
                $typeInput = 'ปั้มน้ำมัน';
            }elseif ($request->inputType == 15){
                $typeInput = 'ยาง และ ล้อแม็ก';
            }elseif ($request->inputType == 16){
                $typeInput = 'เครื่องเสียง';
            }elseif ($request->inputType == 17){
                $typeInput = 'ประดับยนต์';
            }elseif ($request->inputType == 9){
                $typeInput = 'บริการเช่ารถ';
            }
        }else{
            $typeInput = null;
            foreach ($shops as $shop){
                $inarr = array();
                array_push($inarr,$shop->name,$shop->lat,$shop->lng,$shop->formatted_address,$shop->rating);
                array_push($shop_and_type,$inarr);
            }
        }

        return view('Home.resultSearch',['results'=>$shop_and_type,'nameSearch'=>$nameSearch,'type'=>$typeInput,'range'=>$range,'lat'=>$lat,'lng'=>$lng]);

    }


}
