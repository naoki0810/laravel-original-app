<nav  class="navbar navbar-expand-md navbar-light shadow-sm nagoyameshi-header-container">
  <div class="container">
    <a class="navbar-brand header_logo" href="{{ url('/') }}">
      {{ config('app.name', 'Laravel') }}
    </a>

    <form action="{{ route('shops.index') }}" method="GET" class="row g-1">
      <div class="col-auto">
        <input class="form-control nagoyameshi-header-search-input" name="keyword">
      </div>
      <div class="col-auto">
        <button type="submit" class="btn nagoyameshi-header-search-button"><i class="fas fa-search nagoyameshi-header-search-icon"></i></button>
      </div>
    </form>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mr-5 mt-2">
        @guest
          <li class="nav-item mr-5">
            <a class="nav-link" href="{{ route('register') }}">登録</a>
          </li>
          <li class="nav-item mr-5">
            <a class="nav-link" href="{{ route('login') }}">ログイン</a>
          </li> 
        @else
          <li class="nav-item mr-5">
            <a class="nav-link" href="{{ route('mypage') }}">
              <i class="fas fa-user mr-1"></i><label>マイページ</label>
            </a>
          </li>
           <li class="nav-item mr-5">
           <a class="nav-link" href="{{ route('mypage.favorite') }}">
            <i class="fa-solid fa-heart"></i><label>お気に入り</label>
           </a>
         </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>