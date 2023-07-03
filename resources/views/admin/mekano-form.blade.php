@extends('layouts.admin')

@section('content')
    <section class="section">
        <div class="container-fluid">
            <div class="card no-box-shadow-mobile">
            	
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
        <h1 class="title py-5">Add Mekano</h1>
    <form method="POST" enctype="multipart/form-data" action="{{route('admin.mekano.save')}}">
         @csrf
         <div class="row mb-5">
            <div class="col-md-6 fv-row">
            <label class="required fs-5 fw-bold mb-2">No. of Sticks</label>
                <select data-control="select2" data-placeholder="Select Stick..." class="form-select" name="no_of_sticks">
                    @foreach($sticks as $stick)
                    <option value="{{$stick->id}}">{{$stick->range}}</option>
                    @endforeach
                </select>
            </div>
            
         </div>
         <div class="row mb-5">
         <div class="col-md-6 fv-row">
                <label class="required fs-5 fw-bold mb-2">Mekano Image(626px x 367px)</label>
                    <input type="file" name="image" class="form-control" required="">
                    <input type="hidden" name="mekano_form" value="mekano_form">
            </div>
         </div>
            <div class="row">
                <div class="col-md-6">
                <div class="control">
  
  <button type="submit" class="btn btn-primary w-100">Save</button>
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
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="modalLabel">Crop Image Before Upload</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
<div class="modal-body">
<div class="img-container-fluid">
<div class="row">
<div class="col-md-8">
<img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
</div>
<div class="col-md-4">
<div class="preview"></div>
</div>
</div>
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
<button type="button" class="btn btn-primary" id="crop">Crop</button>
</div>
</div>
</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">$(function(){window.LaravelDataTables=window.LaravelDataTables||{};window.LaravelDataTables["dataTableBuilder"]=$("#dataTableBuilder").DataTable();});
</script>
@endsection

