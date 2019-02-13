<?php

namespace App\Http\Controllers;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use Illuminate\Http\Request;

class PlaceAPIController extends Controller
{
    /**
     * Get API PL
     * from Google Place-API
     * by Stampspv 5810450440
     * more : https://developers.google.com/places/web-service/intro?hl=th
     */

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

        // FOR LOOP
//        foreach ($outputs['results'] as $each){
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
//        }

        return view('Home.showData',['data'=>$outputs['results']]);

    }
}