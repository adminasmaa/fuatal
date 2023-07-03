<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>{{ empty($t) ? (is_array($title = __(Route::getCurrentRoute()->getName())) ? $title['title'] : $title) : $t }} | {{ config('settings.site_title') }}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/css/admin.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/lightbox/dist/css/lightbox.css') }}">
    <link rel="shortcut icon" href="{{ asset('i/icons/favicon1.ico') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    @stack('styles')
    <style type="text/css">
        .navbar.is-dark{
            background-color: cadetblue;
        }
        .navbar-item .button.is-dark{
            background-color: cadetblue;
        }
        .button.is-dark:hover{
            background-color: #363636;
        }
.is-large{
    font-size: 1.5rem;
    height: 40px !important;
}
.breadcrumb{
float:right;
}
#footerid{
color:white;width: 100%;padding-top:25px;padding-bottom:25px;background:#363636;
margin-top:230px;   
 }   
    </style>


</head>
<body>
@if($currentUser = auth()->user())@include('partials.admin.nav')@endif
@if(session('message'))<div class="notification is-info">{{ session('message') }}</div>@endif
@if($currentUser = auth()->user())
@include('partials.admin.breadcrumbs')
@endif
@yield('content')

<div id='footerid'><center><span><?php echo date("Y"); ?>© Fusteka Ice-cream. All Rights are Reserved </span> </center> </div>
<script src="{{ asset('dist/js/admin.js')}}" type="text/javascript"></script>

@hasSection('scripts')@yield('scripts')@endif
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.0.10/jspdf.plugin.autotable.min.js"></script>
<script src="{{ asset('dist/js/htmltable.js')}}" type="text/javascript"></script>
<script src="{{ asset('dist/lightbox/dist/js/lightbox.js')}}" type="text/javascript"></script>
</body>
</html>
