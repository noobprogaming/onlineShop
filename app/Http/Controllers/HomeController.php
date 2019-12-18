<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Request as RequestInput;
use Illuminate\Support\Facades\Input;
use Auth;

use App\Item;
use App\Category;

class HomeController extends Controller
{

    public function index() {
        $category = Category::get();

        return view('home', [
            'category' => $category,
        ]);
    } 

    public function getItem(Request $request) {
        
        switch($request->sort) {
            case "";
                $sort = "name";
                $by = "ASC";
                break;
            case "priceLowHigh":
                $sort = "selling_price";
                $by = "ASC";
                break;
            case "priceHighLow":
                $sort = "selling_price";
                $by = "DESC";
                break;
        }

        $item = Item::select('item.item_id', 'item.name', 'item.selling_price', 'item.id', 'city.city_name')
        ->join('users', 'users.id', '=', 'item.id')
        ->join('location', 'location.user_id', '=', 'users.id')
        ->join('city', 'city.city_id', '=', 'location.city_id')
        ->where('item.name', 'LIKE', '%'.$request->nameItem.'%')
        ->whereNotIn('item.id', [Auth::user()->id])
        ->orderBy('item.'.$sort, $by)->get();

        foreach($item as $n) {
            echo "
                <div class='col-lg-4 col-md-6'>
                    <div class='single-product tap' onclick='getItemDetail(".$n['item_id'].")'>
                        <div class='product-img'>
                        <img class='img-fluid w-100' src='".asset('data_file/'.$n['item_id'].'_a')."' alt='' />
                        <div class='p_icon'>
                            <a href='#'>
                            <i class='fa fa-eye'></i>
                            </a>
                            <a href='#'>
                            <i class='fa fa-heart'></i>
                            </a>
                            <a href='#'>
                            <i class='fa fa-shopping-cart'></i>
                            </a>
                        </div>
                        </div>
                        <div class='product-btm'>
                        <a class='d-block'>
                            <h4>".$n['name']."</h4>
                        </a>
                        <div class='mt-3'>
                            <span class='mr-4'>Rp".number_format($n['selling_price'])."</span>
                            <del>".$n['city_name']."</del>
                        </div>
                        </div>
                    </div>
                    
                    <button class='btn btn-block btn-primary' onclick='addItem(".$n['id'].", ".$n['item_id'].")'>Beli</button>
                        
                </div>
            ";
        }

        echo "
        <input type='hidden' id='number' value='1'>
        ";

        // echo "
        //     <div class='pagination'>
        //         ".$item->links()."
        //     </div>
        // ";
        
    }

    public function getListItem(Request $request) {

        $item = Item::select('item.name')
        ->distinct()
        ->where('item.name', 'LIKE', '%'.$request->nameItem.'%')
        ->get();

        foreach($item as $n) {
            echo "
                <option>".$n['name']."</option>
            ";
        }

    }

    public function getItemCategory(Request $request) {

        switch($request->sort) {
            case "";
                $sort = "name";
                $by = "ASC";
                break;
            case "priceLowHigh":
                $sort = "selling_price";
                $by = "ASC";
                break;
            case "priceHighLow":
                $sort = "selling_price";
                $by = "DESC";
                break;
        }

        $category = Category::get();

        $item = Item::select('item.item_id', 'item.name', 'item.selling_price', 'item.id', 'city.city_name')
        ->join('users', 'users.id', '=', 'item.id')
        ->join('category', 'category.category_id', '=', 'item.category_id')
        ->join('location', 'location.user_id', '=', 'users.id')
        ->join('city', 'city.city_id', '=', 'location.city_id')
        ->where('item.name', 'LIKE', "%$request->explanation%")
        ->orWhere('category.explanation', 'LIKE', "%$request->explanation%")
        ->whereNotIn('item.id', [Auth::user()->id])
        ->orderBy('item.'.$sort, $by)->get();

        foreach($item as $n) {
            echo "
                <div class='col-md-3 my-3'>
                    <div class='card'>
                        <div class='tap' onclick='getItemDetail(".$n['item_id'].")'>
                            <img class='card-img-top w-100' src='".asset('data_file/'.$n['item_id'].'_a')."'>
                            <div class='card-body'>
                                <h4 class='card-title'>".$n['name']."</h4>
                                <p class='card-text bold'>Rp".number_format($n['selling_price'])."</p>
                                <h6>".$n['city_name']."</h6>
                            </div>
                        </div>
                        <div class='card-footer'>
                            <button class='btn btn-block btn-primary' onclick='addItem(".$n['id'].", ".$n['item_id'].")'>Beli</button>
                        </div>
                    </div>
                </div>
            ";
        }

        echo "
        <input type='hidden' id='number' value='1'>
        ";
    }
    
}
