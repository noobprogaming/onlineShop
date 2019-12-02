<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Request as RequestInput;
use Illuminate\Support\Facades\Input;
use Auth;
use File;

use App\Item;
use App\Purchase_item;
use App\Purchase;
use App\Category;
use App\Rating;

class ItemController extends Controller
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

    public function createItem() {  
        $category = Category::all();

        return view('createItem', ['category' => $category]);
    }

    public function updateItem($item_id) {   
        
        $category = Category::all();

        $usr = Item::select('item.id', 'item.item_id', 'item.name', 'item.description', 'item.stock', 'item.purchasing_price', 'item.selling_price', 'item.weight', 'item.category_id', 'category.explanation',)
        ->join('category', 'category.category_id', '=', 'item.category_id')
        ->where('item.item_id', $item_id)
        ->get();

        return view('updateItem', [
            'usr' => $usr,
            'category' => $category,
        ]);
    }

    public function deleteItem($id, $item_id) {   

        //authentikasi yang bisa hapus cuma pemilik barang
        if(isset(Auth::user()->id)){
            if(Auth::user()->id != $id) {
                return redirect('home');
            }
        } else {
            return redirect('home');
        }

        Item::where('item_id', $item_id)->delete();

        File::delete('data_file/'. $item_id. '_a');
        File::delete('data_file/'. $item_id. '_b');
        
        return redirect('home');
    }

    public function setUpdateItem(Request $request) {   

        $id = Auth::user()->id;

        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'stock' => ['required'],
            'purchasing_price' => ['required'],
            'selling_price' => ['required'],
            'weight' => ['required'],
            'category_id' => ['required'],
            // 'file_a' => ['required'],
            // 'file_b' => ['required'],
        ]);

        Item::where('item_id', $request['item_id'])
        ->update([
            'name' => $request['name'],
            'description' => $request['description'],
            'stock' => $request['stock'],
            'purchasing_price' => $request['purchasing_price'],
            'selling_price' => $request['selling_price'],
            'weight' => $request['weight'],
            'category_id' => $request['category_id'],
            // 'id' => $id,
        ]);

        $file_a = $request->file('file_a');
        $file_a->move('data_file', $request['item_id']. '_a');

        $file_b = $request->file('file_b');
        $file_b->move('data_file', $request['item_id']. '_b');

        return redirect()->back();
    }

    public function setCreateItem(Request $request) {
        $id = Auth::user()->id;

        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'stock' => ['required'],
            'purchasing_price' => ['required'],
            'selling_price' => ['required'],
            'weight' => ['required'],
            'category_id' => ['required'],
            'file_a' => ['required'],
            'file_b' => ['required'],
        ]);

        Item::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'stock' => $request['stock'],
            'purchasing_price' => $request['purchasing_price'],
            'selling_price' => $request['selling_price'],
            'weight' => $request['weight'],
            'category_id' => $request['category_id'],
            'id' => $id,
        ]);

        $item_id = Item::select('item_id')->where('id', $id)->orderBy('item_id', 'DESC')->first();

        $file_a = $request->file('file_a');
        $file_a->move('data_file', $item_id['item_id']. '_a');

        $file_b = $request->file('file_b');
        $file_b->move('data_file', $item_id['item_id']. '_b');

        //redirect error
        return redirect()->route('itemDetail', ['item_id' => $item_id['item_id']]);
    }
}
