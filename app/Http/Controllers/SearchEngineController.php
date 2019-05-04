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
            $range = $request->inputRange; // ระยะจาก Input เป็น meter
            $distance = $range/1000; // distance in KM
            $R = 6371; //constant earth radius. You can add precision here if you wish

            $maxLat = $lat + rad2deg($distance/$R);
            $minLat = $lat - rad2deg($distance/$R);
            $maxLong = $lng + rad2deg(asin($distance/$R) / cos(deg2rad($lat)));
            $minLong = $lng - rad2deg(asin($distance/$R) / cos(deg2rad($lat)));
            //dd($minLat.'--'.$maxLat.'--lng--'.$minLong.'--'.$maxLong );
        }

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
            if ($range != 0){ // จำกัดระยะ มีชื่อ
                $shops = Shop::where('name','LIKE','%'.$request->inputName.'%')->whereBetween('lat',[$minLat,$maxLat])->whereBetween('lng',[$minLong,$maxLong])->get();
            }else{ // ไม่จำกัดระยะ มีชื่อ
                $shops = Shop::where('name','LIKE','%'.$request->inputName.'%')->get();
            }

        }else{ // ไม่มีชื่อ ก็เอาทั้งหมด ในระยะ
            $nameSearch = null;
            if ($range != 0){ // ไม่มีชื่อ จำกัดระยะ
                $shops = Shop::whereBetween('lat',[$minLat,$maxLat])->whereBetween('lng',[$minLong,$maxLong])->get();
            }else{ // ไม่มีชื่อ ไม่จำกัดระยะ
                $shops = Shop::all();
            }
        }

        $shop_and_type = array();
        if ($request->inputType){ // ไม่ type
            foreach ($shops as $shop){
                foreach ($shop->shop_types as $type){
                    if ($type->type_id == $request->inputType){
                        $inarr = array();
                        $inarr['shop_name'] = $shop->name;
                        $inarr['shop_lat'] = $shop->lat;
                        $inarr['shop_lng'] = $shop->lng;
                        $inarr['formatted_address'] = $shop->formatted_address;
                        $inarr['shop_rating'] = $shop->rating;
                        $inarr['shop_photo_ref'] = $shop->photo_ref;
                        $inarr['shop_phone_number'] = $shop->phone_number;
                        $inarr['shop_url_nav'] = $shop->url_nav;
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
                $inarr['shop_name'] = $shop->name;
                $inarr['shop_lat'] = $shop->lat;
                $inarr['shop_lng'] = $shop->lng;
                $inarr['formatted_address'] = $shop->formatted_address;
                $inarr['shop_rating'] = $shop->rating;
                $inarr['shop_photo_ref'] = $shop->photo_ref;
                $inarr['shop_phone_number'] = $shop->phone_number;
                $inarr['shop_url_nav'] = $shop->url_nav;
                array_push($shop_and_type,$inarr);
            }
        }


        return view('Home.resultSearch',['results'=>$shop_and_type,'nameSearch'=>$nameSearch,'type'=>$typeInput,'range'=>$range,'lat'=>$lat,'lng'=>$lng]);

    }


    public function get_Place_inBound()
    {
        $form_data = array();
        $aNord = $_POST['aNord'];
        $aEst = $_POST['aEst'];
        $aSud = $_POST['aSud'];
        $aOvest = $_POST['aOvest'];

        $places = Shop::whereBetween('lat',[$aSud,$aNord])->whereBetween('lng',[$aOvest,$aEst])->get();

        if ($places->count() > 0){
            $form_data['places'] = $places;
            $form_data['status'] = true;
        }else{
            $form_data['status'] = false;
        }

        return json_encode($form_data, JSON_UNESCAPED_UNICODE);

    }

    public function search_on_map_view()
    {
        return view('Home.onMap');
    }


}
