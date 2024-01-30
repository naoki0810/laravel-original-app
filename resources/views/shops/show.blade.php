@extends('layouts.app')

@section('content')


<div class="offset-1">
  <h1 class="">
    {{$shop->name}}
  </h1>
  <a href="{{route('shops.index')}}">戻る</a>
</div>

<div class="row w-75">
  <div class="col-5 offset-1">
    <img src="{{ asset('img/dummy.png') }}" class="w-100 img-fluid">
  </div>
  <div class="col">
    <div class="d-flex flex-column">
      <div class="d-flex flex-row">
        <p class="">
          カテゴリ：{{$shop->category_id}}
        </p>
        <p class="ms-3">
          平均評価：
        </p>
      </div>
      <hr>

      <p class="">
        予算：￥{{$shop->min_price}}〜￥{{$shop->max_price}}
      </p>
      <hr>

      <div class="d-flex flex-row">
        <p class="">
          営業時間：{{$shop->opening_time}}〜{{$shop->closing_time}}
        </p>
        <p class="ms-3">
          定休日：{{$shop->regular_holiday}}
        </p>
      </div>
      <hr>

      <p class="">
        {{$shop->description}}
      </p>
      <hr>

      <div class="d-flex flex-row">
        <p class="">
          住所：〒{{$shop->postal_code}}
        </p>
        <p class="ms-2">
          {{$shop->address}}
        </p>
      </div>
      <hr>
    </div>
  </div>
</div>

{{-- 予約機能の実装 --}}

<div class="offfset-1 col-11">
  <hr class="w-100">
  <h3 class="float-left">カスタマーレビュー</h3>
</div>

<div class="offset-1 col-10">
  {{-- レビューの実装 --}}
</div>



@endsection
