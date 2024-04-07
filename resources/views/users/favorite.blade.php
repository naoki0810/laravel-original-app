@extends('layouts.app')

@section('content')
    <div class="container pt-4">
        <div class="row justify-content-center">
            <div class="col-11">
                @if (session('flash_message'))
                    <div class="alert alert-info" role="alert">
                        <p class="mb-0">{{ session('flash_message') }}</p>
                    </div>
                @endif
                <h1 id="name" class="">
                    お気に入り
                    <hr>
                </h1>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="row col-4">
                @foreach ($favorite_shops as $favorite_shop)
                    <div class="col-4 mb-2 ">
                        <div class="">
                            <a href="{{ route('shops.show', $favorite_shop->id) }}" class="w-100">
                                <img src="{{ asset('img/dummy.png') }}" class="img-fluid w-100">
                            </a>
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="container mt-3">
                            <h5 class="w-100 nagoyameshi-favorite-item-text">{{ $favorite_shop->name }}</h5>

                            <a href="{{ route('favorites.destroy', $favorite_shop->id) }}"
                                class="nagoyameshi-favorite-item-delete"
                                onclick="event.preventDefault(); document.getElementById('favorites-destroy-form-{{ $favorite_shop->id }}').submit();">
                                削除
                            </a>
                            <form id="favorites-destroy-form-{{ $favorite_shop->id }}"
                                action="{{ route('favorites.destroy', $favorite_shop->id) }}" method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                    <hr>
                @endforeach
            </div>

            <div class="col-7">
                <div id="map" style="height:500px;"></div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-11">
                <hr>
            </div>
        </div>
    </div>
    <script>
        //名前衝突が起こらないように、Laravelをつけています
        window.Laravel = {};
        window.Laravel.favorite_shops = @json($favorite_shops);
    </script>
    <script src="{{ asset('/js/favorite-map.js') }}"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key=AIzaSyBvQqRbDB5sw11t3bL8eGGjNTZa5XodSMs&callback=initMap"
        async defer></script>
@endsection
