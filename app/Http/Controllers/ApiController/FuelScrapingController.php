<?php

namespace App\Http\Controllers\ApiController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FuelScrapingController extends Controller
{
    public function getFuelPriceApi_Ptt() // ptt and other
    {
        libxml_use_internal_errors(true);
        $html = file_get_contents("http://www.pttplc.com/th/getoilprice.aspx/");
        $DOM = new \DOMDocument();
        $DOM->loadHTML($html);
        $finder = new \DomXPath($DOM);

        $showvalue = null;

        $form_data = array();

        $fuel_type = $_POST['fuel_type'];

        if ($fuel_type == 'เบนซิน-95'){
            $nodes = $finder->query("//*[@id='g_2963d969_94e5_4921_b8c3_9739b0799200_ctl00_uxGasoline95PriceDiv']");
            $showvalue = $nodes[0]->nodeValue;
        }elseif ($fuel_type == 'แก๊สโซฮอล์-91'){
            $nodes = $finder->query("//*[@id='g_2963d969_94e5_4921_b8c3_9739b0799200_ctl00_uxGasohol91PriceDiv']");
            $showvalue = $nodes[0]->nodeValue;
        }elseif ($fuel_type == 'แก๊สโซฮอล์-95'){
            $nodes = $finder->query("//*[@id='g_2963d969_94e5_4921_b8c3_9739b0799200_ctl00_uxGasohol95PriceDiv']");
            $showvalue = $nodes[0]->nodeValue;
        }elseif ($fuel_type == 'แก๊สโซฮอล์-E20'){
            $nodes = $finder->query("//*[@id='g_2963d969_94e5_4921_b8c3_9739b0799200_ctl00_uxGasoholE20PriceDiv']");
            $showvalue = $nodes[0]->nodeValue;
        }elseif ($fuel_type == 'แก๊สโซฮอล์-E85'){
            $nodes = $finder->query("//*[@id='g_2963d969_94e5_4921_b8c3_9739b0799200_ctl00_uxGasoholE85PriceDiv']");
            $showvalue = $nodes[0]->nodeValue;
        }elseif ($fuel_type == 'ดีเซล'){
            $nodes = $finder->query("//*[@id='g_2963d969_94e5_4921_b8c3_9739b0799200_ctl00_uxDieselPriceDiv']");
            $showvalue = $nodes[0]->nodeValue;
        }elseif ($fuel_type == 'ดีเซลพรีเมี่ยม'){
            $nodes = $finder->query("//*[@id='g_2963d969_94e5_4921_b8c3_9739b0799200_ctl00_uxHyForcePremiumDieselDiv']");
            $showvalue = $nodes[0]->nodeValue;
        }

        if ($showvalue != null){
            $form_data['status'] = true;
            $form_data['price'] = $showvalue;
        }else{
            $form_data['status'] = false;
        }

        return json_encode($form_data, JSON_UNESCAPED_UNICODE);
    }



    public function getFuelPriceApi_Shell() // shell and other
    {
        libxml_use_internal_errors(true);
        $html = file_get_contents("https://www.shell.co.th/th_th/motorists/shell-fuels/fuel-price/app-fuel-prices.html");
        $DOM = new \DOMDocument();
        $DOM->loadHTML($html);
        $finder = new \DomXPath($DOM);

        $showvalue = null;

        $form_data = array();

        $fuel_type = $_POST['fuel_type'];

        if ($fuel_type == 'เบนซิน-95'){
            $nodes = $finder->query("//*[@id=\"id-9bce55c5da5287b701ef4cff38245f9c3c57a22fb2268e9e888e4822c5f229d8\"]/div[2]/section/div/div/article/div/table/tbody/tr[7]/td[2]");
            $showvalue = $nodes[0]->nodeValue;
        }elseif ($fuel_type == 'แก๊สโซฮอล์-91'){
            $nodes = $finder->query("//*[@id=\"id-9bce55c5da5287b701ef4cff38245f9c3c57a22fb2268e9e888e4822c5f229d8\"]/div[2]/section/div/div/article/div/table/tbody/tr[3]/td[2]");
            $showvalue = $nodes[0]->nodeValue;
        }elseif ($fuel_type == 'แก๊สโซฮอล์-95'){
            $nodes = $finder->query("//*[@id=\"id-9bce55c5da5287b701ef4cff38245f9c3c57a22fb2268e9e888e4822c5f229d8\"]/div[2]/section/div/div/article/div/table/tbody/tr[4]/td[2]");
            $showvalue = $nodes[0]->nodeValue;
        }elseif ($fuel_type == 'แก๊สโซฮอล์-E20'){
            $nodes = $finder->query("//*[@id=\"id-9bce55c5da5287b701ef4cff38245f9c3c57a22fb2268e9e888e4822c5f229d8\"]/div[2]/section/div/div/article/div/table/tbody/tr[2]/td[2]");
            $showvalue = $nodes[0]->nodeValue;
        }elseif ($fuel_type == 'แก๊สโซฮอล์-E85'){
            $showvalue = 'none';
        }elseif ($fuel_type == 'ดีเซล'){
            $nodes = $finder->query("//*[@id=\"id-9bce55c5da5287b701ef4cff38245f9c3c57a22fb2268e9e888e4822c5f229d8\"]/div[2]/section/div/div/article/div/table/tbody/tr[5]/td[2]");
            $showvalue = $nodes[0]->nodeValue;
        }elseif ($fuel_type == 'ดีเซลพรีเมี่ยม'){
            $nodes = $finder->query("//*[@id=\"id-9bce55c5da5287b701ef4cff38245f9c3c57a22fb2268e9e888e4822c5f229d8\"]/div[2]/section/div/div/article/div/table/tbody/tr[8]/td[2]");
            $showvalue = $nodes[0]->nodeValue;
        }

        if ($showvalue != null){
            $form_data['status'] = true;
            $form_data['price'] = $showvalue;
        }else{
            $form_data['status'] = false;
        }

        return json_encode($form_data, JSON_UNESCAPED_UNICODE);
    }
}
