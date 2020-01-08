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

    public function checkout($purchase_id, $seller_id, $buyer_id) {

        $id = Auth::user()->id;
        $str_id = strval($id);

        if($str_id == $seller_id || $str_id == $buyer_id || Auth::user()->email == "admin@admin") {

            $status = Purchase::select('shipping_price', 'note', 'confirm_id', 'resi')->where('purchase_id', $purchase_id)->first();

            $usr_buyer = User::select('users.name', 'users.phone_number', 'location.address', 'postal.district', 'location.postal_code', 'city.city_id', 'city.city_name', 'province.province_name')
            ->distinct()
            ->join('location', 'users.id', '=',  'location.user_id', 'LEFT OUTER')
            ->join('postal', 'postal.postal_code', '=', 'location.postal_code')
            ->join('city', 'city.city_id', '=', 'location.city_id')
            ->join('province', 'province.province_id', '=', 'location.province_id')
            ->where('users.id', $buyer_id)
            ->get();
    
            if ($usr_buyer->count() == 0) {
                return redirect()->route('profileUpdate', $buyer_id)->with('status', 'Lengkapi profil!'); // return ke profil, tambah alamat
            }
    
            $cartList = Purchase_item::select('users.name AS seller', 'purchase_item.amount', 'purchase_item.selling_price', 'item.item_id', 'item.name', 'item.weight')
            ->join('users', 'purchase_item.seller_id', '=', 'users.id')
            ->join('item', 'purchase_item.item_id', '=', 'item.item_id')
            ->where('purchase_item.buyer_id', $buyer_id)->get();
    
            $cartSeller = Purchase_item::select('purchase_item.seller_id', 'users.name AS seller', 'location.city_id', 'location.province_id', 'city.city_name', 'province.province_name')
            ->join('users', 'purchase_item.seller_id', '=', 'users.id')
            ->join('location', 'users.id', '=',  'location.user_id', 'LEFT OUTER')
            ->join('city', 'city.city_id', '=', 'location.city_id')
            ->join('province', 'province.province_id', '=', 'location.province_id')
            ->join('item', 'purchase_item.item_id', '=', 'item.item_id')
            ->where('purchase_item.buyer_id', $buyer_id)
            ->where('purchase_item.purchase_id', $purchase_id)
            ->distinct()->get();
    
            return view('checkout', [
                'status' => $status,
                'usr_buyer' => $usr_buyer,
                'cartList' => $cartList,
                'cartSeller' => $cartSeller,
            ]);
    
        } else {
            return redirect()->route('home');
        }

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
                            ->where('confirm_id', 1)->first();
                  
        Purchase::where('purchase_id', $purchase_id['purchase_id'])
                    ->update([
                        'total_price' => $request['total_price'],
                        'shipping_price' => $request['shipping_price'],
                        'note' => $request['note'],
                        'confirm_id' => 1,
                        'time' => DB::raw('NOW()'),
                    ]);

        return redirect()->back();
    }

    public function storeTransaction(Request $request) {

        $id = Auth::user()->id;

        $this->validate($request, [
            'file_transaction' => ['required'],
        ]);

        $file_trx = $request->file('file_transaction');
        $file_trx->move('data_file', $request['purchase_id']. '_trx');
                  
        Purchase::where('purchase_id', $request['purchase_id'])
                    ->update([
                        'confirm_id' => 2,
                    ]);       

        return redirect()->back();
        
    }

    public function updateTransaction(Request $request) {

        $id = Auth::user()->id;

        $this->validate($request, [
            'resi' => ['required'],
        ]);

        Purchase::where('purchase_id', $request['purchase_id'])
                    ->update([
                        'resi' => $request['resi'],
                        'confirm_id' => 4,
                    ]);

        return redirect()->back();
        
    }

    public function confirmTransaction(Request $request) {

        $id = Auth::user()->id;

        Purchase::where('purchase_id', $request['purchase_id'])
                    ->update([
                        'confirm_id' => 6,
                    ]);

        return redirect()->back();
        
    }

    public function detailTransaction($purchase_id) {
        $id = Auth::user()->id;

        $invoice = Purchase::select('users.name AS seller', 'purchase.purchase_id', 'purchase.total_price', 'purchase.shipping_price', 'purchase.note')
                            ->join('users', 'users.id', '=', 'purchase.seller_id')
                            ->where('purchase.confirm_id', '1')
                            ->where('purchase.purchase_id', $purchase_id)
                            ->first();

        if (!empty(json_decode($invoice, true))) {
            $price = $invoice['total_price'] + $invoice['shipping_price'];
            if(!empty($invoice['note'])) {
                $note = $invoice['note'];
            } else {
                $note = " - ";
            }
            echo "
            <div>
                <div class='row'>
                    <div class='col text-left'>
                    Nomor transaksi
                    </div>
                    <div class='col text-right'>
                    #". $invoice['purchase_id'] ."
                    </div>
                </div>
                <hr>
                <div class='row'>
                    <div class='col text-left'>
                        <h5>Pelapak</h5>
                        </div>
                        <div class='col text-right'>
                        <h5>". $invoice['seller'] ."</h5>
                        </div>
                    </div>
                </div>
                <hr>
                <div class='mx-3'>
                    <div class='row'>
                        <div class='col text-left'>
                        Catatan
                        </div>
                        <div class='col text-right'>
                        ". $note ."
                        </div>
                    </div>
                </div>
                <hr>
                <div class='row'>
                    <div class='col text-left'>
                    Subtotal
                    </div>
                    <div class='col text-right'>
                    Rp". number_format($invoice['total_price']) ."
                    </div>
                </div>
                <div class='row'>
                    <div class='col text-left'>
                    Biaya Pengiriman
                    </div>
                    <div class='col text-right'>
                    Rp". number_format($invoice['shipping_price']) ."
                    </div>
                </div>
                <div class='row bold mt-2'>
                    <div class='col text-left'>
                    <h5>Total Harga</h5>
                    </div>
                    <div class='col text-right'>
                    <h5>Rp". number_format($price) ."</h5>
                    </div>
                </div>
                <hr>
                <div class='row mt-2'>
                    <div class='col text-left'>
                    Metode Pembayaran
                    </div>
                    <div class='col text-right'>
                    <object data='". asset('img/muamalat_logo.svg') ."' type='image/svg+xml'></object>
                    </div>
                </div>
                <div class='row my-2'>
                    <div class='col text-left'><br>
                    Transfer ke
                    </div>
                    <div class='col text-right'>
                    PT. BAKUL INDONESIA<br> 
                    538 000 4149 <br>
                    BANK MUAMALAT INDONESIA<br>
                    </div>
                </div>
                <div class='row'>
                    <div class='col text-left'>
                    <h5>Nominal transfer </h5>
                    </div>
                    <div class='col text-right'>
                    <h5>Rp". number_format($price) ."</h5>
                    </div>
                </div>
                <hr>
            </div>
            ";
        } else {
            echo "Transaksi sudah dibayar!";
        }
    }

}
