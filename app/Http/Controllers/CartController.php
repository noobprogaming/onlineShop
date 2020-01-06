<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Request as RequestInput;
use Illuminate\Support\Facades\Input;
use Auth;

use App\Item;
use App\Purchase;
use App\Purchase_item;

class CartController extends Controller
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

    public function cartCount() {
        $id = Auth::user()->id;
        echo $cartCount = Purchase_item::select('purchase.purchase_id')->where('purchase_item.buyer_id', $id)
        ->join('purchase', 'purchase.purchase_id', '=', 'purchase_item.purchase_id')
        ->where('purchase.confirm_id', 1)->count();
    }

    public function cartList() {
        $id = Auth::user()->id;

        $cartList = Purchase_item::select('users.name AS seller', 'purchase_item.amount', 'purchase_item.selling_price', 'item.item_id', 'item.name')
        ->join('users', 'purchase_item.seller_id', '=', 'users.id')
        ->join('purchase', 'purchase.purchase_id', '=', 'purchase_item.purchase_id')
        ->join('item', 'purchase_item.item_id', '=', 'item.item_id')
        ->where('purchase.confirm_id', 1)
        ->where('purchase_item.buyer_id', $id)->get();

        $cartSeller = Purchase_item::select('users.id', 'users.name AS seller', 'purchase_item.purchase_id')
        ->join('users', 'purchase_item.seller_id', '=', 'users.id')
        ->join('purchase', 'purchase.purchase_id', '=', 'purchase_item.purchase_id')
        ->join('item', 'purchase_item.item_id', '=', 'item.item_id')
        ->where('purchase.confirm_id', 1)
        ->where('purchase_item.buyer_id', $id)->distinct()->get();

        foreach($cartSeller as $n) {
            echo "
            <div>
                <div class='card'>
                    <div class='card-header'>
                    <p class='tap bold' onclick='getProfilePelapak(". $n['id'] .")'>
                    <i class='fa fa-university'></i>
                    ". $n['seller'] ." #ID_trx:". $n['purchase_id'] ."</p>
                    </div>
                    <hr>
                    ";

                    $total_price = 0;
                    foreach($cartList as $j) {
                        if($n['seller'] == $j['seller']) {
                            echo "
                            <div class='mx-3'>
                                <div class='row'>
                                    <div class='col-md-11'>
                                        <p class='tap' onclick='getItemDetail(". $j['item_id'] .")'>". $j['name'] ."</p>
                                        <p>
                                            <div class='value-button' id='decrease' onclick='decreaseValue()'
                                            value='Decrease Value'>-</div>
                                            <input id='number' type='number' class=' @error('amount') is-invalid @enderror'
                                                name='amount' value='". $j['amount'] ."' required>
                                            <div class='value-button' id='increase' onclick='increaseValue()'
                                                value='Increase Value'>+</div>
                                        </p>
                                        <p>
                                            Rp". number_format($j['selling_price'],2,',','.') ."
                                        </p>  
                                    </div>
                                    <div class='col-md-1'>
                                        <i class='fa fa-trash lightGrey' onclick='deleteItem(". $j['item_id'] .")'></i>  
                                    </div>
                                </div>
                            </div>
                            <hr>
                            ";
                            $total_price+=$j['selling_price']*$j['amount'];
                        }
                    }
                    echo "
                    <div class='card-footer bold'>
                    Total harga Rp".number_format(($total_price),2,',','.')."
                    <button class='btn btn-sm btn-login' onclick='getCheckout(". $n['purchase_id'] .")'>Bayar</button>
                    </div>
                    ";
                    echo "
                </div>
            </div>
            ";
        }  
    }

    public function storeCart(Request $request) {
        $id = Auth::user()->id;

        // $this->validate($request, [
        //     'seller_id' => ['required'],
        //     'item_id' => ['required'],
        //     'amount' => ['required'],
        // ]);

        $purchase_count = Purchase::select('seller_id', 'buyer_id')
                        ->where('seller_id', $request['seller_id'])
                        ->where('buyer_id', $id)
                        ->where('confirm_id', 1)
                        ->count();
        
        if($purchase_count == 0) {
            Purchase::create([
                'seller_id' => $request['seller_id'],
                'confirm_id' => 1,
                'buyer_id' => $id,
            ]);
        }

        $purchase_id = Purchase::select('purchase_id')
                        ->where('seller_id', $request['seller_id'])
                        ->where('buyer_id', $id)
                        ->where('confirm_id', 1)
                        ->orderBy('purchase_id', 'DESC')
                        ->first();
        $purchase_detail = Item::select('purchasing_price', 'selling_price', 'id')
                        ->where('item.item_id', $request['item_id'])
                        ->first();

        $purchaseItem_count = Purchase_item::select('item_id')
                            ->where('buyer_id', $id)
                            ->where('item_id', $request['item_id'])
                            ->where('purchase_id', $purchase_id['purchase_id'])
                            ->count();
        $purchaseItem_amount = Purchase_item::select('amount')
                            ->where('buyer_id', $id)
                            ->where('item_id', $request['item_id'])
                            ->get();

        if($purchaseItem_count == 0) {
            Purchase_item::create([
                'amount' => $request['amount'],
                'purchasing_price' => $purchase_detail['purchasing_price'],
                'selling_price' => $purchase_detail['selling_price'],
                'purchase_id' => $purchase_id['purchase_id'],
                'item_id' => $request['item_id'],
                'seller_id' => $purchase_detail['id'],
                'buyer_id' => $id,
            ]);
        } else {          
            Purchase_item::where('item_id', $request['item_id'])
                            ->where('buyer_id', $id)
                            ->update([
                                'amount' => ($purchaseItem_amount[0]['amount']+$request['amount']) 
                            ]);
        }
    }

    public function deleteCart($item_id) {
        $id = Auth::user()->id;

        $usr = Purchase_item::where('item_id', $item_id)->where('buyer_id', $id);
        $usr->delete();
    }

}
