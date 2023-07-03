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
                    <h1>Add New Permission</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.user.create')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.permissions.all')}}">Permissions</a></li>
                        <li class="breadcrumb-item active">Add New</li>
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
                            <h3 class="card-title">Permission Form</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form class="leave-apply-form" action="{{route('admin.permissions.insert')}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="permissions_group_id">{{ __('Permission Group') }}</label>
                                            <select required="" name="permissions_group_id" id="permissions_group_id" class="form-control select2" style="width: 100%;">
                                                <option value="">---Select Option---</option>
                                                @foreach($groups as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input required="" type="text" name="name" placeholder="Permission Name" class="form-control"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Display name</label>
                                            <input required="" type="text" name="display_name" placeholder="Permission Display Name" class="form-control"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea required="" rows="3" name="description"  placeholder="Permission Description"class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-right">
                                        <input type="submit" name="submit" value="Add Permission" class="btn btn-success"/>
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