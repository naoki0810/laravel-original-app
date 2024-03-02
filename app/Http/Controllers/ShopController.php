<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Subscription;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;

        if ($request->category !== null) {
            $shops = Shop::where('category_id', $request->category)->sortable()->paginate(60);
            $total_count = Shop::where('category_id', $request->category)->count();
            $category = Category::find($request->category);
        } elseif ($keyword !== null) {
            $shops = Shop::where('name', 'like', "%{$keyword}%")->sortable()->paginate(60);
            $total_count = $shops->total();
            $category = null;
        } else {
            $shops = Shop::sortable()->paginate(60);
            $total_count = "";
            $category = null;
        }
        $categories = Category::all();


        return view('shops.index', compact('shops', 'category', 'categories', 'total_count', 'keyword'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function show(Shop $shop)
    {
        $reviews = $shop->reviews()->get();

        $user = Auth::user();
        $subscribed = $user->subscribed('premium_plan');

        return view('shops.show', compact('shop', 'reviews', 'subscribed'));
    }
}
