@extends('layouts.admin')

@section('content')
    <section class="section">
        <div class="container-fluid">
            <div class="card no-box-shadow-mobile">
            	 <header class="card-header">
                    <p class="card-header-title">
                        {{ 'Recipe Detail' }}
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
        
   
<br>
</div>


           
            	<table id="dataTableBuilder" class="table dataTable no-footer">
            	<thead>
                    
            		<th>Image</th>
                    <th>Category</th>
                    <th>Title</th>
            		<th>Description</th>
            		<th>Action</th>
            	</thead>
            	<tbody>
            		@foreach($recipeObj as $item)
            		
            		<tr>
                       
            		<td>
            			@if(is_null($item->article_image))
            			<img width="70px" src="{{URL::asset('uploads/categories/')}}">
            			@else
            			<img width="70px" src="{{URL::asset('uploads/categories/'.$item->article_image)}}">
            			@endif
            		</td>
                     <td>{{$item->cat_title}}</td>
            		<td>{{$item->title}}</td>
                    <!-- -->	
            		<td>{{$item->description}}</td>	

                     <td>
    <form class="is-inline" method="POST" action="{{url('/admin/article'.'/'.$item->id)}}">
           @csrf
                       <input type="hidden" name="_method" value="DELETE"> 
                       <input type="hidden" name="id" value="{{$item->id}}">           
                       <button class="button is-small is-danger" type="submit" onclick="return confirm('Are you sure?')">
                <span class="icon">
                    <svg viewBox="0 0 32 32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                        <path d="M28 6 L6 6 8 30 24 30 26 6 4 6 M16 12 L16 24 M21 12 L20 24 M11 12 L12 24 M12 6 L13 2 19 2 20 6"></path>
                    </svg>
                </span>
                <span>Delete</span>
            </button>
        </form> 

  @if($item->lang_name=='English')
            <a class="button is-small is-primary" href="{{url('admin/article/'.$item->id.'/edit')}}">
            <span class="icon">
                <svg viewBox="0 0 32 32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                    <path d="M30 7 L25 2 5 22 3 29 10 27 Z M21 6 L26 11 Z M5 22 L10 27 Z"></path>
                </svg>
            </span>
            <span>Edit</span>
        </a>    
      @endif
@if($item->lang_name=='English' AND $item->trans_status!=1)
 <a title="Add Translation" class="button is-small" href="{{url('admin/translate/article'.'/'.$item->id)}}">
           Add Translation
        </a> 
@endif
 @if($item->lang_name=='Arabic')
    <a title="Edit Translation" class="button is-small" href="{{url('admin/translate/article/edit'.'/'.$item->id)}}">
          Edit Translation
        </a>   

@endif           

                        </td>
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
    <script type="text/javascript">$(function(){window.LaravelDataTables=window.LaravelDataTables||{};window.LaravelDataTables["dataTableBuilder"]=$("#dataTableBuilder").DataTable({
        'iDisplayLength': 50

        });});
</script>

@endsection
 

