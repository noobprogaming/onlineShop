<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Request as RequestInput;
use Illuminate\Support\Facades\Input;
use Auth;
use DB;

use App\Purchase;
use App\Confirm;

class AdminController extends Controller
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

        if(isset(Auth::user()->email)){
            if(Auth::user()->email !== "admin@admin") {
                return redirect('home');
            }
        } else {
            return redirect('home');
        }

        $usr = Purchase::select('purchase.seller_id', 'purchase.buyer_id', 'users.name', 'purchase.purchase_id', 'purchase.total_price', 'purchase.shipping_price', 'purchase.resi', 'confirm.confirm_id')
        ->join('users', 'users.id', '=', 'purchase.seller_id')
        ->join('confirm', 'confirm.confirm_id', '=', 'purchase.confirm_id')
        ->get();

        $confirm = Confirm::all();

        return view('admin', [
            'usr' => $usr,
            'confirm' => $confirm
        ]);

    }


    public function updateAdminTransaction(Request $request) {

        Purchase::where('purchase_id', $request['purchase_id'])
                    ->update([
                        'confirm_id' => $request['confirm_id'],
                    ]);

        return redirect()->back();
        
    }

}
