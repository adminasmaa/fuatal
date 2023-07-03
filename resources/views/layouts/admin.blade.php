<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <!-- <title>{{ empty($t) ? (is_array($title = __(Route::getCurrentRoute()->getName())) ? $title['title'] : $title) : $t }} | {{ config('settings.site_title') }}</title> -->
    <title>{{ config('settings.site_title') }}</title>
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset('dist/css/admin.css') }}"> -->
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/css/admin-theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/lightbox/dist/css/lightbox.css') }}">
    <link rel="shortcut icon" href="{{ asset('i/icons/favicon1.ico') }}">
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Page Vendor Stylesheets(used by this page)-->
    <link href="{{ asset('src/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('src/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{ asset('src/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('src/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    @stack('styles')
    <style type="text/css">
        .navbar.is-dark {
            background-color: cadetblue;
        }

        .navbar-item .button.is-dark {
            background-color: cadetblue;
        }

        .button.is-dark:hover {
            background-color: #363636;
        }

        .is-large {
            font-size: 1.5rem;
            height: 40px !important;
        }

        .breadcrumb {
            float: right;
        }

        #footerid {
            /* color:white;width: 100%;padding-top:25px;padding-bottom:25px;background:#363636; */
            margin-top: 230px;
        }

        .section {
            min-height: 100vh;
            margin-top: 1%;
        }

        .header-fixed .toolbar-fixed .toolbar {
            top: 0px !important;
        }

        #dataTableBuilder_filter {
            margin-top: -5.5%;
            margin-bottom: 3%;
        }
    </style>


</head>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed" style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
    @if($currentUser = auth()->user())@include('partials.admin.nav')@endif
    @if(\Request::route()->getName() == "auth.login")
    <div id="kt_wrapper">
        @else
        <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
            @endif

            <!-- if($currentUser = auth()->user())include('partials.admin.nav_header')endif -->
            @if(session('message'))<div class="notification is-info">{{ session('message') }}</div>@endif
            @if($currentUser = auth()->user())
            @include('partials.admin.breadcrumbsnew')
            @endif

            @yield('content')
            @if(\Request::route()->getName() != "auth.login")
            <div class="footer py-4 mt-4 d-flex flex-lg-column" id="kt_footer" style="background-color: #e9ecef;position: relative;
    bottom: 0px;
    left: 0px;
    right: 0px;
    margin-bottom: 0px;">
                <!--begin::Container-->
                <div class="container-fluid flex-column flex-md-row align-items-center justify-content-between">
                    <!--begin::Copyright-->
                    <center>
                        <div class="text-dark order-2 order-md-1" style="color:#000 !important;">
                            <span class="text-muted fw-bold me-1" style="color:#000 !important;">©<?php echo date("Y"); ?></span>
                            <a href="#" target="_blank" style="color:#000 !important;">Fusteka Ice-cream. All Rights are Reserved</a>
                        </div>
                    </center>
                </div>
                <!--end::Container-->
            </div>
            @endif





            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.0.10/jspdf.plugin.autotable.min.js">
            </script>
            <script src="{{ asset('dist/js/htmltable.js')}}" type="text/javascript"></script>

            <!--begin::Global Javascript Bundle(used by all pages)-->
            <script src="{{ asset('src/plugins/global/plugins.bundle.js') }}"></script>
            <script src="{{ asset('src/js/scripts.bundle.js') }}"></script>
            <script src="{{ asset('dist/lightbox/dist/js/lightbox.js')}}" type="text/javascript"></script>
            <script src="{{ asset('src/plugins/custom/datatables/datatables.bundle.js') }}"></script>
            <!--end::Global Javascript Bundle-->
            <!--begin::Page Vendors Javascript(used by this page)-->
            <!-- <script src="{{ asset('src/plugins/custom/datatables/datatables.bundle.js') }}"></script> -->
            <!--end::Page Vendors Javascript-->
            <!--begin::Page Custom Javascript(used by this page)-->
            <!-- <script src="{{ asset('src/js/custom/apps/user-management/users/list/table.js') }}"></script>
		<script src="{{ asset('src/js/custom/apps/user-management/users/list/export-users.js') }}"></script>
		<script src="{{ asset('src/js/custom/apps/user-management/users/list/add.js') }}"></script> -->
            <!-- <script src="{{ asset('src/js/widgets.bundle.js') }}"></script>
		<script src="{{ asset('src/js/custom/widgets.js') }}"></script>
		<script src="{{ asset('src/js/custom/apps/chat/chat.js') }}"></script> -->
            <!-- <script src="{{ asset('src/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
		<script src="{{ asset('src/js/custom/utilities/modals/create-app.js') }}"></script>
		<script src="{{ asset('src/js/custom/utilities/modals/users-search.js') }}"></script> -->
            <!--end::Page Custom Javascript-->
            <!--end::Javascript-->
            <!-- <script src="{{ asset('dist/js/admin.js')}}" type="text/javascript"></script> -->
            @hasSection('scripts')@yield('scripts')@endif
</body>

</html>