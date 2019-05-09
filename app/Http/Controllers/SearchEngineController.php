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
                        $inarr['place_id'] = $shop->place_id;
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
                $inarr['place_id'] = $shop->place_id;
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

    public function placeDetail($place_id)
    {
        $shop = Shop::where('place_id',$place_id)->first();
        // ไปเอา detail
        $urlGetdata = "https://maps.googleapis.com/maps/api/place/details/json?placeid=$place_id&key=AIzaSyCCfe5aS3YBeRqcAevRwJMzUwO5LCbZ2jk";
        $jsonDetail = file_get_contents($urlGetdata);
        $dataDetail = json_decode($jsonDetail,true);


        //ตัวแปรที่จะส่งไป
        $openNow = null;
        $weekdays = null;
        $photo_toshow = null;
        $reviews_toshow = null;

        if (array_key_exists('result',$dataDetail)) {
            if (array_key_exists('international_phone_number',$dataDetail['result'])){
                $phone_number = $dataDetail['result']['international_phone_number'];
                $phone_number = str_replace(' ','-',$phone_number);
                $shop->phone_number = $phone_number;
            }

            if (array_key_exists('opening_hours',$dataDetail['result'])){
                $openNow = $dataDetail['result']['opening_hours']['open_now']; // เปิด/ปิด หรือไม่
                $weekdays = $dataDetail['result']['opening_hours']['weekday_text']; // เวลาทำการ
            }
            if (array_key_exists('photos',$dataDetail['result'])){ // เปิด/ปิด หรือไม่
                $photos_arr = $dataDetail['result']['photos'];
                $photo_toshow = array();
                if ($photos_arr){
                    $shop->photo_ref = $photos_arr[0]['photo_reference'];
                    foreach ($photos_arr as $photo){
                        array_push($photo_toshow,$photo['photo_reference']);
                    }
                }
            }
            if (array_key_exists('reviews',$dataDetail['result'])){
                $reviews = $dataDetail['result']['reviews']; // มีรีวิว
                $reviews_toshow = array();
                if ($reviews){
                    foreach ($reviews as $in_review){
                        $in_text = array();
                        $in_text['user_name'] = $in_review['author_name'];
                        $in_text['profile_photo'] = $in_review['profile_photo_url'];
                        $in_text['give_rate'] = $in_review['rating'];
                        $in_text['text'] = $in_review['text'];
                        array_push($reviews_toshow,$in_text);
                    }
                }
            }
        }

        try{
            $shop->save();
        }catch (\Exception $x){
        }

        return view('Home.placeDetail',[
            'shop'=>$shop,
            'openNow'=>$openNow,
            'weekdays'=>$weekdays,
            'photo_toshow'=>$photo_toshow,
            'reviews_toshow'=>$reviews_toshow
        ]);
    }


}
