<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class OngkirController extends Controller
{

    public function getprovince() {
        $client = new Client();

        try {
            $response = $client->get('https://api.rajaongkir.com/starter/province',
                array(
                    'headers' => array(
                        'key' => '7e9918182ae85d0888e9b5933b421409',
                    )
                )
            );
        } catch (RequestException $e) {
            var_dump($e->getResponse()->getBody()->getContents());
        }

        $json = $response->getBody()->getContents();

        $array_result = json_decode($json, true);

        for ($i=0; $i < count($array_result['rajaongkir']['results']); $i++) { 
            echo "<option value='".$array_result['rajaongkir']['results'][$i]['province_id']."'>".$array_result['rajaongkir']['results'][$i]['province']."</option>";
        }

    }

    public function getcity(Request $request) {

        $client = new Client();

        try {
            $response = $client->get('https://api.rajaongkir.com/starter/city?province='.$request->province_id,
                array(
                    'headers' => array(
                        'key' => '7e9918182ae85d0888e9b5933b421409',
                    )
                )
            );
        } catch (RequestException $e) {
            var_dump($e->getResponse()->getBody()->getContents());
        }

        $json = $response->getBody()->getContents();

        $array_result = json_decode($json, true);

        for ($i=0; $i < count($array_result['rajaongkir']['results']); $i++) { 
            echo "<option value='".$array_result['rajaongkir']['results'][$i]['city_id']."'>".$array_result['rajaongkir']['results'][$i]['city_name']."</option>";
        }
    }

    public function getprovinceId(Request $request) {
        $client = new Client();

        try {
            $response = $client->get('https://api.rajaongkir.com/starter/province',
                array(
                    'headers' => array(
                        'key' => '7e9918182ae85d0888e9b5933b421409',
                    )
                )
            );
        } catch (RequestException $e) {
            var_dump($e->getResponse()->getBody()->getContents());
        }

        $json = $response->getBody()->getContents();

        $array_result = json_decode($json, true);

        echo $array_result['rajaongkir']['results'][$request->province_id]['province'];

    }

    public function getcityId(Request $request) {

        $client = new Client();

        try {
            $response = $client->get('https://api.rajaongkir.com/starter/city',
                array(
                    'headers' => array(
                        'key' => '7e9918182ae85d0888e9b5933b421409',
                    )
                )
            );
        } catch (RequestException $e) {
            var_dump($e->getResponse()->getBody()->getContents());
        }

        $json = $response->getBody()->getContents();

        $array_result = json_decode($json, true);

        echo $array_result['rajaongkir']['results'][$request->city_id]['city_name'];
    }
    
    public function checkshipping(Request $request) {
        $client = new Client();

        try {
            $response = $client->request('POST', 'https://api.rajaongkir.com/starter/cost',
                [
                    'body' => 'origin='.$request->origin.'&destination='.$request->dst.'&weight='.$request->weight.'&courier='.$request->courier.'',
                    'headers' => [
                        'key' => '7e9918182ae85d0888e9b5933b421409',
                        'content-type' => 'application/x-www-form-urlencoded',
                    ]
                ]
            );
        } catch (RequestException $e) {
            var_dump($e->getResponse()->getBody()->getContents());
        }

        $json = $response->getBody()->getContents();

        $array_result = json_decode($json, true);

        echo $array_result['rajaongkir']['results'][0]['name'];
        echo "<br>";
        for ($i=0; $i < count($array_result['rajaongkir']['results'][0]['costs']); $i++) { 
            echo $array_result['rajaongkir']['results'][0]['costs'][$i]['service']; echo " - Rp";
            echo $array_result['rajaongkir']['results'][0]['costs'][$i]['cost'][0]['value']; echo " - Estimasi ";
            echo $array_result['rajaongkir']['results'][0]['costs'][$i]['cost'][0]['etd']; echo " hari";
            echo "<br>";
        }        
    }

}
