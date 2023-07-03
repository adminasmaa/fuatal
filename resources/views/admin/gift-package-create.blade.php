@extends('layouts.admin')
@section('content')
    <section class="section">
        <div class="container-fluid">
            <div class="card no-box-shadow-mobile">
            	 <!-- <header class="card-header">
                    <p class="card-header-title">
                        {{ 'Gift Package' }} 
                        @if (isset($link))
                            <a class="navbar-item" href="{{ $link }}">
                                <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></span>
                            </a>
                        @endif
                       
                    </p>
                </header> -->
                @if(Session::has('success'))
    <div class="alert alert-success" id="success" style="background: limegreen;
    color: white;
    width: 30%;
    padding: 13px;
    text-align: center;
    margin-left: 35%;
    margin-top: 13px;">
        
            {{ Session::get('success') }}
            @php session()->forget('success');  @endphp
        
    </div>
    @endif
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

                <div class="card-content" style="padding-bottom: 2rem;">
                    <div class="container-fluid">
        <h5 class="py-5">Add Gift Package Detail</h5>
    <form method="POST" enctype="multipart/form-data" action="{{url('/admin/packages')}}">
    <!-- <form method="POST" enctype="multipart/form-data" action="{{route('admin.category.store')}}"> -->
         @csrf
        <div class="row mb-5">
            <div class="col-md-6 fv-row">
                <label class="required fs-5 fw-bold mb-2">Package Name</label>
                <input class="form-control" value="" type="text" name="name" required="required">
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-md-6 fv-row">
                <label class="required fs-5 fw-bold mb-2">Start Date</label>
                <input class="form-control" value="" pattern="\d{4}-\d{2}-\d{2}" data-provide="datepicker" type="date" name="start_date" required="required">
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-md-6 fv-row">
                <label class="required fs-5 fw-bold mb-2">End Date</label>
                <input class="form-control" value="" pattern="\d{4}-\d{2}-\d{2}" data-provide="datepicker" type="date" name="end_date" required="required">
            </div>
            
        </div>
        <div class="row">
            <div class="col-md-6 fv-row">
                <button type="submit" class="w-100 btn btn-primary">Save</button>
            </div>
        </div>
    </div>
                
     <input type="hidden" name="category_form" value="subcategory_form">
           
  
                
          
</form>
<br>
</div>
               
               
            </div>  
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script type="text/javascript">$(function(){window.LaravelDataTables=window.LaravelDataTables||{};window.LaravelDataTables["dataTableBuilder"]=$("#dataTableBuilder").DataTable();});
</script>

<script>
    $(document).ready(function(){
        $('.datepicker').datetimepicker();
    })
</script>

