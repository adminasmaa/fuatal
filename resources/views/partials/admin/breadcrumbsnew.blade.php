<div class="toolbar" id="kt_toolbar" style="top: -1px !important; position:absolute;background: #1e1e2d;">
    <div id="kt_toolbar_container-fluid" class="container-fluid d-flex flex-stack">
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                <li class="breadcrumb-item" style="color: white;"><a class="text-muted text-hover-primary" href="{{ route('admin.dashboard.index') }}">{{ __('admin.dashboard.index') }}</a></li>
            </ul>
        </div>
        <div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
            @include('partials.admin.nav.logout', ['class' => 'is-hidden-tablet'])
        </div>
    </div>
</div>