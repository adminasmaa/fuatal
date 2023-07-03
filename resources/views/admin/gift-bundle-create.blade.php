@extends('layouts.admin')
@section('content')

    <section class="section">
        <div class="container-fluid">
            <div class="card no-box-shadow-mobile">
            	 <!-- <header class="card-header">
                    <p class="card-header-title">
                        {{ 'Gift Bundle' }} 
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
                <div class="card-content" style="padding-bottom: 2rem;">
                    <div class="container-fluid">
        <h5 class="py-5">Add Gift Bundle Detail</h5>
    <form method="POST" enctype="multipart/form-data" action="{{url('/admin/bundles')}}">
    <!-- <form method="POST" enctype="multipart/form-data" action="{{route('admin.category.store')}}"> -->
         @csrf
    <div class="row mb-5">
            <div class="col-md-6 fv-row">
                <label class="required fs-5 fw-bold mb-2">Select Package</label>
                <select data-control="select2" data-placeholder="Select Package..." class="form-select" name="package_id" required>
                    <option value="">---Select Package---</option>
                        @foreach($packages as $package)
                        <option value="{{$package->id}}">{{$package->name}}</option>
                        @endforeach
                </select>        
            </div>
            
    </div>
    <div class="row mb-5">
    <div class="col-md-6 fv-row">
                <label class="required fs-5 fw-bold mb-2">Bundle Name</label>
                
                <input class="form-control" value="" type="text" name="name" required="required">
            
            </div>
    </div>
    <div class="row mb-5">
            <div class="col-md-6 fv-row">
            <label class="required fs-5 fw-bold mb-2">Number of Gifts</label>
           
            <input class="form-control" type="number" min="0" name="limit" required="required">

            </div>
        </div>
                
            <div class="row">
                <div class="col-md-6">
                <input type="hidden" name="category_form" value="subcategory_form">
            <div class="control">
  
    <button type="submit" class="w-100 btn btn-primary">Save</button>
</div>
                </div>
            </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

