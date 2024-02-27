@extends('layouts.app')

@section('content')
    {{-- モーダルウィンドウ --}}
    <div class="modal fade" id="cancelReservationModal" tabindex="-1" aria-labelledby="cancelReservationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="cancelReservationModalLabel">予約をキャンセルしますか？</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
                </div>

                <div class="modal-footer">
                    <form role="form" class="form-inline" action="" method="post" name="cancelReservationForm">
                        @csrf
                        @method('delete')
                        <input type="hidden" id="userid" name="userid" value="">
                        <button type="submit" class="btn btn-warning shadow-sm nagoyameshi-btn-danger">キャンセルする</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container nagoyameshi-container pb-5">
        <div class="row justify-content-center pt-4">
            <div class="col-xxl-6 col-xl-7 col-lg-8 col-md-10">
            
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{ route('mypage') }}">マイページ</a></li>
                      <li class="breadcrumb-item active" aria-current="page">予約一覧</li>
                    </ol>
                  </nav>

                <h1 class="mb-3 text-center">予約一覧</h1>

                @if (session('flash_message'))
                    <div class="alert alert-info" role="alert">
                        <p class="mb-0">{{ session('flash_message') }}</p>
                    </div>
                @endif

                @if (session('error_message'))
                    <div class="alert alert-danger" role="alert">
                        <p class="mb-0">{{ session('error_message') }}</p>
                    </div>
                @endif

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">店舗名</th>
                            <th scope="col">予約日時</th>
                            <th scope="col">人数</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservations as $reservation)
                            <tr>
                                <td>
                                    <a class="reservation-shop-name" href="{{ route('shops.show', $reservation->shop) }}">
                                        {{ $reservation->shop->name }}
                                    </a>
                                </td>
                                <td>{{ date('Y年n月j日 G時i分', strtotime($reservation->reserved_datetime)) }}</td>
                                <td>{{ $reservation->number_of_people }}名</td>
                                <td>
                                    @if ($reservation->reserved_datetime > now())
                                        <a href="#" class="link-secondary" data-bs-toggle="modal"
                                            data-bs-target="#cancelReservationModal"
                                            data-reservation-user-id="{{ $reservation->user_id }}"
                                            data-url="{{ route('reservations.destroy', ['id' => $reservation->id]) }}">キャンセル
                                        </a>
                                     
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            let cancelReservationModal = document.getElementById('cancelReservationModal');

            cancelReservationModal.addEventListener('shown.bs.modal', function(event) {

                let button = event.relatedTarget; //モーダルを呼び出すときに使われたボタンを取得
                let url = button.dataset.url; //urlを取得
                let reservationUserId = button.dataset.reservationUserId; //reservationを取得
                cancelReservationForm.action = url;
                userid.value = reservationUserId;
            });
        }
    </script>
@endsection
