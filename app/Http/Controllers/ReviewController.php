<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:50',
            'content' => 'required'
        ]);

        $user = Auth::user();
        $subscribed = $user->subscribed('premium_plan');
        if (!$subscribed) {
            return back()->with('flash_message', 'レビューを書くには有料会員登録が必要です。');
        }

        $review = new Review();
        $review->title = $request->input('title');
        $review->content = $request->input('content');
        $review->shop_id = $request->input('shop_id');
        $review->user_id = Auth::user()->id;
        $review->score = $request->input('score');
        $review->save();

        return back();
    }
}
