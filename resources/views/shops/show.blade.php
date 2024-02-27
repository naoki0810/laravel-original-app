@extends('layouts.app')

@section('content')
    <div class="container pt-4">
        <div class="row justify-content-center">
            <div class="offset-1">
                <h1 class="">
                    {{ $shop->name }}
                </h1>
                <a href="{{ route('shops.index') }}" class="show-back"><i class="fa-solid fa-backward"></i>戻る</a>
            </div>

            <div class="col-5">
                @if ($shop->image)
                    <img src="{{ asset($shop->image) }}" class="w-100 img-fluid">
                @else
                    <img src="{{ asset('img/dummy.png') }}" class="w-100 img-fluid">
                @endif
            </div>
            <div class="col-6">
                <div class="d-flex flex-column">
                    <div class="d-flex flex-row">
                        <p class="">
                            カテゴリ：{{ $shop->category->name }}
                        </p>
                        <p class="ms-3">
                            @if ($shop->reviews()->exists())
                                平均評価：<span class="nagoyameshi-star-rating" data-rate="{{ round($shop->reviews()->avg('score') * 2) / 2 }}"></span>
                                {{ round($shop->reviews()->avg('score'), 1) }}
                            @endif
                        </p>
                    </div>
                    <hr>

                    <p class="">
                        予算：{{ $shop->min_price }}円〜{{ $shop->max_price }}円
                    </p>
                    <hr>

                    <div class="d-flex flex-row">
                        <p class="">
                            営業時間：{{ $shop->opening_time }}〜{{ $shop->closing_time }}
                        </p>
                        <p class="ms-3">
                            定休日：{{ $shop->regular_holiday }}
                        </p>
                    </div>
                    <hr>

                    <p class="">
                        {{ $shop->description }}
                    </p>
                    <hr>

                    <div class="d-flex flex-row">
                        <p class="">
                            住所：〒{{ $shop->postal_code }}
                        </p>
                        <p class="ms-2">
                            {{ $shop->address }}
                        </p>
                    </div>
                    <hr>

                </div>
            </div>
        </div>


        <div class="row justify-content-center">
            {{-- 予約機能の実装 --}}

            <div class="offset-1">
                <div class="col-md-11">
                    <hr>
                    <h3 class="">予約</h3>
                </div>

                @auth
                    <div class="col-md-11">
                        <form method="POST" action="{{ route('reservations.store', $shop) }}">
                            @csrf

                            <input type="hidden" name="shop_id", value="{{ $shop->id }}">
                            <div class="form-group">
                                <h4>予約日</h4>
                                <div class="col-md-4">
                                    <input type="date" class="form-control" id="reservation_date" name="reservation_date"
                                        value="{{ old('reservation_date') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <h4>予約時間</h4>

                                <div class="col-md-4">
                                    <input type="time" class="form-control" id="reservation_time" name="reservation_time"
                                        value="{{ old('reservation_time') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <h4>予約人数</h4>

                                <div class="col-md-4">
                                    <select class="form-select" id="number_of_people" name="number_of_people">
                                        <option value="" hidden>選択してください</option>
                                        @for ($i = 1; $i <= 50; $i++)
                                            <option value="{{ $i }}">{{ $i }}名</option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="form-group justify-content-center mb-4">
                                    <button type="submit" class="btn mt-3 nagoyameshi-submit-button ml-2">予約する</button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endauth
            </div>
        </div>
        {{-- レビュー機能 --}}

        <div class="row justify-content-center">
            <div class="offset-1">
                <div class="col-md-11">
                    <hr>
                    <h3 class="">カスタマーレビュー</h3>
                </div>

                <div class="d-flex">
                    @auth
                        <div class="col-md-4">
                            <form method="POST" action="{{ route('reviews.store') }}">
                                @csrf
                                <h4>評価</h4>
                                <select name="score" class="form-control m-2 review-score-color">
                                    <option value="5" class="review-score-color">★★★★★</option>
                                    <option value="4" class="review-score-color">★★★★</option>
                                    <option value="3" class="review-score-color">★★★</option>
                                    <option value="2" class="review-score-color">★★</option>
                                    <option value="1" class="review-score-color">★</option>
                                </select>
                                <h4>タイトル</h4>
                                @error('title')
                                    <strong>タイトルを入力してください</strong>
                                @enderror
                                <input type="text" name="title" class="form-control m-2 review_title_input"
                                    placeholder="タイトルを入力してください">

                                <h4>レビュー内容</h4>
                                @error('content')
                                    <strong>レビュー内容を入力してください</strong>
                                @enderror
                                <textarea name="content" class="form-control m-2 review_content_input" placeholder="レビュー本文を入力してください"></textarea>
                                <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                                <button type="submit" class="btn nagoyameshi-submit-button ml-2">レビューを追加</button>
                            </form>
                        </div>
                    @endauth

                    <div class="col-md-7 mt-4">
                        @foreach ($reviews as $review)
                            <div class="offset-3 col-md-9">
                                <h3 class="review-score-color">{{ str_repeat('★', $review->score) }}</h3>
                                <p class="review_title">{{ $review->title }}</p>
                                <p class="review_content">{{ $review->content }}</p>
                                <label>{{ $review->created_at }} {{ $review->user->name }}</label>
                            </div>
                        @endforeach
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
