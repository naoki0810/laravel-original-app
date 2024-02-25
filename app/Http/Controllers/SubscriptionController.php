<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SubscribeRequest;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Subscription;
use Stripe\Product;

class SubscriptionController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        $intent = $user->createSetupIntent();

        return view('subscription.create', [
            'intent' => $intent
        ]);
    }

    public function store(Request $request)
    {
        $user          = $request->user();
        $paymentMethod = $request->get('stripeToken');

        $newSubscription = $user->newSubscription('premium_plan', 'price_1OgRojETL2omS9pac2U92WRv');
        $newSubscription->create($paymentMethod);

        return redirect()->route('mypage')->with('flash_message', '有料プランへの登録が完了しました。');
    }

    public function edit()
    {
        $user = Auth::user();
        $intent = $user->createSetupIntent();

        return view('subscription.edit', [
            'intent' => $intent
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $paymentMethod = $request->get('stripeToken');

        $user->updateDefaultPaymentMethod($paymentMethod);

        return redirect()->route('mypage')->with('flash_message', 'お支払い方法を変更しました。');
    }

    public function cancel()
    {
        return view('subscription.cancel');
    }

    public function destroy(Request $request)
    {
        $user = $request->user();

        // サブスクリプションキャンセル
        $user->subscription('premium_plan')->cancelNow();

        return redirect()->route('mypage')->with('flash_message', '有料プランを解約しました。');
    }
}
