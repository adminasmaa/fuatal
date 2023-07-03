@extends('layouts.admin')

@section('content')

<style>
    .alert.alert-success a{
        color: black;
        font-weight: bold;
    }
</style>
    <section class="section">
        <div class="container-fluid">
            <div class="card no-box-shadow-mobile">
            	 <header class="card-header">
                 <h1 class="py-5"> {{ 'Generate Instant Gifts for '.$bundle->name }}</h1>
                    <p class="card-header-title">
                        @if (isset($link))
                            <a class="navbar-item" href="{{ $link }}">
                                <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></span>
                            </a>
                        @endif
                    </p>
                </header>
                @if(Session::has('success'))
    <div class="alert alert-success" id="success" style="background: limegreen;
    color: white;
    width: 70%;
    padding: 13px;
    text-align: center;
    margin-left: 15%;
    margin-top: 13px;">
        {!! Session::get('success') !!}
            <!-- {{ Session::get('success') }} -->
            @php session()->forget('success');  @endphp
        
    </div>
    @endif
                <div class="card-content" style="padding-bottom: 2rem;">
                    <div class="container-fluid">
       
    <form method="POST" enctype="multipart/form-data" action="{{url('admin/save/instantnumbers')}}">
         @csrf
         <input type="hidden" value="{{$bundle->id}}" name="bundle"/>
         <div class="row mb-5">
            <div class="col-md-6 fv-row">
            <label class="required fs-5 fw-bold mb-2">Product</label>
            
                    <select data-control="select2" data-placeholder="Select Product..." class="form-select" name="product" required>
                        <option value="" selected="selected">---Select Product---</option>
                        @foreach($products as $product)
                        <option value="{{$product->id}}">{{$product->title}}</option>
                        @endforeach
                    </select>
   
        </div>
</div>
<div class="row mb-5">
<div class="col-md-6 fv-row">
            <label class="required fs-5 fw-bold mb-2">Limit of QR Codes (Instant Gifts)</label>
            
                <input placeholder="Enter number eg. 100" class="form-control" min="1" max="{{$max}}" value="" type="number" name="counter_gift" required>

        </div>
</div>
<div class="row mb-5">
    
        <div class="col-md-6">
    <button type="submit" class="btn btn-primary w-100">Save</button>

        </div>
</div>
        <div class="col-md-12 mt-5">
        <span style="color: red; font-weight: bold;">Please be patient! This may take few minutes for large number of Codes</span>

        </div>
<!-- </div> -->
           
  
</div>
</form>
<br>
</div>
               
               
            </div>  
            </div>
        </div>
    </section>

@endsection

