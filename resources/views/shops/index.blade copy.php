@extends('layouts.app')

@section('content')
    <div class="container pt-4">
        <div class="row justify-content-center">
            <div class="col-2">
                @component('components.sidebar', ['categories' => $categories])
                @endcomponent
            </div>

            <div class="col-9">
                <div class="container">
                    @if ($category !== null)
                        <a href="{{ route('shops.index') }}" class="index-top">トップ > </a>{{ $category->name }}
                        <h1>{{ $category->name }}の店舗一覧{{ $total_count }}件</h1>
                    @elseif ($keyword !== null)
                        <a href="{{ route('shops.index') }}"class="index-top">トップ</a> > 商品一覧
                        <h1>"{{ $keyword }}"の検索結果{{ $total_count }}件</h1>
                    @endif
                </div>
                <div>
                    Sort By
                    @sortablelink('min_price', '価格')

                </div>

                <div class="row mt-4">
                    @foreach ($shops as $shop)
                        <div class="col-3">
                            <a href="{{ route('shops.show', $shop) }}">
                                @if ($shop->image !== '')
                                    <img src="{{ asset($shop->image) }}" class="img-thumbnail">
                                @else
                                    <img src="{{ asset('img/dummy.png') }}" class="img-thumbnail">
                                @endif
                            </a>
                            <div class="col-12">
                                <p class="nagoyameshi-shop-label mt-2">
                                <div class="shop_info shop_name">{{ $shop->name }}</div>
                                {{-- カテゴリー名を表示 --}}
                                <div class="shop_info shop_category">{{ $shop->category_id }}</div>
                                
                                <div class="shop_info shop_price">¥{{ $shop->min_price }}〜¥{{ $shop->max_price }}</div>
                                <div class="">
                                    @if ($shop->reviews()->exists())
                                        <span class="nagoyameshi-star-rating"
                                            data-rate="{{ round($shop->reviews()->avg('score') * 2) / 2 }}"></span>
                                        {{ round($shop->reviews()->avg('score'), 1) }}
                                    @endif
                                </div>
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            {{ $shops->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
