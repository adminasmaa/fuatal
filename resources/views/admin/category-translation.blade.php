@extends('layouts.admin')

@section('content')
    <section class="section">
        <div class="container-fluid">
            <div class="card no-box-shadow-mobile">
            	 <header class="card-header">
                    <p class="card-header-title">
                        {{ 'Category Translation' }}
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
     

    <form method="POST" enctype="multipart/form-data" action="{{url('admin/translate/category/save')}}">
         @csrf
         <input type="hidden" name="trans_id" value="{{$dataObj->trans_id}}">
         <input type="hidden" name="color_code" value="{{$dataObj->color_code}}" />

 <div class="field">
    <label class="label">Language*</label>
    <div class="control">

            <select dir="rtl" class="input" name="lang_name" required="required">
               
               @foreach($langObj as $item)
               @if($item->lang_name!='English')
               <option value="{{$item->lang_name}}" selected="selected">{{$item->lang_name}}</option>
               @endif
               @endforeach
            </select>

    </div>
   
</div>

        <div class="field">
    <label class="label">Parent</label> 
    <input type="hidden" name="parent_id" value="{{$dataObj->parent_id}}">
    <div class="control">

            <select dir="rtl" class="input" name="Parent" disabled="disabled">
                @foreach($catObj as $category)
               @if($dataObj->parent_id == $category->id)
               <option selected="selected" value="{{$category->parent_id}}">{{$category->title}}</option> 
               @else
               <option value="{{$category->parent_id}}" >{{$category->title}}</option> 
               @endif
               @endforeach
            </select>

    </div>
   
</div>

            <div class="field">
    <label class="label">Category Title*</label>
    <div class="control">
        <label class="label">English title</label>
             <input disabled readonly class="input" value="{{$dataObj->title}}" type="text" name="title_english">
             <input dir="rtl" class="input" type="text" name="title" required>

    </div>
   
</div>
            <div class="field" style="display:none;">
    <label class="label">Description*</label>
    <div class="control">
                <input dir="rtl" class="input" value="{{$dataObj->description}}" type="text" name="description">

    </div>
   
</div>


     <input type="hidden" name="id" value="{{$dataObj->id}}">
             <input type="hidden" name="filename" value="{{$dataObj->cat_image}}">
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

@endsection
  <script type="text/javascript">

        
function deleteRecord(id){
        if(confirm('Are you sure?')){
        var url="{{url('admin/delete/cat')}}";
        //alert(url);
        $.get(url,{id:id},function(arg) {
          location.reload();
            // body...
        });
    }
}


</script>

