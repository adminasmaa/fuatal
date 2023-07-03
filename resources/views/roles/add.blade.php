@extends('layouts.admin')
@section('content')

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
<div class="content-wrapper section">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <!-- <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add New Role</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.user.create')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.roles.all')}}">Roles</a></li>
                        <li class="breadcrumb-item active">Add New</li>
                    </ol>
                </div>
            </div> -->
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header" style="border:none; min-height:0; ">
                            <h3 class="card-title py-5">Role Form</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form class="form mb-5" action="{{route('admin.roles.insert')}}" method="post">
                                @csrf
                                <div class="row mb-5">
                                    <div class="col-md-6 fv-row">
                                            <label class="required fs-5 fw-bold mb-2">Name</label>
                                            <input required="" type="text" name="name" placeholder="Role Name" class="form-control"/>
                                        
                                    </div>
                                    
                                </div>
                                <div class="row mb-5">
                                <div class="col-md-6 fv-row">
                                        
                                        <label class="required fs-5 fw-bold mb-2">Display Name</label>
                                        <input required="" type="text" name="display_name" placeholder="Role Display Name" class="form-control"/>
                                </div>
                                </div>
                                <div class="row mb-5">
                                <div class="col-md-6 fv-row">
                                    
                                    <label class="required fs-5 fw-bold mb-2">Description</label>
                                    <textarea required="" rows="3" name="description"  placeholder="Role Description"class="form-control"></textarea>
                                
                            </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-md-6 text-right">
                                        <input type="submit" name="submit" value="Add Role" class="w-100 btn btn-primary"/>
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

@endsection