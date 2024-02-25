@extends('layouts.app')

@section('content')
<div class="container pt-4">
  <div class="row justify-content-around">
    <div class="col-md-3">
      <form action="{{ route('subscription.destroy') }}" method="post">
        @csrf
        @method('DELETE')

          <h1>有料会員解約</h1>
          <p>有料会員を解約してもよいですか？</p>

          <button class="btn btn-warning mt-2">解約</button>
      </form>
    </div>
  </div>
</div>
@endsection

