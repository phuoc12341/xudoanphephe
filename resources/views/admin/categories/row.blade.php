@foreach ($categories as $category)
    @php
        $originalLevel = $level;
    @endphp
    <tr>
        <td>
            <a class="category-name" style="--level:{{ $level }};">
                {{ $category->name }}
            </a>
        </td>
        <td class="project-state">
            <span class="badge badge-success">Success</span>
        </td>
        <td class="project-actions text-right">
            <a class="btn btn-outline-warning btn-sm edit-category" href="javascript:void(0)" data-toggle="modal"
                data-target="#modal-category" data-id="{{ $category->id }}" data-name="{{ $category->name }}">
                <i class="fas fa-pencil-alt"></i>
            </a>
            @if ($category->status === App\Models\Category::ACTIVE)
                <a class="btn btn-success btn-sm switch-category-status" href="javascript:void(0)"
                    data-id="{{ $category->id }}" data-status="{{ $category->status }}">
                    <i class="far fa-eye"></i>
                </a>
            @else
                <a class="btn btn-outline-success btn-sm switch-category-status" href="javascript:void(0)"
                    data-id="{{ $category->id }}" data-status="{{ $category->status }}">
                    <i class="fas fa-eye-slash"></i>
                </a>
            @endif
            <a class="btn btn-outline-danger btn-sm delete-category" href="javascript:void(0)"
                data-id={{ $category->id }}>
                <i class="fas fa-trash"></i>
            </a>
            <a class="btn btn-outline-primary btn-sm" href="#">
                <i class="fas fa-external-link-alt"></i>
            </a>
        </td>
    </tr>
    @if ($category->children)
        @include('admin.categories.row', ['categories' => $category->children, 'level' => ++$originalLevel])
    @endif
@endforeach
