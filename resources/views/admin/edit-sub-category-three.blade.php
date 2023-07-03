@extends('layouts.admin')

@section('content')
    <section class="section">
        <div class="container-fluid">
            <div class="card no-box-shadow-mobile">
            	 <header class="card-header">
                    <p class="card-header-title">
                        {{ 'SubCategory' }}
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
        <h1 class="title">Subcategory Edit Form</h1>
  <form method="POST" enctype="multipart/form-data" action="{{url('admin/update/subcat/three')}}">
         @csrf
        <div class="field">
    <label class="label">Category</label>
    <div class="control">
            <select onchange="getSubCat(this.value)" class="input" name="category_id">
                @foreach($catObj as $category)
               @if($dataObj->category_id == $category->id)
               <option selected="selected" value="{{$category->id}}">{{$category->title}}</option> 
               @else
               <option value="{{$category->id}}">{{$category->title}}</option> 
               @endif
               @endforeach
            </select>

    </div>
   
</div>

 <div class="field">
    <label class="label">SubCategory(1)</label>
    <div class="control">
        <select class="input" onchange="getSubCatFinal(this.value)" name="subcategory_id" id="subcategory_id">
          

             @foreach($subCatObj as $sbcategory)
               @if($dataObj->subcategory_id == $sbcategory->id)
               <option selected="selected" value="{{$sbcategory->id}}">{{$sbcategory->title}}</option> 
               @else
               <option value="{{$sbcategory->id}}">{{$sbcategory->title}}</option> 
               @endif
             @endforeach
        </select>
         

    </div>
   
</div>

 <div class="field">
    <label class="label">SubCategory(2)</label>
    <div class="control">
        <select class="input" name="subcategoryfinal_id" id="subcategoryfnal_id">
          

             @foreach($subCatfinalObj as $sbcategoryfinal)
               @if($dataObj->subcategoryfinal_id == $sbcategoryfinal->id)
               <option selected="selected" value="{{$sbcategoryfinal->id}}">{{$sbcategoryfinal->title}}</option> 
               @else
               <option value="{{$sbcategoryfinal->id}}">{{$sbcategoryfinal->title}}</option> 
               @endif
             @endforeach
        </select>
         

    </div>
   
</div>

            <div class="field">
    <label class="label">Subcategory Title(level3)</label>
    <div class="control">
                <input class="input" value="{{$dataObj->title}}" type="text" name="title">

    </div>
   
</div>
            <div class="field">
    <label class="label">Description</label>
    <div class="control">
                <input class="input" value="{{$dataObj->description}}" type="text" name="description">

    </div>
   
</div>

<div class="control">

                <label class="label">Subcategory Image</label>
            <img width="170px" src="{{URL::asset('uploads/categories/'.$dataObj->subcat_image_final)}}">
     <input type="file" name="subcat_image" class="input" style="height: 60px !important;margin-bottom:13px">
     <input type="hidden" name="filename" value="{{$dataObj->subcat_image_final}}">
 </div>
     <input type="hidden" name="id" value="{{$dataObj->id}}">
            
            <div class="control">
  
    <button type="submit" class="button is-info is-fullwidth is-large">Save</button>
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

@endsection
  <script type="text/javascript">

function getSubCat(id) {
    //alert(id)
     var url="{{url('admin/get/subcategories/ajx')}}";
        //alert(id+''+url);
        $.get(url,{id:id},function(arg) {
          $('#subcategory_id').empty().append(arg);
        });
}
  
function getSubCatFinal(id) {
    //alert(id)
     var url="{{url('admin/get/subcategories/final/ajx')}}";
        //alert(id+''+url);
        $.get(url,{id:id},function(arg) {
          $('#subcategoryfinal_id').empty().append(arg);
        });
}        
function deleteRecord(id){
    if(confirm('Are you sure?')){
        
        var url="{{url('admin/delete/subcat')}}";
        //alert(url);
        $.get(url,{id:id},function(arg) {
          location.reload();
            // body...
        });
    }
}


</script>

