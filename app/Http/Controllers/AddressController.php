<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Province;
use App\City;
use App\Postal;

class AddressController extends Controller
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

    public function getProvince() {
        
        $province = Province::all();

        echo "<option selected'></option>";
        for ($i=0; $i < count($province); $i++) { 
            echo "<option value='".$province[$i]['province_id']."'>".$province[$i]['province_name']."</option>";
        }

    }

    public function getCity(Request $request) {

        $city = City::select('city_id', 'city_name')
        ->where('province_id', $request->province_id)
        ->get();

        for ($i=0; $i < count($city); $i++) { 
            echo "<option value='".$city[$i]['city_id']."'>".$city[$i]['city_name']."</option>";
        }
    }

    public function getPostal(Request $request) {

        // $postal = Postal::where('province_id', $request->province_id)->get();
        $postal = Postal::select('postal_code', 'district')
        ->distinct()
        ->where('city', 'LIKE', $request->city_name)
        ->orderBy('postal_code')
        ->get();

        for ($i=0; $i < count($postal); $i++) { 
            echo "<option value='".$postal[$i]['postal_code']."'>".$postal[$i]['district']." - ".$postal[$i]['postal_code']."</option>";
        }
    }

    public function getUrban(Request $request) {

        $urban = Postal::select('postal_code', 'urban')
        ->where('postal_code', $request->postal_code)
        ->get();

        for ($i=0; $i < count($urban); $i++) { 
            echo "<option value=''>".$urban[$i]['urban']."</option>";
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
