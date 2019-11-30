<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Request as RequestInput;
use Illuminate\Support\Facades\Input;
use Auth;
use DB;

use App\User;
use App\Purchase;
use App\Purchase_item;
use App\Transaction;

class PayController extends Controller
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

    public function pay() {

        $id = Auth::user()->id;

        $usr_buyer = User::select('users.name', 'users.phone_number', 'location.address', 'postal.district', 'location.postal_code', 'cityloc.city_name', 'provinceloc.province_name')
        ->join('location', 'users.id', '=',  'location.user_id', 'LEFT OUTER')
        ->join('postal', 'postal.postal_code', '=', 'location.postal_code')
        ->join('cityloc', 'cityloc.city_id', '=', 'location.city_id')
        ->join('provinceloc', 'provinceloc.province_id', '=', 'location.province_id')
        ->where('users.id', $id)->get();

        return view('pay', [
            'usr_buyer' => $usr_buyer,
        ]);
    }

    public function payCartList() {
        $id = Auth::user()->id;

        $cartList = Purchase_item::select('users.name AS seller', 'purchase_item.amount', 'purchase_item.selling_price', 'item.item_id', 'item.name', 'item.weight')
        ->join('users', 'purchase_item.seller_id', '=', 'users.id')
        ->join('item', 'purchase_item.item_id', '=', 'item.item_id')
        ->where('purchase_item.buyer_id', $id)->get();

        $usr_buyer = User::select('location.city_id')
        ->join('location', 'users.id', '=',  'location.user_id', 'LEFT OUTER')
        ->join('postal', 'postal.postal_code', '=', 'location.postal_code')
        ->join('cityloc', 'cityloc.city_id', '=', 'location.city_id')
        ->join('provinceloc', 'provinceloc.province_id', '=', 'location.province_id')
        ->where('users.id', $id)->distinct()->get();

        $cartSeller = Purchase_item::select('purchase_item.seller_id', 'users.name AS seller', 'location.city_id', 'location.province_id', 'cityloc.city_name', 'provinceloc.province_name')
        ->join('users', 'purchase_item.seller_id', '=', 'users.id')
        ->join('location', 'users.id', '=',  'location.user_id', 'LEFT OUTER')
        ->join('cityloc', 'cityloc.city_id', '=', 'location.city_id')
        ->join('provinceloc', 'provinceloc.province_id', '=', 'location.province_id')
        ->join('item', 'purchase_item.item_id', '=', 'item.item_id')
        ->where('purchase_item.buyer_id', $id)->distinct()->get();

        foreach($cartSeller as $n) {
            echo "
            <form action='".route('payStore')."' method='post'>
            <div>
                <div class='card-body shadow'>
                    <p class='card-text'>Pelapak: ". $n['seller'] ."</p>
                    <p class='card-text'>". $n['city_name'] ."</p>
                    <p class='card-text'>". $n['province_name'] ."</p>
                    ";

                    $total_price = 0;
                    $total_weight = 0;
                    foreach($cartList as $j) {
                        if($n['seller'] == $j['seller']) {
                            echo "
                            <div>
                                <div class='card-body shadow'>
                                    <button class='fa fa-trash' onclick='deleteItem(". $j['item_id'] .")'></button>
                                    <p class='card-text'>Nama: ". $j['name'] ."</p>
                                    <p class='card-text'>Jumlah: ". $j['amount'] ."</p>
                                    <p class='card-text'>Harga per item:
                                        Rp". number_format($j['selling_price'],2,',','.') ."
                                    </p>
                                    <p class='card-text'>". number_format(($j['selling_price']*$j['amount']),2,',','.') ."</p>
                                    
                                </div>
                            </div>
                            ";
                            $total_price+=$j['selling_price']*$j['amount'];
                            $total_weight+=$j['weight']*$j['amount'];
                        }
                    }
                    echo "Total harga ".number_format(($total_price),2,',','.');
                    echo csrf_field() . "
                    <input type='hidden' name='seller_id' value='".$n['seller_id']."'>
                    <input type='hidden' name='total_price' value='$total_price'>
                    <input type='hidden' name='shipping_price' value='$total_price'>
                    <input type='text' name='note' value=''>
                    <input type='submit' value='Bayar'>
                    <div id='ongkir_". $n['seller'] ."'></div>
                </div>
            </div>
            </form>
            ";


            echo "
            <script>
                var origin = ".$n['city_id'].";
                var dst = ".$usr_buyer[0]['city_id'].";
                //var courier = $('#kurir').val();
                var weight = ".$total_weight.";
    
                $.ajax({
                    type: 'GET',
                    url: '". route('checkshipping') ."',
                    data: {
                        'dst': dst,
                        'courier': 'jne',
                        'origin': origin,
                        'weight': weight,
                    },
                    beforeSend: function () {
                        $('#ongkir_". $n['seller'] ."').html('loading...');
                    },
                    success: function (data) {
                        $('#ongkir_". $n['seller'] ."').html(data);
                    },
                });  
            </script>
            ";
        }
        
    }

    public function payStore(Request $request) {

        $id = Auth::user()->id;

        $this->validate($request, [
            'seller_id' => ['required'],
            'total_price' => ['required'],
            'shipping_price' => ['required'],
        ]);

        $purchase_id = Purchase::select('purchase_id')
                            ->where('seller_id', $request['seller_id'])
                            ->where('buyer_id', $id)
                            ->whereNull('time')->first();
                  
        Purchase::where('purchase_id', $purchase_id['purchase_id'])
                    ->update([
                        'total_price' => $request['total_price'],
                        'shipping_price' => $request['shipping_price'],
                        'note' => $request['note'],
                        'time' => DB::raw('NOW()'),
                    ]);
        
        Transaction::create([
            'purchase_id' => $purchase_id['purchase_id'],
            'pay' => 'N',
        ]);

    }

    public function payConfirm() {
        $id = Auth::user()->id;

        $cartSeller = Purchase_item::select('purchase_item.seller_id', 'users.name AS seller', 'location.city_id', 'location.province_id', 'cityloc.city_name', 'provinceloc.province_name')
        ->join('users', 'purchase_item.seller_id', '=', 'users.id')
        ->join('location', 'users.id', '=',  'location.user_id', 'LEFT OUTER')
        ->join('cityloc', 'cityloc.city_id', '=', 'location.city_id')
        ->join('provinceloc', 'provinceloc.province_id', '=', 'location.province_id')
        ->join('item', 'purchase_item.item_id', '=', 'item.item_id')
        ->where('purchase_item.buyer_id', $id)->distinct()->get();

        $invoice = Transaction::select('purchase.purchase_id', 'purchase.total_price', 'purchase.shipping_price', 'purchase.note')
                            ->join('purchase', 'purchase.purchase_id', '=', 'transaction.purchase_id')
                            ->where('transaction.pay', 'N')
                            ->where('purchase.buyer_id', $id)
                            ->get();

        return view('payConfirm', [
            'invoice' => $invoice,
        ]);
        //$purchase_item = \App\Purchase_item::with(['purchase', 'item', 'user'])->get();

    }

}
