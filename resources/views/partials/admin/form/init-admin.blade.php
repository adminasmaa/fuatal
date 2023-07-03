<section class="section bg-white">
    <div class="container-fluid">
        <h1 class="title py-5">{{ __('admin.'.$action) }}</h1>
        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.'.$action.'.admin') }}">
        
        @include('partials.admin.errors')

