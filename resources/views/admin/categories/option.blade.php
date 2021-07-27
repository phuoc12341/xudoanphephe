@foreach ($categories as $category)
    @php
        $originalLevel = $level;
    @endphp
    <option value="{{ $category->id }}" class="level-option" data-level="{{ $level }}">{{ $category->name }}
    </option>
    @if ($category->children)
        @include('admin.categories.option', ['categories' => $category->children, 'level' => ++$originalLevel])
    @endif
@endforeach
