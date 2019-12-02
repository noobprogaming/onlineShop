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

    public function checkout($purchase_id) {

        $id = Auth::user()->id;

        $usr_buyer = User::select('users.name', 'users.phone_number', 'location.address', 'postal.district', 'location.postal_code', 'city.city_id', 'city.city_name', 'province.province_name')
        ->distinct()
        ->join('location', 'users.id', '=',  'location.user_id', 'LEFT OUTER')
        ->join('postal', 'postal.postal_code', '=', 'location.postal_code')
        ->join('city', 'city.city_id', '=', 'location.city_id')
        ->join('province', 'province.province_id', '=', 'location.province_id')
        ->where('users.id', $id)
        ->get();

        if ($usr_buyer->count() == 0) {
            return redirect()->route('profileUpdate', $id)->with('status', 'Lengkapi profil!'); // return ke profil, tambah alamat
        }

        $cartList = Purchase_item::select('users.name AS seller', 'purchase_item.amount', 'purchase_item.selling_price', 'item.item_id', 'item.name', 'item.weight')
        ->join('users', 'purchase_item.seller_id', '=', 'users.id')
        ->join('item', 'purchase_item.item_id', '=', 'item.item_id')
        ->where('purchase_item.buyer_id', $id)->get();

        $cartSeller = Purchase_item::select('purchase_item.seller_id', 'users.name AS seller', 'location.city_id', 'location.province_id', 'city.city_name', 'province.province_name')
        ->join('users', 'purchase_item.seller_id', '=', 'users.id')
        ->join('location', 'users.id', '=',  'location.user_id', 'LEFT OUTER')
        ->join('city', 'city.city_id', '=', 'location.city_id')
        ->join('province', 'province.province_id', '=', 'location.province_id')
        ->join('item', 'purchase_item.item_id', '=', 'item.item_id')
        ->where('purchase_item.buyer_id', $id)
        ->where('purchase_item.purchase_id', $purchase_id)
        ->distinct()->get();

        return view('checkout', [
            'usr_buyer' => $usr_buyer,
            'cartList' => $cartList,
            'cartSeller' => $cartSeller,
        ]);
    }

    public function payCartList() {

        
    }

    public function storePayment(Request $request) {

        $id = Auth::user()->id;

        // $this->validate($request, [
        //     'seller_id' => ['required'],
        //     'total_price' => ['required'],
        //     'shipping_price' => ['required'],
        // ]);

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

    public function detailTransaction() {
        $id = Auth::user()->id;

        $invoice = Transaction::select('purchase.purchase_id', 'purchase.total_price', 'purchase.shipping_price', 'purchase.note')
                            ->join('purchase', 'purchase.purchase_id', '=', 'transaction.purchase_id')
                            ->where('transaction.pay', 'N')
                            ->where('purchase.buyer_id', $id)
                            ->first();

        echo "
        Invoice no: ". $invoice['purchase_id'] ."<br>
        Price: Rp". $invoice['total_price'] ."<br>
        Shipping: Rp". $invoice['shipping_price'] ."<br>
        Note: ". $invoice['note'] ."<br><br>

        Total Price: Rp". $invoice['total_price'] . $invoice['shipping_price'] ."<br>
        Trf to: Alvin Bintang R.<br> 
            538 0004149 BANK MUAMALAT INDONESIA<br>
        Trf : Rp". $invoice['total_price'] . $invoice['shipping_price'] ."
        ";
    }

}
