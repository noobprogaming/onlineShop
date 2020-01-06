<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Request as RequestInput;
use Illuminate\Support\Facades\Input;
use Auth;
use DB;

use App\Item;
use App\Location;
use App\Rating;

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

        $usr_seller = Item::select('item.id', 'item.item_id', 'item.name', 'item.description', 'item.stock', 'item.selling_price', 'item.weight', 'category.explanation', 'item.id AS seller_id', 'users.name AS seller', 'location.city_id', 'location.province_id', 'city.city_name', 'province.province_name')
        ->join('users', 'item.id', '=', 'users.id')
        ->join('category', 'category.category_id', '=', 'item.category_id')
        ->join('location', 'users.id', '=',  'location.user_id', 'LEFT OUTER')
        ->join('city', 'city.city_id', '=', 'location.city_id')
        ->join('province', 'province.province_id', '=', 'location.province_id')
        ->where('item.item_id', $item_id)->get();

        $rating = Item::select('users.id', 'users.name', 'rating.rating', 'rating.review', 'rating.time')
        ->join('rating', 'item.item_id', '=', 'rating.item_id', 'LEFT OUTER')
        ->join('users', 'users.id', '=', 'rating.id')
        ->where('item.item_id', $item_id)->get();

        $rating_avg = Item::selectRaw('AVG(rating.rating)')
        ->join('rating', 'item.item_id', '=', 'rating.item_id', 'LEFT OUTER')
        ->join('users', 'users.id', '=', 'rating.id')
        ->where('item.item_id', $item_id)->get();

        $rating_count = $rating->count();

        $ratingLapak = Rating::select(DB::raw('avg(rating.rating) AS ratingLapak'))
        ->join('item', 'item.item_id', '=', 'rating.item_id')
        ->where('item.id', $usr_seller[0]['id'])    
        ->get();

        return view('itemDetail', [
            'usr_buyer' => $usr_buyer,
            'usr_seller' => $usr_seller,
            'rating' => $rating,
            'rating_avg' => $rating_avg,
            'rating_count' => $rating_count,
            'ratingLapak' => $ratingLapak,
        ]);
    }

}
