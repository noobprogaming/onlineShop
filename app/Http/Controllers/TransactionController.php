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

class TransactionController extends Controller
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

    public function index() {

        $id = Auth::user()->id;
        $str_id = strval($id);

        $usr_buyer = Purchase::select('purchase.seller_id', 'purchase.buyer_id', 'users.name AS seller', 'purchase.purchase_id', 'purchase.total_price', 'purchase.shipping_price', 'purchase.resi', 'confirm.confirm_id')
        ->join('users', 'users.id', '=', 'purchase.seller_id')
        ->join('confirm', 'confirm.confirm_id', '=', 'purchase.confirm_id')
        ->where('purchase.buyer_id', $id)->get();
        $usr_seller = Purchase::select('purchase.seller_id', 'purchase.buyer_id', 'users.name AS buyer', 'purchase.purchase_id', 'purchase.total_price', 'purchase.shipping_price', 'purchase.resi', 'confirm.confirm_id')
        ->join('users', 'users.id', '=', 'purchase.seller_id')
        ->join('confirm', 'confirm.confirm_id', '=', 'purchase.confirm_id')
        ->where('purchase.seller_id', $id)->get();

        if($str_id == $usr_buyer[0]['seller_id'] || $str_id == $usr_buyer[0]['buyer_id'] || Auth::user()->email == "admin@admin") {

            $status = Purchase::select('shipping_price', 'note', 'confirm_id', 'resi')->where('purchase_id', $usr_buyer[0]['purchase_id'])->first();

            $usr_buyer2 = User::select('users.name', 'users.phone_number', 'location.address', 'postal.district', 'location.postal_code', 'city.city_id', 'city.city_name', 'province.province_name')
            ->distinct()
            ->join('location', 'users.id', '=',  'location.user_id', 'LEFT OUTER')
            ->join('postal', 'postal.postal_code', '=', 'location.postal_code')
            ->join('city', 'city.city_id', '=', 'location.city_id')
            ->join('province', 'province.province_id', '=', 'location.province_id')
            ->where('users.id', $usr_buyer[0]['buyer_id'])
            ->get();

            if ($usr_buyer->count() == 0) {
                return redirect()->route('profileUpdate', $usr_buyer[0]['buyer_id'])->with('status', 'Lengkapi profil!'); // return ke profil, tambah alamat
            }
    
            $cartList = Purchase_item::select('users.name AS seller', 'purchase_item.amount', 'purchase_item.selling_price', 'item.item_id', 'item.name', 'item.weight')
            ->join('users', 'purchase_item.seller_id', '=', 'users.id')
            ->join('item', 'purchase_item.item_id', '=', 'item.item_id')
            ->where('purchase_item.buyer_id', $usr_buyer[0]['buyer_id'])->get();
    
            $cartSeller = Purchase_item::select('purchase_item.seller_id', 'users.name AS seller', 'location.city_id', 'location.province_id', 'city.city_name', 'province.province_name')
            ->join('users', 'purchase_item.seller_id', '=', 'users.id')
            ->join('location', 'users.id', '=',  'location.user_id', 'LEFT OUTER')
            ->join('city', 'city.city_id', '=', 'location.city_id')
            ->join('province', 'province.province_id', '=', 'location.province_id')
            ->join('item', 'purchase_item.item_id', '=', 'item.item_id')
            ->where('purchase_item.buyer_id', $usr_buyer[0]['buyer_id'])
            ->where('purchase_item.purchase_id', $usr_buyer[0]['purchase_id'])
            ->distinct()->get();
    
        }

        return view('transaction', [
            'status' => $status,
            'cartList' => $cartList,
            'cartSeller' => $cartSeller,
            'usr_buyer' => $usr_buyer,
            'usr_buyer2' => $usr_buyer2,
            'usr_seller' => $usr_seller,
        ]);

    }


}
