<?php

namespace App\Http\Controllers\ApiController;

use App\Shop;
use App\ShopType;
use App\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Alert;

class InsuranceScrapingController extends Controller
{
    public function viriyahScraping(){
        $data_arr = array();
        for ($i = 1;$i <= 15;$i++){
            libxml_use_internal_errors(true);
            $html = file_get_contents("https://www.viriyah.co.th/th/contact-center-service-search2.php?page=$i&type=garage&part=1&province=&district=&keyword=#.XNaIcdMzZZ0");
            $DOM = new \DOMDocument();
            $DOM->loadHTML($html);
            $finder = new \DomXPath($DOM);
            $classname = 'search-detail';

            for ($j = 1;$j <= 10;$j++){
                $nodes = $finder->query("//ul//li[$j]//div[contains(@class, '$classname')]//h5");
                preg_match('/([1-9]*.) (.*)/', $nodes[0]->nodeValue, $output_array);
                array_push($data_arr,$output_array[2]);
            }
        }

        $this_type = Type::where('name','วิริยะประกันภัย')->first();
        if (!$this_type){
            $this_type = new Type();
            $this_type->name = 'วิริยะประกันภัย';
            $this_type->token = str_random(16);
            try{
                $this_type->save();
            }catch (\Exception $x){
            }
        }

        $save_result = $this->MakeAndSave($data_arr,$this_type);

        if ($save_result){
            Alert::success('อัพเดทข้อมูลสมบูรณ์!')->autoclose(2000);
        }else{
            Alert::error('เกิดข้อผิดพลาด','กรุณาลองอีกครั้ง!')->persistent('ปิด');
        }

    }


    public function bangkokScraping(){
        $data_arr = array();

        libxml_use_internal_errors(true);
        $html = file_get_contents("http://www.bangkokinsurance.com/claim/distributor?type=C&name=&garage_brand=&province=%E0%B8%81%E0%B8%A3%E0%B8%B8%E0%B8%87%E0%B9%80%E0%B8%97%E0%B8%9E%E0%B8%A1%E0%B8%AB%E0%B8%B2%E0%B8%99%E0%B8%84%E0%B8%A3&amphur=");
        $DOM = new \DOMDocument();
        $DOM->loadHTML($html);
        $finder = new \DomXPath($DOM);
        $classname = 'search-detail';

        for ($j = 3;$j <= 97;$j++){
            $nodes = $finder->query("//*[@id=\"table\"]/div[$j]/span[1]/a");
            $place_data = trim($nodes[0]->nodeValue);
            $place_data = str_replace('  ',' ',$place_data);
            if ($place_data != 'จ.รุ่งเรือง'){
                array_push($data_arr,$place_data);
            }

        }

        $this_type = Type::where('name','กรุงเทพประกันภัย')->first();
        if (!$this_type){
            $this_type = new Type();
            $this_type->name = 'กรุงเทพประกันภัย';
            $this_type->token = str_random(16);
            try{
                $this_type->save();
            }catch (\Exception $x){
            }
        }

        $save_result = $this->MakeAndSave($data_arr,$this_type);

        if ($save_result){
            Alert::success('อัพเดทข้อมูลสมบูรณ์!')->autoclose(2000);
        }else{
            Alert::error('เกิดข้อผิดพลาด','กรุณาลองอีกครั้ง!')->persistent('ปิด');
        }

    }


    public function dhipayaScraping(){
        $data_arr = array();

        libxml_use_internal_errors(true);
        $html = file_get_contents("https://www.dhipaya.co.th/INSURANCE/SEARCH_GARAGE.ASPX?ID=0&idMenu=173");
        $DOM = new \DOMDocument();
        $DOM->loadHTML($html);
        $finder = new \DomXPath($DOM);
        $classname = 'dxeBase';

        for ($j = 0;$j <= 111;$j++){
            $nodes = $finder->query("//*[@id=\"Content_BootstrapGridView1_cell\"$j\"_2_dxNameLabel_$j\"]");
            dd($nodes);
            $place_data = trim($nodes[0]->nodeValue);
            $place_data = str_replace('  ',' ',$place_data);
            array_push($data_arr,$place_data);

        }

        $this_type = Type::where('name','ทิพยประกันภัย')->first();
        if (!$this_type){
            $this_type = new Type();
            $this_type->name = 'ทิพยประกันภัย';
            $this_type->token = str_random(16);
            try{
                $this_type->save();
            }catch (\Exception $x){
            }
        }

        $save_result = $this->MakeAndSave($data_arr,$this_type);

        if ($save_result){
            Alert::success('อัพเดทข้อมูลสมบูรณ์!')->autoclose(2000);
        }else{
            Alert::error('เกิดข้อผิดพลาด','กรุณาลองอีกครั้ง!')->persistent('ปิด');
        }

    }


    public function MakeAndSave($place_array,$type_obj)
    {
        $return_result = true;
        foreach ($place_array as $text){
            $text_search = str_replace(' ', '%20', $text);

            $endpoint = "https://maps.googleapis.com/maps/api/place/findplacefromtext/json?input=$text_search&inputtype=textquery&fields=name,formatted_address,geometry,id,place_id,photos,rating&key=AIzaSyCCfe5aS3YBeRqcAevRwJMzUwO5LCbZ2jk";
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



            if ($outputs['candidates']){
                foreach ($outputs['candidates'] as $shop_place){
                    $check = Shop::where('map_id',$shop_place['id'])->first();
                    if (!$check){
                        $shop = new Shop();
                        $shop->name = $shop_place['name'];
                        $shop->formatted_address = $shop_place['formatted_address'];
                        $shop->lat = $shop_place['geometry']['location']['lat'];
                        $shop->lng = $shop_place['geometry']['location']['lng'];
                        $shop->map_id = $shop_place['id'];
                        $shop->place_id = $shop_place['place_id'];
                        $shop->rating = $shop_place['rating'];
                        $shop->token = str_random(16);
                        if (array_key_exists('photos',$shop_place)){
                            $shop->photo_ref = $shop_place['photos'][0]['photo_reference'];
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

                            $shop->phone_number = $phone_number;
                            $shop->url_nav = $urlNav;
                            try{
                                $shop->save();
                            }catch (\Exception $x){
                                $return_result = false;
                            }

                            foreach ($dataDetail['result']['types'] as $type){
                                $checktype = Type::where('name',$type)->first();
                                if (!$checktype){
                                    $checktype = new Type();
                                    $checktype->name = $type;
                                    $checktype->token = str_random(16);
                                    try{
                                        $checktype->save();
                                    }catch (\Exception $x){
                                        $return_result = false;
                                    }
                                }

                                $checkShoptype = ShopType::where('shop_id',$shop->id)->where('type_id',$checktype->id)->first();
                                $check_insurance_type = ShopType::where('shop_id',$shop->id)->where('type_id',$type_obj->id)->first();
                                if (!$checkShoptype){
                                    $shoptype = new ShopType();
                                    $shoptype->shop_id = $shop->id;
                                    $shoptype->type_id = $checktype->id;
                                    $shoptype->token = str_random(16);
                                    try{
                                        $shoptype->save();
                                    }catch (\Exception $x){
                                        $return_result = false;
                                    }
                                }
                                if (!$check_insurance_type){
                                    $shoptype_insurance = new ShopType();
                                    $shoptype_insurance->shop_id = $shop->id;
                                    $shoptype_insurance->type_id = $type_obj->id;
                                    $shoptype_insurance->token = str_random(16);
                                    try{
                                        $shoptype_insurance->save();
                                    }catch (\Exception $x){
                                        $return_result = false;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $return_result;
    }
}
