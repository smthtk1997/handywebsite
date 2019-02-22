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



//            echo $each['id'];
//            echo "<br>";
//            echo $each['formatted_address'];
//            echo "<br>";
//            echo $each['name'];
//            echo "<br>";
//            echo $each['geometry']['location']['lat'];
//            echo "<br>";
//            echo $each['geometry']['location']['lng'];
//            echo "<br>";
//            echo "<hr>";
        }
        Alert::success('Update Map Successfully!');
        return redirect(url('/google/map/place/update'));

        //return 'pass';

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
}