<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ApiController\InsuranceScrapingController;
use App\Insurance;
use App\Review;
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
        $size_shop = 0;

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
                $shops = Shop::orderBy('rating','desc')->where('name','LIKE','%'.$request->inputName.'%')->whereBetween('lat',[$minLat,$maxLat])->whereBetween('lng',[$minLong,$maxLong])->get();
            }else{ // ไม่จำกัดระยะ มีชื่อ
                $shops = Shop::orderBy('rating','desc')->where('name','LIKE','%'.$request->inputName.'%')->get();
            }

        }else{ // ไม่มีชื่อ ก็เอาทั้งหมด ในระยะ
            $nameSearch = null;
            if ($range != 0){ // ไม่มีชื่อ จำกัดระยะ
                $shops = Shop::orderBy('rating','desc')->whereBetween('lat',[$minLat,$maxLat])->whereBetween('lng',[$minLong,$maxLong])->get();
            }else{ // ไม่มีชื่อ ไม่จำกัดระยะ
                $shops = Shop::orderBy('rating','desc')->get();
            }
        }



        $shop_and_type = array();

        if ($request->inputInsurance){

            $get_insurance_name = Type::select('name')->where('id',$request->inputInsurance)->first();
            $insurance_input = $get_insurance_name->name;

            foreach ($shops as $shop){
                foreach ($shop->shop_types as $type){
                    if ($type->type_id == $request->inputInsurance){
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

        }else{
            $insurance_input = null;
        }

        if ($insurance_input == null){
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
        }else{
            $typeInput = null;
        }

        if ($shop_and_type == null){
            Alert::warning('ไม่พบข้อมูลที่คุณต้องการ','กรุณาลองอีกครั้ง!')->persistent('ปิด');
            $size_shop = 0;
        }

        $size_shop = sizeof($shop_and_type);
        $to_marker = $shop_and_type;

        return view('Home.resultSearch',['results'=> collect($shop_and_type)->paginate(30),'toMark'=>$to_marker,'nameSearch'=>$nameSearch,'type'=>$typeInput,'insurance'=>$insurance_input,'range'=>$range,'lat'=>$lat,'lng'=>$lng,'size_shop'=>$size_shop]);

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

    public function get_type_inBound()
    {
        $form_data = array();
        $aNord = $_POST['aNord'];
        $aEst = $_POST['aEst'];
        $aSud = $_POST['aSud'];
        $aOvest = $_POST['aOvest'];
        $type = $_POST['type'];
        $insurance = $_POST['insurance'];

        $sended = array();

        if ($type != 'typeInsure'){

            $places = ShopType::where('type_id',$type)->get();

            if ($insurance == null){
                foreach ($places as $place){
                    $shop = $place->shop()->whereBetween('lat',[$aSud,$aNord])->whereBetween('lng',[$aOvest,$aEst])->first();
                    if ($shop != null){
                        array_push($sended,$shop);
                    }
                }
            }
        }else{
            if ($insurance != null){
                $places = ShopType::where('type_id',$insurance)->get();

                foreach ($places as $place){
                    $shop = $place->shop()->whereBetween('lat',[$aSud,$aNord])->whereBetween('lng',[$aOvest,$aEst])->first();
                    if ($shop != null){
                        array_push($sended,$shop);
                    }
                }
            }
        }

        if (sizeof($sended) > 0){
            $form_data['places'] = $sended;
            $form_data['status'] = true;
        }else{
            $form_data['status'] = false;
        }

        return json_encode($form_data, JSON_UNESCAPED_UNICODE);
    }

    public function search_on_map_view()
    {
        $insurances = Insurance::all();
        return view('Home.onMap',['insurances'=>$insurances]);
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
                    $ref_update = $photos_arr[0]['photo_reference'];
//                    $check_ref_update = $this->check_url("https://maps.googleapis.com/maps/api/place/photo?maxwidth=1000&photoreference=$ref_update&key=AIzaSyCCfe5aS3YBeRqcAevRwJMzUwO5LCbZ2jk");
//                    if ($check_ref_update == '302'){
//                        $shop->photo_ref = $ref_update;
//                    }
                    $shop->photo_ref = $ref_update;
                    foreach ($photos_arr as $photo){
//                        $ref = $photo['photo_reference'];
//                        $check_url_status = $this->check_url("https://maps.googleapis.com/maps/api/place/photo?maxwidth=1000&photoreference=$ref&key=AIzaSyCCfe5aS3YBeRqcAevRwJMzUwO5LCbZ2jk");
//                        if ($check_url_status == '302'){
//                            array_push($photo_toshow,$photo['photo_reference']);
//                        }
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

        $review_inhandy = Review::where('shop_id',$shop->id)->get();

        return view('Home.placeDetail',[
            'shop'=>$shop,
            'openNow'=>$openNow,
            'weekdays'=>$weekdays,
            'photo_toshow'=>$photo_toshow,
            'reviews_toshow'=>$reviews_toshow,
            'reviews_handy'=>$review_inhandy
        ]);
    }


    function check_url($url) {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch , CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        $headers = curl_getinfo($ch);
        curl_close($ch);

        return $headers['http_code'];
    }


}
