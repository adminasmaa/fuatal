<section class="section bg-white">
    <div class="container-fluid">
        
        <h1 class="title py-5">{{ __('admin.' . $resource . '.' . ($action ?? 'edit')) }}</h1>
        @php [$name, $id] = ${$resource} !== null ? ['update', ${$resource}->id] : ['store', null] @endphp
        <?php 
        
            if(isset($action) == "password"){
                $resource = $resource.'.update-password';
            }
        ?>
        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.' . $resource . '.' . $name, $id) }}">
        
        @include('partials.admin.errors')

