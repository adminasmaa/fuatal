@extends('layouts.admin')

@section('content')
    <section class="section">
        <div class="container-fluid">
            <div class="card no-box-shadow-mobile">
            	 <header class="card-header">
                    <p class="card-header-title">
                        {{ 'Edit Page Translation' }}
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
        
    <form method="POST" enctype="multipart/form-data" action="{{url('admin/translate/page/update')}}">
         @csrf
         <input type="hidden" name="trans_id" value="{{$dataObj->trans_id}}">
       

 <div class="field">
    <label class="label">Language</label>
    <div class="control">

            <select class="input" name="lang_name">
               <option value="" selected="selected">--Select--</option>
               @foreach($langObj as $item)
               @if($item->lang_name!='English')
               <option {{$item->lang_name==$dataObj->lang_name?'selected':''}} value="{{$item->lang_name}}">{{$item->lang_name}}</option>
               @endif
               @endforeach
            </select>

    </div>
   
</div>   
 <div class="field">
    <label class="label">Parent</label>
    <div class="control">
            <select class="input" name="parent_id">
                <option value="">None</option>
                @foreach($pageObj as $category)
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
    <label class="label">Page Title</label>
    <div class="control">
         <input class="input" value="{{$dataObj->title}}" type="text" name="title">

    </div>
   
</div>

  <div class="field">
    <label class="label">Content</label>
    <div class="control">
                <textarea id="editor"  class="textarea trumbowyg-textarea"  type="text" name="content">{!! $dataObj->content !!}</textarea>

    </div>
   
</div>


<div class="field">
    <label class="label">Description</label>
    <div class="control">
 
 <textarea name="description" class="textarea trumbowyg-textarea">{!! $dataObj->description !!}</textarea>

    </div>
   
</div>


 <input type="hidden" name="filename" value="{{$dataObj->page_image}}">
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



</script>

