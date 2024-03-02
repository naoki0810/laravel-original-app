<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Datetime;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::all();

        return view('reservations.index', compact('reservations'));
    }

    public function create(Shop $shop)
    {
        return view('reservations.create', compact('shop'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'reservation_date' => 'required|date_format:Y-m-d',
            'reservation_time' => 'required|date_format:H:i',
            'number_of_people' => 'required|numeric|between:1,50'
        ]);

        $shop = Shop::find($request->input('shop_id'));
        $shop_opening_time = $shop->opening_time;
        $shop_closing_time = $shop->closing_time;

        $time1 = new DateTime($shop_opening_time);
        $time2 = new DateTime($shop_closing_time);
        $time3 = new DateTime($request->input("reservation_time"));

        if (!($time1 < $time3 && $time2 > $time3)) {
            return back()->with('flash_message', '営業時間内に指定してください。');
        }

        $date = $request->input("reservation_date");
        $time = $request->input("reservation_time");
        $date_time = $date . " " . $time;
        $user = Auth::user();
        $user_id = $user['id'];

        $today = date("Y-m-d");
        $date_time1 = new DateTime($today);
        $date_time2 = new DateTime($date);

        if ($date_time1 >= $date_time2) {
            return back()->with('flash_message', '明日以降の日付を指定してください。');
        }

        $subscribed = $user->subscribed('premium_plan');
        if (!$subscribed) {
            return back()->with('flash_message', '予約するには有料会員登録が必要です。');
        }

        $reservation = new Reservation();
        $reservation->reserved_datetime = $date_time;
        $reservation->number_of_people = $request->input('number_of_people');
        $reservation->shop_id = $request->input('shop_id');
        $reservation->user_id = $user_id;
        $reservation->save();

        return redirect('/reservations/index')->with('flash_message', '予約が完了しました。');
    }

    public function destroy(Reservation $reservation, Request $request, $id)
    {
        $user_id = $request->get('userid');

        if ($user_id == Auth::user()->id) {
            $reservation->destroy($id);
            return redirect('/reservations/index')->with('flash_message', '予約をキャンセルしました。');
        } else {
            return redirect('/reservations/index')->with('error_message', '不正なアクセスです。');
        }
    }
}
