@foreach ($menus as $menu)
    <li class="dd-item" data-id="{{ $indexOfMenu++ }}" data-name="{{ $menu->name }}"
        data-type="{{ $menu->menuable_type }}" @if ($menu->menuable_type == 'external') data-url="{{ $menu->url }}" @else data-refer_id="{{ $menu->menuable_id }}" @endif>
        <div class="dd-handle">
            <div class="main-item menu-card-header">
                <span class="menu-card-header--icon">
                    <i class="fas fa-bars"></i>
                </span>
                <div class="menu-card-header--left">
                    <span class="icon-input-box">
                        <i class="icon-preview "></i>
                    </span>
                    <h6 class="menu-name">{{ $menu->name }}</h6>
                    <span class="created-item">{{ $menu->menuable_type }}</span>
                </div>
                <div class="menu-card-header--right">
                    <i class="fa fa-exclamation-triangle hide d-none"
                        title="@lang('admin.general.menu.menu_content.hidden')"></i>
                    <i class="fas fa-exclamation-circle removed d-none"
                        title="@lang('admin.general.menu.menu_content.category_removed')"></i>
                    <a href="javascript:;" class="toggle-edit-btn test" onclick="event.preventDefault();">
                        <i class="fas fa-caret-down"></i>
                    </a>
                </div>
            </div>

            <div class="edit-box d-none kv-menu-card-body">

                <div class="card-row">
                    <label>Nhập tên mục tự chọn</label>
                    <input type="text" placeholder="" name="name" value="{{ $menu->name }}"
                        class="form-control form-control-border" />
                    <p class="caption">Tên gốc <a href="javascript:void(0)"
                            class="original-name"><span>{{ $menu->name }}</span></a>
                    </p>
                </div>

                @if ($menu->menuable_type === 'external')
                    <div class="card-row">
                        <label>Nhập URL</label>
                        <input type="text" placeholder="Nhập đường dẫn" name="url" value="{{ $menu->url }}"
                            class="form-control form-control-border">
                    </div>
                @endif

                <div class="card-row">
                    <div class="custom-control custom-checkbox" style="margin-top: 18px">
                        <input class="custom-control-input" type="checkbox" ${redirect ? 'checked' : '' }
                            name="active-redirect" id="active-redirect" style="margin-top: 18px">
                        <label for="active-redirect" class="custom-control-label">Mở
                            trong tab
                            mới</label>
                    </div>
                </div>

                <div class="kv-menu-card-footer">
                    <div class="kv-menu-card-footer--left" style="z-index: 100;">
                        <a href="javascript:;" class="btn-delete color-red">
                            <i class="far fa-trash-alt mr5"></i>Xóa mục
                        </a>
                    </div>
                    <div class="kv-menu-card-footer--right">
                        <button class="btn-kv btn btn-default btn-cancel-item btn-cancel mr8">Hủy</button>
                        <button class="btn-kv btn btn-primary btn-save-item btn-save">Lưu</button>
                    </div>
                </div>
            </div>
        </div>
        @if ($menu->children)
            <ul class="dd-list">
                @include('admin.menus.menu-item', ['menus' => $menu->children])
            </ul>
        @endif
    </li>
@endforeach
