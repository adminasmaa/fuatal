@extends('layouts.admin')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css">
<style>
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
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>All Permissions</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.user.create')}}">Home</a></li>
                        <li class="breadcrumb-item">All Permissions</li>
                        <li class="breadcrumb-item active">List</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List of All Permissions</h3>
                            <h3 class="card-title float-right"><a href="{{route('admin.permissions.add')}}" class="btn btn-primary">Add New</a></h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped projects">
                                <thead>
                                    <tr>
                                        <th >
                                            #
                                        </th>
                                        <th>
                                            Name
                                        </th>
                                        <th>
                                            Group
                                        </th>
                                        <th>
                                            Description
                                        </th>
                                        <th>
                                            Created at
                                        </th>
                                        <th>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $model)
                                    <tr>
                                        <td>
                                            {{$no++}}
                                        </td>
                                        <td>
                                            <a>
                                                {{ $model->display_name }}
                                            </a>
                                        </td>
                                        <td>
                                            <a>
                                                {{ isset($model->permissionsGroup->display_name) ? $model->permissionsGroup->display_name : '' }}
                                            </a>
                                        </td>
                                        <td>
                                            {{$model->description}}
                                        </td>
                                        <td>
                                            {{ $model->created_at }}
                                        </td>
                                        <td class="project-actions text-right">
                                            <a class="btn btn-success btn-sm" href="{{route('admin.permissions.edit', $model->id)}}">
                                                <i class="fas fa-pen">
                                                </i>
                                                Edit
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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