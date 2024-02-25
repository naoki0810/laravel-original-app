<div class="container">
    @foreach ($categories as $category)
        {{-- <label class="nagoyameshi-sidebar-category-label"><a href="{{ route('shops.index', ['category' => $category->id]) }}" class="nagoyameshi-sidebar-category-label">{{ $category->name }}</a></label> --}}
        <div>
            <a href="{{ route('shops.index', ['category' => $category->id]) }}"
                class="btn btn-light nagoyameshi-sidebar-category-label">{{ $category->name }}</a>
        </div>
    @endforeach
</div>
