<ul class="list-group">
    @foreach ($categories as $category)
        <li class="list-group-item @if ($isChild ?? '' ) child @endif ">
        <div class=" item">
            <a href="javascript:void(0)">
                <i class="fas fa-plus add-menu" data-id="{{ $category->id }}" data-type="category"
                    data-name="{{ $category->name }}"></i>
            </a>
            <span class="category-name">{{ $category->name }}</span>
            </div>
            @if ($category->children)
                @include('admin.menus.row-category', ['categories' => $category->children, 'isChild' => true])
            @endif
        </li>
    @endforeach
</ul>
