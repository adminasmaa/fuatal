@extends('layouts.admin')
@section('title')
<title>{{$role->display_name}} Permissions</title>
@endsection
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css">
<style>
    .permissions-collapses .card-header{
    background-color: transparent;
    background: linear-gradient(to left, skyblue 1%, cadetblue 100%);
}
.permissions-collapses .card-header .card-link{
    display: block;
    color: aliceblue;
    font-weight: bold;
    width: 100% !important;
    padding-left: 30px;
}
    .project-actions{
        display: flex;
    }
    img {
display: block;
max-width: 100%;
}
.preview {
overflow: hidden;
width: 150px; 
height: 150px;
margin: 40px;
border: 1px solid red;
}
.modal-lg{
max-width: 1000px !important;
}
    .navbar-dropdown a.navbar-item:focus, .navbar-dropdown a.navbar-item:hover{
    text-decoration: none !important;
}
.navbar.is-dark .navbar-brand > a.navbar-item:focus, .navbar.is-dark .navbar-brand > a.navbar-item:hover, .navbar.is-dark .navbar-brand > a.navbar-item.is-active, .navbar.is-dark .navbar-brand .navbar-link:focus, .navbar.is-dark .navbar-brand .navbar-link:hover, .navbar.is-dark .navbar-brand .navbar-link.is-active{
    text-decoration: none !important;
}
.card{
    display: block !important;
}
.card-header{
    display: block;
}
.breadcrumb{
    background-color: transparent !important;
    padding: 0 !important;
}
.card-footer:first-child, .card-content:first-child, .card-header:first-child{
    border-top-left-radius: 0.25rem !important;
    border-top-right-radius: 0.25rem !important;
    padding: 0;
    line-height: 65px;
}
a:hover{
    text-decoration: none !important;
}
.navbar{
    padding: 0 !important;
}
.navbar-brand{
    font-size: unset !important;
    display: flex !important;
    padding-top: 0 !important;
    padding-bottom: 0 !important;
    margin-right: 0 !important;
}
.navbar > .container{
    align-items: stretch !important;
}
</style>
<div class="content-wrapper section">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Permissions for {{$role->display_name}}</h1>
                </div>
                <!-- <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.user.create')}}">Home</a></li>
                        <li class="breadcrumb-item">Permissions</li>
                        <li class="breadcrumb-item active">List</li>
                    </ol>
                </div> -->
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List of All Permissions for all Modules</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form class="leave-apply-form" action="{{route('admin.roles.assignPermissions')}}" method="post">
                                @csrf
                                <input type="hidden" name="role_id" value="{{$role->id}}"/>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="accordion" class="permissions-collapses">
                                            <?php
                                            $cnt = 1;
                                            foreach ($permissions_groups as $group) {
                                                if (isset($group->permissions) && count($group->permissions->toArray())) {
                                                    ?>
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <a class="card-link" data-toggle="collapse" href="#collapse-<?= $group->id ?>">
                                                                {{ $group->display_name }}
                                                            </a>
                                                        </div>
                                                        <div id="collapse-{{$group->id}}" class="collapse {{$cnt == 0 ? 'show' : ''}}" data-parent="#accordion">
                                                            <div class="card-body">
                                                                <div class="form-group clearfix">
                                                                    <!-- <div class="checkbox icheck-warning">
                                                                        <input type="checkbox" id="checkall-{{$group->id}}">
                                                                        <label for="checkall-{{$group->id}}">
                                                                            Check All
                                                                        </label>
                                                                    </div> -->
                                                                    <?php foreach ($group->permissions as $permission) { ?>
                                                                        <div class="checkbox icheck-warning d-inline">
                                                                            <input name="permissions[]" {{in_array($permission->id, $role_permissions) ? 'checked' : ''}} value="{{$permission->id}}" type="checkbox" class="check-{{$group->id}}" id="checkbox-{{$permission->id}}">
                                                                            <label class="font-weight-normal" for="checkbox-{{$permission->id}}">
                                                                                {{ $permission->display_name }}
                                                                            </label>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                $cnt++;
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <input type="submit" name="submit" value="Update Permissions" class="btn btn-success"/>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
@endsection