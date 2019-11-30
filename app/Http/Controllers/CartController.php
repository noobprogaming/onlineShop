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

    public function cartCount() {

        $id = Auth::user()->id;
        echo $cartCount = Purchase_item::where('purchase_item.buyer_id', $id)->count();
        
    }

    public function cartList() {
        $id = Auth::user()->id;

        $cartList = Purchase_item::select('users.name AS seller', 'purchase_item.amount', 'purchase_item.selling_price', 'item.item_id', 'item.name')
        ->join('users', 'purchase_item.seller_id', '=', 'users.id')
        ->join('item', 'purchase_item.item_id', '=', 'item.item_id')
        ->where('purchase_item.buyer_id', $id)->get();

        $cartSeller = Purchase_item::select('users.name AS seller')
        ->join('users', 'purchase_item.seller_id', '=', 'users.id')
        ->join('item', 'purchase_item.item_id', '=', 'item.item_id')
        ->where('purchase_item.buyer_id', $id)->distinct()->get();

        foreach($cartSeller as $n) {
            echo "
            <div>
                <div class='card-body shadow'>
                    <p class='card-text'>Pelapak: ". $n['seller'] ."</p>
                    ";

                    $total_price = 0;
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
                        }
                    }
                    echo "Total harga ".number_format(($total_price),2,',','.');
                    echo "
                </div>
            </div>
            ";
        }
        
    }

    public function storeCart(Request $request) {
        $id = Auth::user()->id;

        $this->validate($request, [
            'seller_id' => ['required'],
            'item_id' => ['required'],
            'amount' => ['required'],
        ]);

        $purchase_count = Purchase::select('seller_id', 'buyer_id')
                        ->where('seller_id', $request['seller_id'])
                        ->where('buyer_id', $id)
                        ->whereNull('time')
                        ->count();
        
        if($purchase_count == 0) {
            Purchase::create([
                'seller_id' => $request['seller_id'],
                'buyer_id' => $id,
            ]);
        }

        $purchase_id = Purchase::select('purchase_id')
                        ->where('seller_id', $request['seller_id'])
                        ->where('buyer_id', $id)
                        ->whereNull('time')
                        ->orderBy('purchase_id', 'DESC')
                        ->first();
        $purchase_detail = Item::select('purchasing_price', 'selling_price', 'id')
                        ->where('item.item_id', $request['item_id'])
                        ->first();

        $purchaseItem_count = Purchase_item::select('item_id')
                            ->where('buyer_id', $id)
                            ->where('item_id', $request['item_id'])
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
