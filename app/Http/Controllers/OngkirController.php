<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class OngkirController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getprovince() {
        $client = new Client();

        try {
            $response = $client->get('https://api.rajaongkir.com/starter/province',
                array(
                    'headers' => array(
                        'key' => 'e7be113c0ed4432e97b48362b7f2cbc0',
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
                        'key' => 'e7be113c0ed4432e97b48362b7f2cbc0',
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
                        'key' => 'e7be113c0ed4432e97b48362b7f2cbc0',
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
                        'key' => 'e7be113c0ed4432e97b48362b7f2cbc0',
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
                        'key' => 'e7be113c0ed4432e97b48362b7f2cbc0',
                        'content-type' => 'application/x-www-form-urlencoded',
                    ]
                ]
            );
        } catch (RequestException $e) {
            var_dump($e->getResponse()->getBody()->getContents());
        }

        $json = $response->getBody()->getContents();

        $array_result = json_decode($json, true);

        echo "<input id='shipping' list='shipping_list' class='form-control' placeholder='Kurir'>";
        echo "<datalist id='shipping_list'>";
        echo $array_result['rajaongkir']['results'][0]['name'];
        for ($i=0; $i < count($array_result['rajaongkir']['results'][0]['costs']); $i++) {
            $service = $array_result['rajaongkir']['results'][0]['costs'][$i]['service'];
            $price = $array_result['rajaongkir']['results'][0]['costs'][$i]['cost'][0]['value'];;
            $etd = $array_result['rajaongkir']['results'][0]['costs'][$i]['cost'][0]['etd'];

            echo "<option value='$price'>$service . $price . $etd </option>";
        }        
        echo "</datalist>";
    }

}
