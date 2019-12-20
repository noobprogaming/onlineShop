<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Request as RequestInput;
use Illuminate\Support\Facades\Input;
use Auth;
use Hash;
use DB;

use App\User;
use App\Item;
use App\Location;
use App\Rating;

class ProfileController extends Controller
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

    public function index($id) {

        $usr = User::select('users.id', 'users.name', 'users.email', 'users.phone_number', 'location.address', 'postal.district', 'location.postal_code',  'location.city_id', 'location.province_id', 'city.city_name', 'province.province_name')
        ->join('location', 'users.id', '=',  'location.user_id', 'LEFT OUTER')
        ->join('postal', 'postal.postal_code', '=', 'location.postal_code', 'LEFT OUTER')
        ->join('city', 'city.city_id', '=', 'location.city_id', 'LEFT OUTER')
        ->join('province', 'province.province_id', '=', 'location.province_id', 'LEFT OUTER')
        ->where('users.id', $id)->get();

        $ratingLapak = Rating::select(DB::raw('avg(rating.rating) AS ratingLapak'))
        ->join('item', 'item.item_id', '=', 'rating.item_id')
        ->where('item.id', $id)    
        ->get();

        $item = Item::where('id', $id)->paginate(12);

        return view('profile', [
            'usr' => $usr,
            'item' => $item,
            'ratingLapak' => $ratingLapak,
        ]);
    }

    public function profileUpdate($id) {

        $usr = User::select('users.id', 'users.name', 'users.email', 'users.phone_number', 'location.address', 'postal.district', 'location.postal_code',  'location.city_id', 'location.province_id', 'city.city_name', 'province.province_name')
        ->join('location', 'users.id', '=',  'location.user_id', 'LEFT OUTER')
        ->join('postal', 'postal.postal_code', '=', 'location.postal_code', 'LEFT OUTER')
        ->join('city', 'city.city_id', '=', 'location.city_id', 'LEFT OUTER')
        ->join('province', 'province.province_id', '=', 'location.province_id', 'LEFT OUTER')
        ->where('users.id', $id)->get();

        return view('profileUpdate', [
            'usr' => $usr,
        ]);

        //rating: SELECT DISTINCT AVG(rating.rating) FROM rating INNER JOIN item ON item.id = rating.id WHERE item.id = 2

    }

    public function setProfileUpdate(Request $request, $id) {

        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255'],
            'phone_number' => ['required'],
        ]);

        if (!empty($request['password'])) {
            User::where('id', $id)
            ->update([
                'name' => $request['name'],
                'email' => $request['email'],
                'phone_number' => $request['phone_number'],
                'password' => Hash::make($request['password']),
            ]);
        } else {
            User::where('id', $id)
            ->update([
                'name' => $request['name'],
                'email' => $request['email'],
                'phone_number' => $request['phone_number'],
            ]);
        }        

        if(!empty($request['photo_profile'])) {
            $photo_profile = $request->file('photo_profile');
            $photo_profile->move('data_file', $id. '_profile');
        }

        return redirect()->back();
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
