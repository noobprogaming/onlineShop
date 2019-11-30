<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Request as RequestInput;
use Illuminate\Support\Facades\Input;
use Auth;

use App\Item;
use App\Location;

class DetailItemController extends Controller
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

    public function itemDetail($item_id) {
        //$purchase_item = \App\Purchase_item::with(['purchase', 'item', 'user'])->get();

        $id = Auth::user()->id;
        
        $usr_buyer = Location::select('city_id')->where('user_id', $id)->get();

        $usr_seller = Item::select('item.id', 'item.item_id', 'item.name', 'item.description', 'item.stock', 'item.selling_price', 'item.weight', 'item.id AS seller_id', 'users.name AS seller', 'location.city_id', 'location.province_id', 'cityloc.city_name', 'provinceloc.province_name')
        ->join('users', 'item.id', '=', 'users.id')
        ->join('location', 'users.id', '=',  'location.user_id', 'LEFT OUTER')
        ->join('cityloc', 'cityloc.city_id', '=', 'location.city_id')
        ->join('provinceloc', 'provinceloc.province_id', '=', 'location.province_id')
        ->where('item.item_id', $item_id)->get();

        $rating = Item::select('rating.rating', 'rating.review', 'rating.time')
        ->join('rating', 'item.item_id', '=', 'rating.item_id', 'LEFT OUTER')
        ->where('item.item_id', $item_id)->get();

        // $ratingLapak = DB::table('rating')
        //                 ->select(DB::raw('avg(rating.rating) AS ratingLapak'))
        //                 ->join('item', 'rating.id', '=', 'item.id')
        //                 ->where('item.item_id', $item_id)
        //                 ->get();

        return view('itemDetail', [
            'usr_buyer' => $usr_buyer,
            'usr_seller' => $usr_seller,
            'rating' => $rating,
        ]);
    }

}
