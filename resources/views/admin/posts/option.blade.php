@foreach ($categories as $category)
    @php
        $originalLevel = $level;
    @endphp
    @if ($category->id === $categoryId)
        <option value="{{ $category->id }}" selected="selected" class="level-option" data-level="{{ $level }}">
            {{ $category->name }}</option>
    @else
        <option value="{{ $category->id }}" class="level-option" data-level="{{ $level }}">
            {{ $category->name }}</option>

    @endif
    @if ($category->children)
        @include('admin.posts.option', ['categories' => $category->children, 'level' => ++$originalLevel, 'categoryId'
        => $categoryId])
    @endif
@endforeach
