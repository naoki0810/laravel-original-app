<div class="container">
    <div class="row">
        @foreach ($categories as $category)
            <div>
                <a href="{{ route('shops.index', ['category' => $category->id]) }}"
                    class="btn btn-light nagoyameshi-sidebar-category-label">{{ $category->name }}</a>
            </div>
        @endforeach
    </div>
</div>
