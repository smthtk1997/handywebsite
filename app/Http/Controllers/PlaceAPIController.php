<?php

namespace App\Http\Controllers;
use App\Shop;
use App\ShopType;
use App\Type;
use GuzzleHttp\Psr7\Response;
use function GuzzleHttp\Psr7\str;
use GuzzleHttp\Psr7\Stream;
use Illuminate\Http\Request;
use Alert;

class PlaceAPIController extends Controller
{
    /**
     * Get API PL
     * from Google Place-API
     * by Smith 5810450733
     * more : https://developers.google.com/places/web-service/intro?hl=th
     */

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function getPlaceAPI(Response $response,$lat,$lng)
    {
        if ($lat == 1 && $lng = 1){
            // Default Lng Lat
            $lat = "13.939106500000001";
            $lng = "100.73593799999999";
        }
        $endpoint = "https://maps.googleapis.com/maps/api/place/textsearch/json?query=car&location=$lat,$lng&radius=5000&key=AIzaSyCCfe5aS3YBeRqcAevRwJMzUwO5LCbZ2jk";
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
//        dd($outputs);

//         FOR LOOP
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
            }else{
                $shop = $check;
            }
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


//                $checktype = Type::where('name','car_accessory')->first(); //เอาไว้เวลาจะเพิ่มแบบ manual
//                if (!$checktype){
//                    $checktype = new Type();
//                    $checktype->name = 'car_accessory';
//                    $checktype->token = str_random(16);
//                    $checktype->save();
//                }
//
//                $checkShoptype = ShopType::where('shop_id',$shop->id)->where('type_id',$checktype->id)->first();
//                if (!$checkShoptype){
//                    $shoptype = new ShopType();
//                    $shoptype->shop_id = $shop->id;
//                    $shoptype->type_id = $checktype->id;
//                    $shoptype->token = str_random(16);
//                    $shoptype->save();
//                }

        }
        Alert::success('Update Map Successfully!')->autoclose(2000);
        return redirect(url('/google/map/place/update'));


//        return view('Home.showData',['data'=>$outputs['results']]);

    }



    public function MarkerPin(){
        $places = Shop::select('name','lat','lng','formatted_address','rating')->get();
        $arr = array();
        foreach ($places as $place) {
            $inarr = array();
            array_push($inarr,$place->name,$place->lat,$place->lng,$place->formatted_address,$place->rating);
            array_push($arr,$inarr);
        }
        return view('admin.MapPlace',[
            'arr' => $arr,
        ]);
    }




    public function updatePhoto_Ref()
    {
        $place_id = Shop::all();

        foreach ($place_id as $id){
            $place_id_shop = $id->place_id;
            $endpoint = "https://maps.googleapis.com/maps/api/place/details/json?placeid=$place_id_shop&key=AIzaSyCCfe5aS3YBeRqcAevRwJMzUwO5LCbZ2jk";
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

//            $url = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=-33.8670522,151.1957362&radius=5000&name=BestBusiness&key=YOUR_API_KEY';
//            $json = file_get_contents($url);
//            $data = json_decode($json,true);

            //dd($outputs);

            if (array_key_exists('result',$outputs)){

                if (array_key_exists('photos',$outputs['result'])){
                    $ref = $outputs['result']['photos'][0]['photo_reference'];
                }else{
                    $ref = null;
                }

                if (array_key_exists('international_phone_number',$outputs['result'])){
                    $phone_number = $outputs['result']['international_phone_number'];
                    $phone_number = str_replace(' ','-',$phone_number);
                }else{
                    $phone_number = null;
                }

                if (array_key_exists('url',$outputs['result'])){
                    $urlNav = $outputs['result']['url'];
                }else{
                    $urlNav = null;
                }

                $id->photo_ref = $ref;
                $id->phone_number = $phone_number;
                $id->url_nav = $urlNav;
                $id->save();

            }else{
                continue;
            }
        }
        return 'updated';
    }
}