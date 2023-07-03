@extends('layouts.admin')

@section('content')
    <section class="section">
        <div class="container-fluid">
            <div class="card no-box-shadow-mobile">
            	 <header class="card-header">
                    <p class="card-header-title">
                        {{ 'SubCategory3' }}
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
        <h1 class="title">Subcategory3 Form</h1>
    <form method="POST" enctype="multipart/form-data" action="{{route('admin.subcategorythree.store')}}">
         @csrf
        <div class="field">
    <label class="label">Category</label>
    <div class="control">
            <select onchange="getSubCat(this.value)" class="input" name="category_id">
                @foreach($catObj as $category)
               <option value="{{$category->id}}">{{$category->title}}</option> 
               @endforeach
            </select>

    </div>
   
</div> 

 <div class="field">
    <label class="label">SubCategory(1)</label>
    <div class="control">
        <select class="input" onchange="getSubCatFinal(this.value)" name="subcategory_id" id="subcategory_id">
            <option></option>
        </select>
           <!--  <select class="input" name="subcategory_id">
                @foreach($subcatObj as $subcategory)
               <option value="{{$subcategory->id}}">{{$subcategory->title}}</option> 
               @endforeach
            </select> -->

    </div>
   
</div>


<div class="field">
    <label class="label">SubCategory(2)</label>
    <div class="control">
        <select class="input" name="subcategoryfinal_id" id="subcategoryfinal_id">
            <option></option>
        </select>
           <!--  <select class="input" name="subcategory_id">
                @foreach($subcatObj as $subcategory)
               <option value="{{$subcategory->id}}">{{$subcategory->title}}</option> 
               @endforeach
            </select> -->

    </div>
   
</div>

            <div class="field">
    <label class="label">Subcategory(3) Title</label>
    <div class="control">
                <input class="input" value="" type="text" name="title">

    </div>
   
</div>
            <div class="field">
    <label class="label">Description</label>
    <div class="control">
                <input class="input" value="" type="text" name="description">

    </div>
   
</div>
                <label class="label">Subcategory Image</label>
     <input type="file" name="subcat_image" class="input" style="height: 60px !important;margin-bottom:13px" required="">
     <input type="hidden" name="category_form" value="subcategory_form">
            <div class="control">
  
    <button type="submit" class="button is-info is-fullwidth is-large">Save</button>
</div>
</form>
<br>
</div>


           
            	<table id="dataTableBuilder" class="table dataTable no-footer">
            	<thead>
                    <th>Action</th>
            		<th>Image</th>
                    <th>Title</th>
            		<th>Parent-SubCategory</th>
            		<th>Description</th>
            		
            	</thead>
            	<tbody>
            		@foreach($subObj as $item)
            		
            		<tr>
                        <td>
      <button class="button is-small is-danger" type="submit" onclick="deleteRecord({{$item->id}})">
                <span class="icon">
                    <svg viewBox="0 0 32 32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                        <path d="M28 6 L6 6 8 30 24 30 26 6 4 6 M16 12 L16 24 M21 12 L20 24 M11 12 L12 24 M12 6 L13 2 19 2 20 6"></path>
                    </svg>
                </span>
                <span>Delete</span>
            </button> 

            <a class="button is-small is-primary" href="{{url('admin/subcategoryfinal/'.$item->id.'/edit')}}">
            <span class="icon">
                <svg viewBox="0 0 32 32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                    <path d="M30 7 L25 2 5 22 3 29 10 27 Z M21 6 L26 11 Z M5 22 L10 27 Z"></path>
                </svg>
            </span>
            <span>Edit</span>
        </a>    
                        </td>
            		<td>
            			@if(is_null($item->subcat_image_final))
            			<img width="70px" src="{{URL::asset('uploads/categories/')}}">
            			@else
            			<img width="70px" src="{{URL::asset('uploads/categories/'.$item->subcat_image_three)}}">
            			@endif
            		</td>
            		<td>{{$item->title}}</td>
                    <td>{{$item->cat_title}}</td>	
            		<td>{{$item->description}}</td>	
            		</tr>
            		@endforeach
            	</tbody>	
            	</table>
               
               
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

        var url="{{url('admin/delete/subcat/three')}}";
        //alert(url);
        $.get(url,{id:id},function(arg) {
          location.reload();
            // body...
        });

       
    }
}


</script>

