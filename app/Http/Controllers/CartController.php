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

        $cartSeller = Purchase_item::select('purchase.seller_id', 'purchase.buyer_id', 'users.name AS seller', 'purchase_item.purchase_id')
        ->join('users', 'purchase_item.seller_id', '=', 'users.id')
        ->join('purchase', 'purchase.purchase_id', '=', 'purchase_item.purchase_id')
        ->join('item', 'purchase_item.item_id', '=', 'item.item_id')
        ->where('purchase.confirm_id', 1)
        ->where('purchase_item.buyer_id', $id)->distinct()->get();

        foreach($cartSeller as $n) {
            echo "
            <div>
                <div class='card mb-3'>
                    <div class='card-header'>
                    <h6 class='tap mt-1' onclick='getProfilePelapak(". $n['seller_id'] .")'>
                    <i class='fa fa-university'></i>
                    ". $n['seller'] ."</h6>
                    </div>
                    <hr>
                    ";

                    $total_price = 0;
                    foreach($cartList as $j) {
                        if($n['seller'] == $j['seller']) {
                            echo "
                            <div style='margin-left: 33px; margin-right: 5px'>
                                <div class='row'>
                                    <div class='col-md-12 row'>
                                        <div class='col col-md-6 text-left'>
                                        <p class='tap' onclick='getItemDetail(". $j['item_id'] .")'>
                                        ". $j['name'] ."
                                        </p>
                                        </div>
                                        <div class='col col-md-2 text-center'>
                                        <p>
                                        ". $j['amount'] ."
                                        </p>
                                        </div>
                                        <div class='col col-md-4 text-right'>
                                        <p>
                                            Rp". number_format($j['selling_price'],2,',','.') ."<br>
                                            <i class='fa fa-trash red' onclick='deleteItem(". $j['item_id'] .")'></i>
                                        </p>  
                                        </div> 
                                    </div>
                                </div>
                            </div>
                            <hr>
                            ";
                            $total_price+=$j['selling_price']*$j['amount'];
                        }
                    }
                    echo "
                    <div class='card-footer'>
                        <div class='row' style='margin: 0'>
                            <div class='col text-left'>
                                <h6 class='mt-1'>Subtotal</h6>
                            </div>
                            <div class='col text-right'>
                                <h6>Rp".number_format(($total_price),2,',','.')."</h6>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col text-right' style='margin-right: 14px'>
                                <button class='btn btn-sm btn-login' onclick='getCheckout(". $n['purchase_id'] .",". $n['seller_id'] .",". $n['buyer_id'] .")'>Bayar</button>
                            </div>
                        </div>
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
