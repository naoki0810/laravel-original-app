@extends('layouts.app')

@section('content')
    <div class="nagoya_image">
        <div class="container pt-4">
            <div class="row justify-content-center">

                <div class="col-2">
                    @component('components.sidebar', ['categories' => $categories])
                    @endcomponent
                </div>
                <div class="col-9 genre">
                    <h1>ジャンルから探す</h1>
                </div>
            </div>
        </div>
    </div>
@endsection
