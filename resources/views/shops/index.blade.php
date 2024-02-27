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
                        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
                            aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('shops.index') }}">トップ</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
                            </ol>
                        </nav>
                        <h1>{{ $category->name }}の店舗一覧{{ $total_count }}件</h1>
                    @elseif ($keyword !== null)
                    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('shops.index') }}">トップ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">商品一覧</li>
                    </ol>
                </nav>
                        <h1>"{{ $keyword }}"の検索結果{{ $total_count }}件</h1>
                    @endif
                </div>
                <div class="">
                    @sortablelink('min_price', '価格')
                </div>

                <div class="row mt-4">
                    @foreach ($shops as $shop)
                        @if (!is_null($shop->category))
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
                                    <div class="shop_info shop_category">{{ $shop->category->name }}</div>
                                    <div class="shop_info shop_price">{{ $shop->min_price }}円〜{{ $shop->max_price }}円
                                    </div>
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
                        @endif
                    @endforeach
                </div>
            </div>
            {{ $shops->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
