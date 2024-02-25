<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $date = $request->input("reservation_date");
        $time = $request->input("reservation_time");
        $date_time = $date . " " . $time;
        $user = Auth::user();
        $user_id = $user['id'];
        
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
