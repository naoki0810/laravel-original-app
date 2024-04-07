<div class="container">
    <div class="row cp_ipselect cp_sl01">
        <select onChange="location.href=value;">
            <option value="">ジャンルを選択</option>
            @foreach ($categories as $category)
                <option value="{{ route('shops.index', ['category' => $category->id]) }}">
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>