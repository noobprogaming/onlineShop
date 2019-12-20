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

        $usr_buyer = Purchase::select('users.name', 'purchase.purchase_id', 'purchase.total_price', 'purchase.shipping_price', 'purchase.resi', 'confirm.confirm_id')
        ->join('users', 'users.id', '=', 'purchase.seller_id')
        ->join('confirm', 'confirm.confirm_id', '=', 'purchase.confirm_id')
        ->where('purchase.buyer_id', $id)->get();
        $usr_seller = Purchase::select('users.name', 'purchase.purchase_id', 'purchase.total_price', 'purchase.shipping_price', 'purchase.resi', 'confirm.confirm_id')
        ->join('users', 'users.id', '=', 'purchase.seller_id')
        ->join('confirm', 'confirm.confirm_id', '=', 'purchase.confirm_id')
        ->where('purchase.seller_id', $id)->get();

        return view('transaction', [
            'usr_buyer' => $usr_buyer,
            'usr_seller' => $usr_seller,
        ]);

    }


}
