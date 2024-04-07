@extends('layouts.app')

@section('content')
    <div class="nagoya_image">
        <div class="row">
            <div class="genre">
                <h1>ジャンルから探す</h1>
                @component('components.sidebar', ['categories' => $categories])
                @endcomponent
            </div>
        </div>
    </div>
@endsection
