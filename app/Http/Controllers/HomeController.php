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

        $sort = RequestInput::input('sort');
        
        switch($sort) {
            case "";
                $sort = "selling_price";
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

        $usr = Item::orderBy('item.'.$sort, $by)->paginate(12);
        return view('home', [
            'usr' => $usr,
            'category' => $category,
        ]);
    }

    public function find(Request $request) {
        $category = Category::get();

        $usr = Item::when($request->q, function($query) use ($request) {
            $query->where('name', 'LIKE', "%$request->q%")
            ->orWhere('category_id', 'LIKE', "%$request->q%");
        })->paginate();
        return view('home', [
            'usr' => $usr,
            'category' => $category,
        ]);
    }
    
}
