@extends('layouts.admin')

@section('content')
    <section class="section">
        <div class="container-fluid">
            <div class="card no-box-shadow-mobile">
            	 <header class="card-header">
                    <p class="card-header-title">
                        {{ 'Add Product Translation' }}
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
        
    <form method="POST" enctype="multipart/form-data" action="{{url('admin/translate/product/save')}}">
         @csrf
         <input type="hidden" name="trans_id" value="{{$dataObj->trans_id}}">
       

 <div class="field">
    <label class="label">Language*</label>
    <div class="control">

            <select dir="rtl" class="input" name="lang_name" required="required">
            
               @foreach($langObj as $item)
               @if($item->lang_name!='English')
               <option selected="selected" value="{{$item->lang_name}}">{{$item->lang_name}}</option>
               @endif
               @endforeach
            </select>

    </div>
   
</div>   
 <div class="field">
    <label class="label">Category*</label>
    <div class="control">
           <input type="hidden" name="parent_id" value="{{$dataObj->category_id}}">
            <select dir="rtl" disabled="disabled" class="input" name="parentd">
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
    <label class="label">Product Title*</label>
    <div class="control">
         <input dir="rtl" class="input" value="{{$dataObj->title}}" type="text" name="title" required="required">

    </div>
   
</div>

 <div class="field" style="display: none;">
    <label class="label">Product Size*</label>
    <div class="control">
                <input dir="rtl" class="input" value="{{$dataObj->product_size}}" type="text" name="product_size" required="required">

    </div>
   
</div>

  <div class="field" style="display: none;">
    <label class="label">SKU*</label>
    <div class="control">
     <input dir="rtl" class="input" placeholder="120 ml e.g" value="{{$dataObj->sku}}" type="text" name="sku">

    </div>
   
</div>
 


            <div class="field">
    <label class="label">Description*</label>
    <div class="control">
    <textarea dir="rtl" id="description"  name="description" class="ckeditor textarea trumbowyg-textarea">{!! $dataObj->description !!}</textarea>

    </div>
   
</div>
 <div class="field">
    <label class="label">Nutritional Info. *</label>
    <div class="control">

                <textarea dir="rtl" id="editor_new"  name="nutritional_info" class="ckeditor textarea trumbowyg-textarea">{!! $dataObj->nutritional_info !!}</textarea>

    </div>
   
</div>

<input type="hidden" name="price" value="{{$dataObj->price}}">

 <input type="hidden" name="filename" value="{{$dataObj->image}}">
     <input type="hidden" name="id" value="{{$dataObj->id}}">
            
    



            <div class="control">
  
    <button type="submit" class="button is-info">Save</button>
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
<script src="{{asset('dist/ckeditor/jquery.min.js')}}"></script>
<script src="{{ asset('dist/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('dist/ckeditor/ar.js') }}"></script>
<script type="text/javascript">
$(document).ready(function(){
    ClassicEditor
    .create( document.querySelector( '#editor_new' ), {
        language: {
            ui: 'ar',
            content: 'ar'
        }
    })
    .then( editor => {
        window.editor = editor;
    })
    .catch( err => {
        console.error( err.stack );
    });
    ClassicEditor
    .create( document.querySelector( '#description' ), {
        language: {
            ui: 'ar',
            content: 'ar'
        }
    })
    .then( editor => {
        window.editor = editor;
    })
    .catch( err => {
        console.error( err.stack );
    });
    });


</script>

@endsection

